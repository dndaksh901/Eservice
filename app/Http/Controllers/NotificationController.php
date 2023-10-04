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

        // Form validation
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'message' => 'required|max:300'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        //  Store data in database
        Notification::create($request->all());
        return back()->with('success', 'We have received your message and would like to thank you for writing to us.');
    }
}
