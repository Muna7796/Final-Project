<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserDist;
use App\Models\User;
use App\Models\Distance;
use App\Models\BloodBank;

class UserDistanceController extends Controller
{
    // public function index()
    // {
    //     $userDists = UserDist::all();

    //     return view('shortest-distance', compact('userDists'));
    // }

    public function create()
    {
        return view('shortest-distance');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);
        UserDist::create($request->only(['name', 'location']));

        return redirect()->route('shortest-distance');

    }

    public function getFindNearestBloodbank(Request $request){
          $user = User::find(Auth()->user()->id);
           
        $getnearestdistance = Distance::getUserNerestDistance($user->lat, $user->lng, $request->get('location'));
        $data =[
                'bloodbanks' => BloodBank::all(),
                'result' => $getnearestdistance
        ];
        return view('user.bloodbanklist', $data);

      

    }
}
