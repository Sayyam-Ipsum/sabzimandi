<?php

namespace App\Http\Controllers;

use App\Interfaces\DashboardInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    protected $dashboardInterface;

    public function __construct(DashboardInterface $dashboardInterface)
    {
        $this->dashboardInterface = $dashboardInterface;
    }

    public function profile(Request $request)
    {
        if ($request->post()) {
            $validate = Validator::make($request->all(), [
                'name' => 'required|unique:users,name' . ($request->id ? ",$request->id" : ''),
                'email' => 'required|email|unique:users,email' . ($request->id ? ",$request->id" : ''),
            ]);

            if (!$validate->fails()) {
                $is_store = $this->dashboardInterface->storeProfile($request);
                if ($is_store) {
                    return redirect('/profile')->with('success', 'Profile Updated Successfully');
                } else {
                    return redirect('/profile')->with('error', 'Internal Server Error');
                }
            } else {
                return redirect('/profile')->withErrors($validate);
            }
        }

        return view('dashboard.profile');
    }

    public function setting()
    {
        return view('dashboard.setting');
    }

}
