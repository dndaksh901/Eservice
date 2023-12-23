<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:admin')->except('logout');
        $this->middleware('guest:vendor')->except('logout');
    }

    public function login(Request $request)
    {

         //Error messages
         $messages = [
            "email.required" => "Email is required",
            "email.email" => "Email is not valid",
            "password.required" => "Password is required",
            "password.min" => "Password must be at least 6 characters"
        ];

        // validate the form data
        $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required|min:6'
            ], $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {

            return redirect()->intended('/vendor/profile');
        }
        return back()->withInput($request->only('email', 'remember'))->withErrors([
            'approve' => 'Wrong password or this account not approved yet.',
        ]);
    }
}

    public function showAdminLoginForm()
    {
        return view('auth.login', ['url' => 'admin']);
    }

    public function adminLogin(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:8'
        ]);

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {

            return redirect()->intended('/admin/dashboard');
        }
        return back()->withInput($request->only('email', 'remember'));
    }

     public function showVendorLoginForm()
    {
        return view('auth.login', ['url' => 'vendor']);
    }

    public function vendorLogin(Request $request)
    {

         //Error messages
         $messages = [
            "email.required" => "Email is required",
            "email.email" => "Email is not valid",
            "password.required" => "Password is required",
            "password.min" => "Password must be at least 6 characters"
        ];

        // validate the form data
        $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required|min:6'
            ], $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {

        if (Auth::guard('vendor')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {

            return redirect()->intended('/vendor/profile');
        }
        return back()->withInput($request->only('email', 'remember'))->withErrors([
            'approve' => 'Wrong password or this account not approved yet.',
        ]);
    }
}
}
