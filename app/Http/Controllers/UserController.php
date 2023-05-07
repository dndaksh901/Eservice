<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Occupation;

class UserController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $states = State::where(['status'=>1,'country_id'=>101])->get();
        $cities = City::where(['status'=>1,'state_id'=>$states[0]->id])->orderBy('name','ASC')->get();
        $occupations = Occupation::where('status',1)->get();

        $data=[];
        $data=[
            'states' => $states,
            'cities' => $cities,
            'occupations' => $occupations
        ];
        return view('index',compact('data'));
    }

    public function getIpDetail()
    {
            $ip = request()->ip(); // Dynamic IP address
            $ip = '103.223.9.47'; // Static IP address
           return $data = \Location::get($ip);
    }
}
