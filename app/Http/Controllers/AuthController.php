<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Interfaces\AuthInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    protected AuthInterface $authInterface;

    public function __construct(AuthInterface $authInterface)
    {
        $this->authInterface = $authInterface;
    }

    public function index(): RedirectResponse
    {
        return redirect('/dashboard');
    }

    public function login(): View
    {
        return view('auth.login');
    }

    public function forgotView(): View
    {
        return view('auth.forgot');
    }

    public function resetPasswordView($token)
    {
        return $this->authInterface->resetPasswordView($token);
    }


    public function dashboard()
    {
        if (auth()->user()) {
            return view('dashboard.dashboard');
        }

        return redirect('/login');
    }

    public function authenticate(Request $request)
    {
        return $this->authInterface->authenticate($request);
    }

    public function forgotPassword(Request $request)
    {
        return $this->authInterface->forgotPassword($request);
    }

    public function resetPassword(Request $request)
    {
        return $this->authInterface->resetPassword($request);
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();
        return redirect('/login');
    }
}
