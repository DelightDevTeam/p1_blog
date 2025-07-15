<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        return view('admin.dashboard');
    }

    // profile 
    public function profile()
    {
        $user = auth()->user();
        return view('admin.profile', compact('user'));
    }

    // update profile
    public function updateProfile(Request $request)
    {
        //dd($request->all());
        $user = auth()->user();
        $imageName = null;

        if ($request->hasFile('profile_picture')) {
            $imageName = time() . '.' . $request->profile_picture->extension();
            $request->profile_picture->move(public_path('profile_picture'), $imageName);
        }
        $user->profile_picture = $imageName;


        $user->save();
        return redirect()->route('profile');
    }
}
