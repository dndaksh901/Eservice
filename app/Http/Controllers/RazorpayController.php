<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Session;
use Exception;

class RazorpayController extends Controller
{

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        return view('razorpayView');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $key = config('services.razorpay.key');
        $secret = config('services.razorpay.secret');

        if (empty($input['razorpay_payment_id'])) {
            Session::put('error', 'Payment ID missing.');
            return redirect()->back();
        }

        $api = new Api($key, $secret);

        try {
            $payment = $api->payment->fetch($input['razorpay_payment_id']);
            $response = $payment->capture(['amount' => $payment['amount']]);

            \App\Models\Payment::create([
                'r_payment_id'  => $payment['id'],
                'method'        => $payment['method'] ?? 'unknown',
                'currency'      => $payment['currency'] ?? 'INR',
                'vendor_email'  => $payment['email'] ?? 'customer@example.com',
                'amount'        => ($payment['amount'] / 100),
                'json_response' => json_encode((array) $response),
            ]);

            Session::put('success', 'Payment successful');
        } catch (Exception $e) {
            Session::put('error', $e->getMessage());
            return redirect()->back();
        }

        return redirect()->back();
    }
}
