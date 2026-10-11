<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Validator;

class NotificationController extends Controller
{
    // Store Contact Form data
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'vendor_id' => 'nullable|integer|exists:vendors,id',
            'name'      => 'required|string|max:100',
            'phone'     => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:20',
            'budget'    => 'nullable|numeric|min:0',
            'message'   => 'required|string|max:1000'
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['error' => $validator->errors()->all()], 422);
            }
            return back()->withErrors($validator)->withInput();
        }

        Notification::create([
            'user_id'   => \Illuminate\Support\Facades\Auth::id(),
            'vendor_id' => $request->input('vendor_id'),
            'name'      => strip_tags($request->input('name')),
            'phone'     => strip_tags($request->input('phone')),
            'budget'    => $request->input('budget'),
            'message'   => strip_tags($request->input('message')),
            'is_read'   => 0
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => 'We have received your enquiry and notified the service provider.']);
        }

        return back()->with('success', 'We have received your message and would like to thank you for writing to us.');
    }
}
