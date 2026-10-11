<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Message;
use App\Models\User;
use App\Models\Vendor;
use App\Events\MessageSent;
use App\Events\MessageSeen;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Auth::check() || Auth::guard('vendor')->check()) {
                return $next($request);
            }

            return redirect()->guest(route('login'));
        });
    }

    public function index(Request $request)
    {
        $targetVendorId = $request->query('vendor_id');
        $targetUserId = $request->query('user_id');
        $initialContact = null;

        if ($targetVendorId && !Auth::guard('vendor')->check()) {
            $vendor = Vendor::find($targetVendorId);
            if ($vendor) {
                $initialContact = [
                    'id' => (int) $vendor->id,
                    'name' => $vendor->name ?? $vendor->username,
                    'type' => 'vendor'
                ];
            }
        } elseif ($targetUserId && Auth::guard('vendor')->check()) {
            $user = User::find($targetUserId);
            if ($user) {
                $initialContact = [
                    'id' => (int) $user->id,
                    'name' => $user->name,
                    'type' => 'user'
                ];
            }
        }

        return view('chat', compact('initialContact'));
    }

    public function getContacts()
    {
        $isVendor = Auth::guard('vendor')->check();
        $currentId = $isVendor ? Auth::guard('vendor')->id() : Auth::id();
        $currentClass = $isVendor ? Vendor::class : User::class;
        $otherClass = $isVendor ? User::class : Vendor::class;

        $sent = DB::table('messages')
            ->where('sender_id', $currentId)
            ->where('sender_type', $currentClass)
            ->where('receiver_type', $otherClass)
            ->selectRaw('receiver_id AS contact_id, receiver_type AS contact_type, MAX(created_at) AS last_message_at')
            ->groupBy('receiver_id', 'receiver_type');

        $received = DB::table('messages')
            ->where('receiver_id', $currentId)
            ->where('receiver_type', $currentClass)
            ->where('sender_type', $otherClass)
            ->selectRaw('sender_id AS contact_id, sender_type AS contact_type, MAX(created_at) AS last_message_at')
            ->groupBy('sender_id', 'sender_type');

        $contactSummary = DB::query()
            ->fromSub($sent->unionAll($received), 'contacts')
            ->select('contact_id', 'contact_type', DB::raw('MAX(last_message_at) as last_message_at'))
            ->groupBy('contact_id', 'contact_type')
            ->orderByDesc('last_message_at')
            ->get();

        if ($contactSummary->isEmpty()) {
            return response()->json([]);
        }

        $contactIds = $contactSummary->pluck('contact_id')->unique()->toArray();
        $contactModels = $otherClass::whereIn('id', $contactIds)->get(['id', 'name']);
        $contactMap = $contactModels->keyBy('id');

        $contacts = $contactSummary->map(function ($record) use ($contactMap, $currentId, $currentClass, $otherClass) {
            $contact = $contactMap->get($record->contact_id);
            if (!$contact) {
                return null;
            }

            $unreadCount = Message::where('sender_id', $record->contact_id)
                ->where('sender_type', $otherClass)
                ->where('receiver_id', $currentId)
                ->where('receiver_type', $currentClass)
                ->where('is_seen', false)
                ->count();

            return (object) [
                'id' => $contact->id,
                'name' => $contact->name,
                'unread_count' => $unreadCount,
                'last_message_at' => $record->last_message_at,
            ];
        })->filter()->values();

        return response()->json($contacts);
    }

    public function fetchMessages($receiverType, $receiverId)
    {
        $senderId = Auth::guard('vendor')->check() ? Auth::guard('vendor')->id() : Auth::id();
        $senderClass = Auth::guard('vendor')->check() ? Vendor::class : User::class;
        $receiverClass = $receiverType === 'vendor' ? Vendor::class : User::class;

        $messages = Message::where(function ($query) use ($senderId, $senderClass, $receiverId, $receiverClass) {
            $query->where('sender_id', $senderId)
                  ->where('sender_type', $senderClass)
                  ->where('receiver_id', $receiverId)
                  ->where('receiver_type', $receiverClass);
        })->orWhere(function ($query) use ($senderId, $senderClass, $receiverId, $receiverClass) {
            $query->where('sender_id', $receiverId)
                  ->where('sender_type', $receiverClass)
                  ->where('receiver_id', $senderId)
                  ->where('receiver_type', $senderClass);
        })->orderBy('created_at', 'asc')->get();

        return response()->json($messages);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id'   => 'required|integer',
            'receiver_type' => 'required|string|in:vendor,user',
            'message'       => 'nullable|string|max:5000',
            'attachment'    => 'nullable|file|mimes:jpeg,png,jpg,webp,pdf,doc,docx|max:10240',
            'location'      => 'nullable|string|max:1000'
        ]);

        $sanitizedMessage = $request->filled('message') ? strip_tags($request->message) : null;

        $senderId = Auth::guard('vendor')->check() ? Auth::guard('vendor')->id() : Auth::id();
        $senderClass = Auth::guard('vendor')->check() ? Vendor::class : User::class;
        $receiverClass = $request->receiver_type === 'vendor' ? Vendor::class : User::class;

        $attachmentPath = null;
        $attachmentType = null;

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $extension = strtolower($file->getClientOriginalExtension());
            $filename = time() . '_' . uniqid() . '.' . ($extension === 'jpeg' ? 'jpg' : $extension);
            $storagePath = 'chat_attachments/' . $filename;

            if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                $manager = new ImageManager(new Driver());
                $image = $manager->make($file->getRealPath());
                $image->encode('jpg', 75);
                Storage::disk('local')->put($storagePath, $image->__toString());
                $attachmentType = 'image';
            } else {
                Storage::disk('local')->putFileAs('chat_attachments', $file, $filename);
                $attachmentType = 'file';
            }

            $attachmentPath = $storagePath;
        } elseif ($request->filled('location')) {
            $attachmentPath = $request->location;
            $attachmentType = 'location';
        }

        $message = Message::create([
            'sender_id' => $senderId,
            'sender_type' => $senderClass,
            'receiver_id' => $request->receiver_id,
            'receiver_type' => $receiverClass,
            'message' => $sanitizedMessage,
            'attachment' => $attachmentPath,
            'attachment_type' => $attachmentType,
            'is_seen' => false,
        ]);

        broadcast(new MessageSent($message->load('sender', 'receiver')))->toOthers();

        return response()->json($message);
    }

    public function markAsSeen(Request $request)
    {
        $receiverId = Auth::guard('vendor')->check() ? Auth::guard('vendor')->id() : Auth::id();
        $receiverClass = Auth::guard('vendor')->check() ? Vendor::class : User::class;
        $senderType = $request->sender_type === 'vendor' ? Vendor::class : User::class;
        $senderId = $request->sender_id;

        $messageIds = Message::where('receiver_id', $receiverId)
               ->where('receiver_type', $receiverClass)
               ->where('sender_id', $senderId)
               ->where('sender_type', $senderType)
               ->where('is_seen', false)
               ->pluck('id')
               ->toArray();

        Message::where('receiver_id', $receiverId)
               ->where('receiver_type', $receiverClass)
               ->where('sender_id', $senderId)
               ->where('sender_type', $senderType)
               ->where('is_seen', false)
               ->update(['is_seen' => true]);

        if (!empty($messageIds)) {
            broadcast(new MessageSeen($messageIds, $request->sender_type, $senderId))->toOthers();
        }

        return response()->json(['status' => 'success', 'message_ids' => $messageIds]);
    }

    public function downloadAttachment(Message $message)
    {
        $isVendor = Auth::guard('vendor')->check();
        $currentId = $isVendor ? Auth::guard('vendor')->id() : Auth::id();
        $currentClass = $isVendor ? Vendor::class : User::class;

        $allowed = (
            $message->sender_id === $currentId && $message->sender_type === $currentClass
        ) || (
            $message->receiver_id === $currentId && $message->receiver_type === $currentClass
        );

        if (!$allowed || !$message->attachment || $message->attachment_type === 'location') {
            abort(403);
        }

        if (!Storage::disk('local')->exists($message->attachment)) {
            abort(404);
        }

        return Storage::disk('local')->download($message->attachment, basename($message->attachment));
    }
}

