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
                'name' => 'unique:users,name' . ($request->id ? ",$request->id" : ''),
                'email' => 'email|unique:users,email' . ($request->id ? ",$request->id" : ''),
                'phone' => 'min:11',
            ]);

            if ($validate->fails()) {
                return redirect('/profile')->withErrors($validate);
            }

            if ($this->dashboardInterface->storeProfile($request)) {
                return redirect()->back()->with('success', 'Profile Updated Successfully');
            }

            return redirect()->back()->with('error', 'Internal Server Error');
        }

        return view('dashboard.profile');
    }

    public function setting(): View
    {
        return view('dashboard.setting');
    }
}
