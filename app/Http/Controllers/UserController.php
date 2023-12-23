<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Contact;
use App\Models\Occupation;
use Auth;
use Mail;

class UserController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $states = State::where(['status' => 1, 'country_id' => 101])->get();
        $cities = City::where(['status' => 1, 'state_id' => $states[0]->id])->orderBy('name', 'ASC')->get();
        $occupations = Occupation::where('status', 1)->orderBy('occupation_name', 'ASC')->get();

        $data = [];
        $data = [
            'states' => $states,
            'cities' => $cities,
            'occupations' => $occupations
        ];
        return view('index', compact('data'));
    }

    public function getIpDetail()
    {
        $ip = request()->ip(); // Dynamic IP address
        $ip = '103.223.9.47'; // Static IP address of  jalandhar
        //$ip = '101.0.49.116'; // Static IP address of mohali
        return $data = Location::get($ip);
    }

    // public function showUser()
    // {
    //     if (Auth::check()) {
    //         echo $user = User::find(Auth::id());
    //     } else if (Auth::guard('vendor')->check()) {
    //         echo $user = Vendor::find(Auth::guard('vendor')->id());
    //     }
    // }

    /**
     * Contact us
     */

    public function contactUs()
    {
        return view('contact');
    }

    // Store Contact Form data
    public function ContactUsForm(Request $request)
    {
        // Form validation
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required'
        ]);
        //  Store data in database
        Contact::create($request->all());
        //  Send mail to admin
        // \Mail::send('mail', array(
        //     'name' => $request->get('name'),
        //     'email' => $request->get('email'),
        //     'subject' => $request->get('subject'),
        //     'message' => $request->get('message'),
        // ), function($message) use ($request){
        //     $message->from($request->email);
        //     $message->to('aksh901@gmail.com', 'Admin')->subject($request->get('subject'));
        // });
        return back()->with('success', 'We have received your message and would like to thank you for writing to us.');
    }
}
