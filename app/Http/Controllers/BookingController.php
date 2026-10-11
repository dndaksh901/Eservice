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
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BookingController extends Controller
{
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
            'booking_time_slot' => 'required|string|max:50',
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

        $profile = Profile::where('vendor_id', $request->vendor_id)->first();
        $price = $profile->price_per_hour ?? null;

        // Generate unique reference code
        do {
            $reference = 'BK-' . strtoupper(Str::random(6));
        } while (Booking::where('booking_reference', $reference)->exists());

        $booking = Booking::create([
            'booking_reference' => $reference,
            'vendor_id'         => $request->vendor_id,
            'user_id'           => Auth::id(),
            'customer_name'     => $request->customer_name,
            'customer_phone'    => $request->customer_phone,
            'customer_email'    => $request->customer_email,
            'service_title'     => $request->service_title ?? ($profile->occupation->occupation_name ?? 'General Service'),
            'booking_date'      => $request->booking_date,
            'booking_time_slot' => $request->booking_time_slot,
            'booking_address'   => $request->booking_address,
            'notes'             => $request->notes,
            'price'             => $price,
            'status'            => 'pending',
        ]);

        // Create vendor notification so they receive an alert
        try {
            Notification::create([
                'user_id'   => Auth::id() ?? 0,
                'vendor_id' => $request->vendor_id,
                'name'      => $request->customer_name,
                'phone'     => $request->customer_phone,
                'budget'    => $price ? (string)$price : '0',
                'message'   => "New Appointment Booking [{$reference}]: {$request->booking_date} at {$request->booking_time_slot}. Address: {$request->booking_address}",
                'is_read'   => 0,
            ]);
        } catch (\Exception $e) {
            // Notification table fallback
        }

        if ($request->ajax()) {
            return response()->json([
                'success'   => true,
                'message'   => 'Your appointment has been booked successfully!',
                'reference' => $reference,
                'booking'   => $booking,
            ]);
        }

        return redirect()->back()->with('success', "Appointment booked successfully! Your Booking Reference is: {$reference}");
    }

    /**
     * Get available slots for a vendor on a specific date
     */
    public function getAvailableSlots($vendorId, $date)
    {
        try {
            $carbonDate = Carbon::parse($date);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid date format'], 400);
        }

        $businessHour = BusinessHour::where('vendor_id', $vendorId)->first();
        if (!$businessHour) {
            // Default hourly slots if not explicitly set
            $defaultSlots = [
                '09:00 AM - 10:00 AM',
                '10:00 AM - 11:00 AM',
                '11:00 AM - 12:00 PM',
                '01:00 PM - 02:00 PM',
                '02:00 PM - 03:00 PM',
                '03:00 PM - 04:00 PM',
                '04:00 PM - 05:00 PM',
                '05:00 PM - 06:00 PM',
            ];
            return response()->json(['is_closed' => false, 'slots' => $defaultSlots]);
        }

        $formattedDate = $carbonDate->format('Y-m-d');

        // 1. Check special dates (vacation / custom holiday)
        $specialDates = $businessHour->special_dates ?? [];
        foreach ($specialDates as $special) {
            $from = $special['from_date'] ?? null;
            $to = $special['to_date'] ?? null;
            if ($from && $to && $formattedDate >= $from && $formattedDate <= $to) {
                if (!empty($special['is_closed'])) {
                    return response()->json(['is_closed' => true, 'slots' => [], 'reason' => 'Closed on special date / holiday']);
                }
                if (!empty($special['slots'])) {
                    $slots = [];
                    foreach ($special['slots'] as $s) {
                        $slots[] = ($s['open_time'] ?? '09:00') . ' - ' . ($s['close_time'] ?? '18:00');
                    }
                    return response()->json(['is_closed' => false, 'slots' => $slots]);
                }
            }
        }

        // 2. Check weekly day of week (0 = Sunday, 1 = Monday, ...)
        $dayOfWeek = $carbonDate->dayOfWeek;
        $weekly = $businessHour->weekly_hours ?? [];
        $dayConfig = null;
        foreach ($weekly as $item) {
            if (isset($item['day_of_week']) && (int)$item['day_of_week'] === $dayOfWeek) {
                $dayConfig = $item;
                break;
            }
        }

        if (!$dayConfig || !empty($dayConfig['is_closed'])) {
            return response()->json(['is_closed' => true, 'slots' => [], 'reason' => 'Closed on this day of week']);
        }

        $slots = [];
        if (!empty($dayConfig['slots'])) {
            foreach ($dayConfig['slots'] as $s) {
                $open = $s['open_time'] ?? ($s['open'] ?? '09:00');
                $close = $s['close_time'] ?? ($s['close'] ?? '18:00');

                // If full day 00:00 - 23:59, split into clean 1-hour slots
                if ($open === '00:00' && ($close === '23:59' || $close === '24:00')) {
                    $slots = [
                        '09:00 AM - 10:00 AM',
                        '10:00 AM - 11:00 AM',
                        '11:00 AM - 12:00 PM',
                        '12:00 PM - 01:00 PM',
                        '02:00 PM - 03:00 PM',
                        '03:00 PM - 04:00 PM',
                        '04:00 PM - 05:00 PM',
                        '05:00 PM - 06:00 PM',
                    ];
                    break;
                } else {
                    $slots[] = Carbon::parse($open)->format('h:i A') . ' - ' . Carbon::parse($close)->format('h:i A');
                }
            }
        } else {
            $slots = ['09:00 AM - 12:00 PM', '02:00 PM - 06:00 PM'];
        }

        return response()->json(['is_closed' => false, 'slots' => $slots]);
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
     */
    public function updateStatus(Request $request, $id)
    {
        $vendorId = Auth::guard('vendor')->id();
        $booking = Booking::where('id', $id)->where('vendor_id', $vendorId)->firstOrFail();

        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);

        $booking->update([
            'status' => $request->status,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Booking {$booking->booking_reference} marked as " . ucfirst($request->status),
                'status'  => $booking->status,
                'badge'   => $booking->status_badge,
            ]);
        }

        return redirect()->back()->with('success', "Booking {$booking->booking_reference} has been marked as " . ucfirst($request->status));
    }

    /**
     * Delete booking
     */
    public function destroy($id)
    {
        $vendorId = Auth::guard('vendor')->id();
        $booking = Booking::where('id', $id)->where('vendor_id', $vendorId)->firstOrFail();
        $ref = $booking->booking_reference;
        $booking->delete();

        return redirect()->back()->with('success', "Booking {$ref} deleted successfully.");
    }
}
