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
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;


class UserController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $states = \Illuminate\Support\Facades\Cache::remember('home_states_101', 86400, function () {
            return State::where(['status' => 1, 'country_id' => 101])->orderBy('name', 'ASC')->get();
        });

        $firstStateId = $states->isNotEmpty() ? $states[0]->id : null;
        $cities = $firstStateId ? \Illuminate\Support\Facades\Cache::remember('home_cities_' . $firstStateId, 86400, function () use ($firstStateId) {
            return City::where(['status' => 1, 'state_id' => $firstStateId])->orderBy('name', 'ASC')->get();
        }) : collect();

        $occupations = \Illuminate\Support\Facades\Cache::remember('home_occupations', 86400, function () {
            return Occupation::where('status', 1)->orderBy('occupation_name', 'ASC')->get();
        });

        $data = [
            'states' => $states,
            'cities' => $cities,
            'occupations' => $occupations
        ];
        return view('index', compact('data'));
    }

    public function getIpDetail()
    {
        if (Session::has('ip_details')) {
            return Session::get('ip_details');
        }

        $ip = request()->ip();
        // If testing on localhost, use fallback public IP
        if (in_array($ip, ['127.0.0.1', '::1', 'localhost']) || str_starts_with($ip, '192.168.')) {
            $ip = '103.223.9.47';
        }

        try {
            $data = \Location::get($ip);
            if ($data) {
                Session::put('ip_details', $data);
                return response()->json($data);
            }
        } catch (\Exception $e) {
            // Fail silently
        }

        return response()->json([
            'cityName' => 'Mohali',
            'regionName' => 'Punjab',
            'countryName' => 'India',
            'latitude' => 30.7046,
            'longitude' => 76.7179,
        ]);
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
    /**
     * Contact us
     */

    public function list()
    {
       // Get the start and end of the current week
    $startOfWeek = Carbon::now()->startOfWeek();
    $endOfWeek = Carbon::now()->endOfWeek();

    // Retrieve contacts created between the start and end of the current week
    // $contacts = Contact::whereBetween('created_at', [$startOfWeek, $endOfWeek])->paginate(15);
    $contacts = Contact::query()->paginate(15);

    return view('admin.contact.list',compact('contacts'));
    }

    public function show($id)
    {
       return $message = Contact::find($id);

    }

    public function destroy($id)
    {
        // Delete the message with the given ID
        Contact::destroy($id);

        return redirect('admin/contact-list')->with('success', 'Message deleted successfully');
    }

    // Store Contact Form data
    public function ContactUsForm(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email|max:150',
            'subject' => 'required|string|max:200',
            'message' => 'required|string|max:3000'
        ]);

        Contact::create([
            'name'    => strip_tags($validated['name']),
            'email'   => $validated['email'],
            'subject' => strip_tags($validated['subject']),
            'message' => strip_tags($validated['message']),
        ]);
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
