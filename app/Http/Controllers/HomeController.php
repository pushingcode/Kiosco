<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        
        $activity = DB::table('activity_log')
        ->join('users', 'activity_log.causer_id', '=', 'users.id')
        ->select('activity_log.*', 'users.name AS name')
        ->get();

        return view('home', compact('activity'));
    }
}
