<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BusinessHour;
use App\Models\Notification;
use App\Models\Profile;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    /**
     * Helper: Calculate and generate discrete time slots for a vendor on a specific date,
     * factoring in slot duration, window intervals, and slot capacities against existing bookings.
     *
     * @param int|string $vendorId
     * @param string $date (Y-m-d)
     * @return array
     */
    public function calculateVendorSlots($vendorId, $date)
    {
        try {
            $carbonDate = Carbon::parse($date);
        } catch (\Exception $e) {
            return [
                'is_closed'       => true,
                'reason'          => 'Invalid date format',
                'slot_duration'   => 30,
                'all_slots'       => [],
                'available_slots' => [],
                'all_full'        => false,
            ];
        }

        $formattedDate = $carbonDate->format('Y-m-d');
        $businessHour = BusinessHour::where('vendor_id', $vendorId)->first();

        // Slot duration in minutes (default 30, range 1 to 1440)
        $duration = 30;
        if ($businessHour && !empty($businessHour->slot_duration)) {
            $duration = (int) $businessHour->slot_duration;
            if ($duration < 1 || $duration > 1440) {
                $duration = 30;
            }
        }

        // 1. Check special dates (vacation / custom holiday / special hours)
        $specialDates = $businessHour->special_dates ?? [];
        $isSpecialDate = false;
        $windows = [];

        foreach ($specialDates as $special) {
            $from = $special['from_date'] ?? null;
            $to = $special['to_date'] ?? null;
            if ($from && $to && $formattedDate >= $from && $formattedDate <= $to) {
                $isSpecialDate = true;
                if (!empty($special['is_closed'])) {
                    return [
                        'is_closed'       => true,
                        'reason'          => 'Vendor is closed on this special date / holiday',
                        'slot_duration'   => $duration,
                        'all_slots'       => [],
                        'available_slots' => [],
                        'all_full'        => false,
                    ];
                }
                if (!empty($special['slots'])) {
                    $windows = $special['slots'];
                }
                break;
            }
        }

        // 2. If not a special date, check weekly hours (0 = Sunday, 1 = Monday, ...)
        if (!$isSpecialDate) {
            if (!$businessHour) {
                // Default fallback: 09:00 AM - 06:00 PM with default duration
                $windows = [
                    ['open_time' => '09:00', 'close_time' => '18:00', 'capacity' => 1],
                ];
            } else {
                $dayOfWeek = $carbonDate->dayOfWeek;
                $weekly = $businessHour->weekly_hours ?? [];
                $dayConfig = null;
                foreach ($weekly as $item) {
                    if (isset($item['day_of_week']) && (int) $item['day_of_week'] === $dayOfWeek) {
                        $dayConfig = $item;
                        break;
                    }
                }

                if (!$dayConfig || !empty($dayConfig['is_closed'])) {
                    return [
                        'is_closed'       => true,
                        'reason'          => 'Vendor is closed on this day of the week',
                        'slot_duration'   => $duration,
                        'all_slots'       => [],
                        'available_slots' => [],
                        'all_full'        => false,
                    ];
                }

                $windows = $dayConfig['slots'] ?? [];
                if (empty($windows)) {
                    $windows = [
                        ['open_time' => '09:00', 'close_time' => '18:00', 'capacity' => 1],
                    ];
                }
            }
        }

        // 3. Generate segmented discrete time slots according to duration
        $allGeneratedSlots = [];

        foreach ($windows as $win) {
            $open = trim($win['open_time'] ?? ($win['open'] ?? '09:00'));
            $close = trim($win['close_time'] ?? ($win['close'] ?? '18:00'));
            $capacity = isset($win['capacity']) ? max(1, min(100, (int) $win['capacity'])) : 1;

            if ($open === '' || $close === '') {
                continue;
            }

            try {
                // Handle 24/7 setting (00:00 to 23:59 or 24:00) by expanding to business working hours
                if ($open === '00:00' && in_array($close, ['23:59', '24:00', '23:59:59'])) {
                    $startCarbon = Carbon::parse($formattedDate . ' 09:00:00');
                    $endCarbon   = Carbon::parse($formattedDate . ' 18:00:00');
                } else {
                    $startCarbon = Carbon::parse($formattedDate . ' ' . $open);
                    $endCarbon   = Carbon::parse($formattedDate . ' ' . $close);
                }
            } catch (\Exception $e) {
                continue;
            }

            if ($startCarbon->gte($endCarbon)) {
                continue;
            }

            $cursor = $startCarbon->copy();
            while ($cursor->copy()->addMinutes($duration)->lte($endCarbon)) {
                $next = $cursor->copy()->addMinutes($duration);
                $slotLabel = $cursor->format('h:i A') . ' - ' . $next->format('h:i A');

                if (!isset($allGeneratedSlots[$slotLabel])) {
                    $allGeneratedSlots[$slotLabel] = [
                        'slot'     => $slotLabel,
                        'capacity' => $capacity,
                    ];
                } else {
                    // If multiple windows overlap or merge, take max capacity
                    $allGeneratedSlots[$slotLabel]['capacity'] = max($allGeneratedSlots[$slotLabel]['capacity'], $capacity);
                }

                $cursor = $next;
            }
        }

        if (empty($allGeneratedSlots)) {
            return [
                'is_closed'       => false,
                'reason'          => 'No slots available for the given hours and duration.',
                'slot_duration'   => $duration,
                'all_slots'       => [],
                'available_slots' => [],
                'all_full'        => true,
            ];
        }

        // 4. Query active bookings on this date to compute slot utilization and capacity
        $activeBookings = Booking::where('vendor_id', $vendorId)
            ->whereDate('booking_date', $formattedDate)
            ->whereIn('status', ['pending', 'confirmed'])
            ->selectRaw('booking_time_slot, count(*) as booked_count')
            ->groupBy('booking_time_slot')
            ->pluck('booked_count', 'booking_time_slot')
            ->toArray();

        $allSlotDetails = [];
        $availableSlots = [];

        foreach ($allGeneratedSlots as $slotLabel => $info) {
            $cap = $info['capacity'];
            $booked = $activeBookings[$slotLabel] ?? 0;
            $isFull = $booked >= $cap;
            $remaining = max(0, $cap - $booked);

            $detail = [
                'slot'      => $slotLabel,
                'capacity'  => $cap,
                'booked'    => $booked,
                'remaining' => $remaining,
                'is_full'   => $isFull,
            ];

            $allSlotDetails[] = $detail;

            if (!$isFull) {
                $availableSlots[] = $slotLabel;
            }
        }

        $allFull = count($allSlotDetails) > 0 && count($availableSlots) === 0;

        return [
            'is_closed'       => false,
            'reason'          => $allFull ? 'All appointment slots on this date are fully booked' : null,
            'slot_duration'   => $duration,
            'all_slots'       => $allSlotDetails,
            'available_slots' => $availableSlots,
            'all_full'        => $allFull,
        ];
    }

    /**
     * Store new booking request from client / public profile
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'vendor_id'         => 'required|exists:vendors,id',
            'customer_name'     => 'required|string|max:150',
            'customer_phone'    => 'required|string|max:20',
            'customer_email'    => 'nullable|email|max:150',
            'booking_date'      => 'required|date|after_or_equal:today',
            'booking_time_slot' => 'required|string|max:80',
            'booking_address'   => 'required|string|max:500',
            'service_title'     => 'nullable|string|max:150',
            'notes'             => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['error' => $validator->errors()->all()], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // 1. Validate schedule, slots, and capacity
        $schedule = $this->calculateVendorSlots($request->vendor_id, $request->booking_date);

        if ($schedule['is_closed']) {
            $msg = $schedule['reason'] ?? 'Vendor is closed on the selected date.';
            if ($request->ajax()) {
                return response()->json(['error' => [$msg]], 422);
            }
            return redirect()->back()->withErrors(['booking_date' => $msg])->withInput();
        }

        $requestedSlot = trim($request->booking_time_slot);
        $matchingSlot = null;
        foreach ($schedule['all_slots'] as $s) {
            if (trim($s['slot']) === $requestedSlot) {
                $matchingSlot = $s;
                break;
            }
        }

        if (!$matchingSlot) {
            $msg = 'The selected time slot is invalid for this date. Please choose an available time slot.';
            if ($request->ajax()) {
                return response()->json(['error' => [$msg]], 422);
            }
            return redirect()->back()->withErrors(['booking_time_slot' => $msg])->withInput();
        }

        if ($matchingSlot['is_full']) {
            $msg = "This time slot ({$requestedSlot}) is already fully booked. Please select another slot or date.";
            if ($request->ajax()) {
                return response()->json(['error' => [$msg]], 422);
            }
            return redirect()->back()->withErrors(['booking_time_slot' => $msg])->withInput();
        }

        $profile = Profile::where('vendor_id', $request->vendor_id)->first();
        $price = $profile->price_per_hour ?? null;
        $serviceTitle = trim($request->service_title ?? ($profile->occupation->occupation_name ?? 'General Service'));

        // 2. Prevent booking if user already has a CONFIRMED booking for same service on same date
        $userId = Auth::id();
        $userPhone = $request->customer_phone;
        $alreadyConfirmed = Booking::whereDate('booking_date', $request->booking_date)
            ->where(function ($q) use ($userId, $userPhone) {
                if ($userId) {
                    $q->where('user_id', $userId);
                } else {
                    $q->where('customer_phone', $userPhone);
                }
            })
            ->whereRaw('LOWER(TRIM(service_title)) = ?', [strtolower($serviceTitle)])
            ->where('status', 'confirmed')
            ->first();

        if ($alreadyConfirmed) {
            $msg = "You already have a confirmed appointment for '{$serviceTitle}' on this date (Ref: {$alreadyConfirmed->booking_reference}). You cannot book another vendor for the same service on the same date.";
            if ($request->ajax()) {
                return response()->json(['error' => [$msg]], 422);
            }
            return redirect()->back()->withErrors(['booking_date' => $msg])->withInput();
        }

        // 3. Concurrency check & record insertion inside atomic transaction
        try {
            $booking = DB::transaction(function () use ($request, $profile, $price, $serviceTitle, $matchingSlot, $requestedSlot) {
                // Lock and re-verify slot capacity against race conditions
                $currentBooked = Booking::where('vendor_id', $request->vendor_id)
                    ->whereDate('booking_date', $request->booking_date)
                    ->where('booking_time_slot', $requestedSlot)
                    ->whereIn('status', ['pending', 'confirmed'])
                    ->lockForUpdate()
                    ->count();

                if ($currentBooked >= $matchingSlot['capacity']) {
                    throw new \Exception("This time slot has just reached full capacity. Please select another time slot.");
                }

                // Generate unique reference code
                do {
                    $reference = 'BK-' . strtoupper(Str::random(6));
                } while (Booking::where('booking_reference', $reference)->exists());

                return Booking::create([
                    'booking_reference' => $reference,
                    'vendor_id'         => $request->vendor_id,
                    'user_id'           => Auth::id(),
                    'customer_name'     => $request->customer_name,
                    'customer_phone'    => $request->customer_phone,
                    'customer_email'    => $request->customer_email,
                    'service_title'     => $serviceTitle,
                    'booking_date'      => $request->booking_date,
                    'booking_time_slot' => $requestedSlot,
                    'booking_address'   => $request->booking_address,
                    'notes'             => $request->notes,
                    'price'             => $price,
                    'status'            => 'pending',
                ]);
            });
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['error' => [$e->getMessage()]], 422);
            }
            return redirect()->back()->withErrors(['booking_time_slot' => $e->getMessage()])->withInput();
        }

        // Create vendor notification
        try {
            Notification::create([
                'user_id'   => Auth::id() ?? 0,
                'vendor_id' => $request->vendor_id,
                'name'      => $request->customer_name,
                'phone'     => $request->customer_phone,
                'budget'    => $price ? (string) $price : '0',
                'message'   => "New Appointment Booking [{$booking->booking_reference}]: {$request->booking_date} at {$requestedSlot}. Address: {$request->booking_address}",
                'is_read'   => 0,
            ]);
        } catch (\Exception $e) {
            // Notification table fallback
        }

        if ($request->ajax()) {
            return response()->json([
                'success'   => true,
                'message'   => 'Your appointment has been booked successfully!',
                'reference' => $booking->booking_reference,
                'booking'   => $booking,
            ]);
        }

        return redirect()->back()->with('success', "Appointment booked successfully! Your Booking Reference is: {$booking->booking_reference}");
    }

    /**
     * Get available slots for a vendor on a specific date (AJAX endpoint)
     */
    public function getAvailableSlots($vendorId, $date)
    {
        $result = $this->calculateVendorSlots($vendorId, $date);

        return response()->json([
            'is_closed'     => $result['is_closed'],
            'reason'        => $result['reason'],
            'slot_duration' => $result['slot_duration'],
            'slots'         => $result['available_slots'],
            'all_slots'     => $result['all_slots'],
            'all_full'      => $result['all_full'],
        ]);
    }

    /**
     * Vendor Dashboard: Bookings Management Listing
     */
    public function vendorBookings(Request $request)
    {
        $vendorId = Auth::guard('vendor')->id();
        $status = $request->query('status', 'all');
        $search = $request->query('search', '');

        $query = Booking::where('vendor_id', $vendorId);

        if ($status !== 'all' && in_array($status, ['pending', 'confirmed', 'completed', 'cancelled'])) {
            $query->where('status', $status);
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                  ->orWhere('booking_reference', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%")
                  ->orWhere('service_title', 'like', "%{$search}%");
            });
        }

        $bookings = $query->orderBy('booking_date', 'desc')
                          ->orderBy('id', 'desc')
                          ->paginate(10);

        // Stats counters for quick dashboard cards
        $totalCount     = Booking::where('vendor_id', $vendorId)->count();
        $pendingCount   = Booking::where('vendor_id', $vendorId)->where('status', 'pending')->count();
        $confirmedCount = Booking::where('vendor_id', $vendorId)->where('status', 'confirmed')->count();
        $completedCount = Booking::where('vendor_id', $vendorId)->where('status', 'completed')->count();
        $cancelledCount = Booking::where('vendor_id', $vendorId)->where('status', 'cancelled')->count();

        return view('vendor.bookings', compact(
            'bookings',
            'status',
            'search',
            'totalCount',
            'pendingCount',
            'confirmedCount',
            'completedCount',
            'cancelledCount'
        ));
    }

    /**
     * Update Booking Status (Confirm, Complete, Cancel)
     * Rule: When a vendor confirms a booking, any other pending bookings
     * of the same user for the same service on the same date are automatically cancelled.
     * Also prevents another vendor from confirming if user already has a confirmed booking for that service & date.
     */
    public function updateStatus(Request $request, $id)
    {
        $vendorId = Auth::guard('vendor')->id();
        $booking = Booking::where('id', $id)->where('vendor_id', $vendorId)->firstOrFail();

        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);

        $newStatus = $request->status;

        if ($newStatus === 'confirmed') {
            // Check if user already has another CONFIRMED booking for this same service on this same date
            $alreadyConfirmed = Booking::where('id', '!=', $booking->id)
                ->where(function ($q) use ($booking) {
                    if ($booking->user_id) {
                        $q->where('user_id', $booking->user_id);
                    } else {
                        $q->where('customer_phone', $booking->customer_phone);
                    }
                })
                ->whereDate('booking_date', $booking->booking_date)
                ->whereRaw('LOWER(TRIM(service_title)) = ?', [strtolower(trim($booking->service_title))])
                ->where('status', 'confirmed')
                ->first();

            if ($alreadyConfirmed) {
                $err = "Cannot confirm booking: This customer already has a confirmed booking for '{$booking->service_title}' on {$booking->booking_date->format('d M Y')} with another service provider ({$alreadyConfirmed->booking_reference}).";
                if ($request->ajax()) {
                    return response()->json(['error' => [$err]], 422);
                }
                return redirect()->back()->with('error', $err);
            }

            // Update this booking to confirmed
            $booking->update([
                'status' => 'confirmed',
            ]);

            // Automatically cancel all other pending bookings of this user on the same date for the same service
            $otherPendingBookings = Booking::where('id', '!=', $booking->id)
                ->where(function ($q) use ($booking) {
                    if ($booking->user_id) {
                        $q->where('user_id', $booking->user_id);
                    } else {
                        $q->where('customer_phone', $booking->customer_phone);
                    }
                })
                ->whereDate('booking_date', $booking->booking_date)
                ->whereRaw('LOWER(TRIM(service_title)) = ?', [strtolower(trim($booking->service_title))])
                ->where('status', 'pending')
                ->get();

            $autoCancelledCount = 0;
            foreach ($otherPendingBookings as $other) {
                $other->update([
                    'status' => 'cancelled',
                    'notes'  => trim(($other->notes ? $other->notes . "\n" : '') . "[Auto-cancelled: Customer appointment for {$booking->service_title} on {$booking->booking_date->format('d M Y')} confirmed by provider #{$booking->vendor_id} ({$booking->booking_reference})]")
                ]);
                $autoCancelledCount++;

                // Notify other vendor
                try {
                    Notification::create([
                        'user_id'   => $booking->user_id ?? 0,
                        'vendor_id' => $other->vendor_id,
                        'name'      => $other->customer_name,
                        'phone'     => $other->customer_phone,
                        'budget'    => '0',
                        'message'   => "Booking [{$other->booking_reference}] for {$other->customer_name} was auto-cancelled because customer's appointment was confirmed by another service provider.",
                        'is_read'   => 0,
                    ]);
                } catch (\Exception $e) {}
            }

            $successMsg = "Booking {$booking->booking_reference} confirmed successfully!";
            if ($autoCancelledCount > 0) {
                $successMsg .= " Automatically cancelled {$autoCancelledCount} other pending request(s) for {$booking->service_title} on this date.";
            }

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => $successMsg,
                    'status'  => $booking->status,
                    'badge'   => $booking->status_badge,
                ]);
            }

            return redirect()->back()->with('success', $successMsg);
        }

        // For other status changes (completed, cancelled, pending)
        $booking->update([
            'status' => $newStatus,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Booking {$booking->booking_reference} marked as " . ucfirst($newStatus),
                'status'  => $booking->status,
                'badge'   => $booking->status_badge,
            ]);
        }

        return redirect()->back()->with('success', "Booking {$booking->booking_reference} has been marked as " . ucfirst($newStatus));
    }

    /**
     * Delete booking (Vendor)
     */
    public function destroy($id)
    {
        $vendorId = Auth::guard('vendor')->id();
        $booking = Booking::where('id', $id)->where('vendor_id', $vendorId)->firstOrFail();
        $ref = $booking->booking_reference;
        $booking->delete();

        return redirect()->back()->with('success', "Booking {$ref} deleted successfully.");
    }

    /**
     * User Bookings Listing Page
     * Shows all bookings made by the current user, selected time slots, and real-time status.
     */
    public function userBookings(Request $request)
    {
        $status = $request->query('status', 'all');
        $search = $request->query('search', '');
        $user = Auth::guard('web')->user();

        $query = Booking::with(['vendor.profile.city', 'vendor.profile.occupation']);

        $guestRef = trim($request->query('ref', ''));
        $guestPhone = trim($request->query('phone', ''));

        if ($user) {
            $query->where(function ($q) use ($user) {
                $q->where('user_id', $user->id)
                  ->orWhere('customer_email', $user->email);
                if (!empty($user->mobile)) {
                    $q->orWhere('customer_phone', $user->mobile);
                }
            });
        } elseif (!empty($guestRef) || !empty($guestPhone)) {
            $query->where(function ($q) use ($guestRef, $guestPhone) {
                if (!empty($guestRef)) {
                    $q->where('booking_reference', $guestRef);
                }
                if (!empty($guestPhone)) {
                    $q->orWhere('customer_phone', $guestPhone);
                }
            });
        } else {
            // Guest without filter - render page with lookup search prompt
            return view('user.bookings', [
                'bookings'             => collect(),
                'status'               => 'all',
                'search'               => '',
                'guestRef'             => '',
                'guestPhone'           => '',
                'totalCount'           => 0,
                'pendingCount'         => 0,
                'confirmedCount'       => 0,
                'completedCount'       => 0,
                'cancelledCount'       => 0,
                'requireLoginOrSearch' => true,
            ]);
        }

        // Filter by status
        if ($status !== 'all' && in_array($status, ['pending', 'confirmed', 'completed', 'cancelled'])) {
            $query->where('status', $status);
        }

        // Search
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('booking_reference', 'like', "%{$search}%")
                  ->orWhere('service_title', 'like', "%{$search}%")
                  ->orWhere('booking_address', 'like', "%{$search}%")
                  ->orWhereHas('vendor', function ($vq) use ($search) {
                      $vq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Compute counts before status filter
        $countQuery = Booking::query();
        if ($user) {
            $countQuery->where(function ($q) use ($user) {
                $q->where('user_id', $user->id)
                  ->orWhere('customer_email', $user->email);
                if (!empty($user->mobile)) {
                    $q->orWhere('customer_phone', $user->mobile);
                }
            });
        } else {
            $countQuery->where(function ($q) use ($guestRef, $guestPhone) {
                if (!empty($guestRef)) $q->where('booking_reference', $guestRef);
                if (!empty($guestPhone)) $q->orWhere('customer_phone', $guestPhone);
            });
        }

        $totalCount     = (clone $countQuery)->count();
        $pendingCount   = (clone $countQuery)->where('status', 'pending')->count();
        $confirmedCount = (clone $countQuery)->where('status', 'confirmed')->count();
        $completedCount = (clone $countQuery)->where('status', 'completed')->count();
        $cancelledCount = (clone $countQuery)->where('status', 'cancelled')->count();

        $bookings = $query->orderBy('booking_date', 'desc')
                          ->orderBy('id', 'desc')
                          ->paginate(10);

        return view('user.bookings', compact(
            'bookings',
            'status',
            'search',
            'guestRef',
            'guestPhone',
            'totalCount',
            'pendingCount',
            'confirmedCount',
            'completedCount',
            'cancelledCount'
        ))->with('requireLoginOrSearch', false);
    }

    /**
     * User can cancel their own pending appointment request
     */
    public function userCancelBooking(Request $request, $id)
    {
        $user = Auth::guard('web')->user();
        $booking = Booking::findOrFail($id);

        // Security authorization check
        if ($user) {
            $isOwner = ($booking->user_id == $user->id) 
                || ($booking->customer_email === $user->email)
                || (!empty($user->mobile) && $booking->customer_phone === $user->mobile);

            if (!$isOwner) {
                abort(403, 'Unauthorized access to this booking.');
            }
        } else {
            // Guest cancellation requires phone verification
            $phoneInput = trim($request->input('verify_phone', ''));
            if ($phoneInput !== $booking->customer_phone) {
                return redirect()->back()->with('error', 'Phone number verification failed.');
            }
        }

        if ($booking->status === 'cancelled') {
            return redirect()->back()->with('info', 'This booking is already cancelled.');
        }

        if ($booking->status === 'completed') {
            return redirect()->back()->with('error', 'Completed bookings cannot be cancelled.');
        }

        $booking->update([
            'status' => 'cancelled',
            'notes'  => trim(($booking->notes ? $booking->notes . "\n" : '') . '[Cancelled by customer on ' . now()->format('d M Y, h:i A') . ']')
        ]);

        // Notify vendor
        try {
            Notification::create([
                'user_id'   => $booking->user_id ?? 0,
                'vendor_id' => $booking->vendor_id,
                'name'      => $booking->customer_name,
                'phone'     => $booking->customer_phone,
                'budget'    => '0',
                'message'   => "Customer cancelled appointment [{$booking->booking_reference}] scheduled for {$booking->booking_date->format('d M Y')} at {$booking->booking_time_slot}.",
                'is_read'   => 0,
            ]);
        } catch (\Exception $e) {}

        return redirect()->back()->with('success', "Appointment {$booking->booking_reference} has been cancelled successfully.");
    }
}
