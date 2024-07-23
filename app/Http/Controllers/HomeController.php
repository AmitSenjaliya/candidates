<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $token = session('api_token');
        $user = User::where('api_token', $token)->first();
        return view('home', compact('user'));
    }

    /**
     * Logout user.
     *
     * @return void
     */
    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('login')->with('success', 'User has logout successfully.');
    }
}
