<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\State;
use App\Models\City;
use App\Models\Country;

class AddressController extends Controller
{
    public function countryGet()
    {
        $countries = Country::where('status', 'active')->get();
        return $countries;
    }
    public function cityGet($id)
    {
        $cities = City::where('state_id', $id)
        ->where('status', 1)
        // ->where('country_id',101)
        ->orderBy('name', 'ASC')->get();
        return $cities;
    }
    public function cityGetByStateName($name)
    {

        $cities = City::whereHas('state', function ($q) use ($name) {
            $q->where('name', 'like', '%' . $name . '%')->where('country_id',101);
        })->where('status', 1)->orderBy('name', 'ASC')->get();
        return $cities;
    }

    public function getActiveCountries(Request $request) {
        $countries = Country::where('id', $request->country_id)->first();
        return response()->json($countries);
    }
}
