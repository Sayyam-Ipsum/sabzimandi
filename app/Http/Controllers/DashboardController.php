<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function profile()
    {
        return view('dashboard.profile');
    }

    public function setting()
    {
        return view('dashboard.setting');
    }

}
