<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Interfaces\AuthInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
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

    public function dashboard(): View|RedirectResponse
    {
        if (auth()->user()) {
            return view('dashboard.dashboard');
        }

        return redirect('/login');
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required|email|max:50',
            'password' => 'required|min:8'
        ]);

        if ($validation->fails()) {
            return redirect('/login')->withErrors( $validation->errors());
        }

        if ($this->authInterface->authenticate($request)) {
            return redirect('/dashboard');
        }

        return redirect('/login')->with('error', 'Invalid Credentials');
    }

    public function forgotPassword(Request $request): RedirectResponse
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validation->fails()) {
            return redirect('/forgot')->withErrors($validation);
        }

        return $this->authInterface->forgotPassword($request);
    }

    public function resetPassword(Request $request): RedirectResponse
    {
        $validation = Validator::make($request->all(), [
            'password' => 'min:8|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'min:8',
            'user_id' => 'required',
            'reset_token' => 'required'
        ]);

        if ($validation->fails()) {
            return redirect('/reset/' . $request->reset_token)->withErrors($validation);
        }

        return $this->authInterface->resetPassword($request);
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();
        return redirect('/login');
    }
}
