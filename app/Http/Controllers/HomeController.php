<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = [
            'google_auth_url' => route('auth.google.signin'),
            'auth_user' => Auth::check() ? Auth::user() : json_encode([]),
            'errors' => session()->has('error') ? json_encode(session('error')) : json_encode([]),
        ];
        return view('home', $data);
    }
}
