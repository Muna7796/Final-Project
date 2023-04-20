<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserDist;

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
}
