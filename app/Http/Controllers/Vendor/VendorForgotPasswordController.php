<?php

namespace App\Http\Controllers\Vendor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class VendorForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;
    // The path where vendors will be redirected after submitting the email form
    protected $redirectTo = '/vendor/login';

    // The guard to use for this controller
    protected $guard = 'vendor';

    // The view to display for the password reset email form
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email', ['url' => 'vendor']);
    }

}
