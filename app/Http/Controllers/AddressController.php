<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\State;
use App\Models\City;

class AddressController extends Controller
{
    public function cityGet($id){
        $cities = City::where('state_id',$id)->where('status',1)->orderBy('name','ASC')->get();
        return $cities;

    }
    public function cityGetByStateName($name){
        $id = State::where('name','like','%'.$name.'%')->value('id');
        $cities = City::where('state_id',$id)->where('status',1)->orderBy('name','ASC')->get();
        return $cities;

    }
}
