<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;
    // The path where users will be redirected after submitting the email form
    protected $redirectTo = '/user/login';

    // The guard to use for this controller
    protected $guard = 'web';

    // The view to display for the password reset email form
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email', ['url' => 'user']);
    }

}
