<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /*
    * admin dashboard
    */
    public function adminDashboard(){
        return view('dasbhoard.admin');
    }

    /*
    * owner dashboard
    */
    public function ownerDashboard(){
        return view('dasbhoard.owner');
    }

    /*
    * manager dashboard
    */
    public function managerDashboard(){
        return view('dasbhoard.manager');
    }

    /*
    * salesrepresentative dashboard
    */
    public function salesrepresentativeDashboard(){
        return view('dasbhoard.dsr');
    }

    /*
    * JSO dashboard
    */
    public function jsoDashboard(){
        return view('dasbhoard.jso');
    }

    /*
    * accountant dashboard
    */
    public function accountantDashboard(){
        return view('dasbhoard.accountant');
    }
}
