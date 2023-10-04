<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\State;
use App\Models\City;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $countries = Country::where('status', 1)->get();
        $states = State::where(['status' => 1, 'country_id' => 101])->get();
        $cities = City::where('state_id', $states[0]->id)->get();
        return view('index');
    }

    public function getIpDetail()
    {
        $ip = request()->ip(); // Dynamic IP address
      //  $ip = '103.223.9.47'; // Static IP address of  jalandhar
        $ip = '101.0.49.116'; // Static IP address of mohali
        return $datas = \Location::get($ip);
    }

    /**
     * Fetch all Categories for display on Categories Page
     */

    public function allCategories()
    {
        return view('categories');
    }


}
