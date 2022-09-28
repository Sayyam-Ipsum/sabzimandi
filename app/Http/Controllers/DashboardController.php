<?php

namespace App\Http\Controllers;

use App\Interfaces\DashboardInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class DashboardController extends Controller
{
    protected DashboardInterface $dashboardInterface;

    public function __construct(DashboardInterface $dashboardInterface)
    {
        $this->dashboardInterface = $dashboardInterface;
    }

    public function profile(Request $request): View|RedirectResponse
    {
        if ($request->post()) {
            $validate = Validator::make($request->all(), [
                'name' => 'required|unique:users,name' . ($request->id ? ",$request->id" : ''),
                'email' => 'required|email|unique:users,email' . ($request->id ? ",$request->id" : ''),
            ]);

            if ($validate->fails()) {
                return redirect('/profile')->withErrors($validate);
            }

            if ($this->dashboardInterface->storeProfile($request)) {
                return redirect('/profile')->with('success', 'Profile Updated Successfully');
            }

            return redirect('/profile')->with('error', 'Internal Server Error');
        }

        return view('dashboard.profile');
    }

    public function setting(): View
    {
        return view('dashboard.setting');
    }
}
