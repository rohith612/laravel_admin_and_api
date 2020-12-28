<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Offer;
use App\CustomerGroup;
use App\Customer;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $status;
    public function __construct(){
        $this -> status = \Config::get('constants.rec_status');
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        $info_panel = array(
            'offers' => Offer::where('status', $this -> status)->count(),
            'groups' => CustomerGroup::where('status', $this -> status)->count(),
            'customers' => Customer::where('status', $this -> status)->count()
        );
        return view('home', compact('info_panel'));
    }

    public function login(){
        return redirect()->route('login');
    }

}
