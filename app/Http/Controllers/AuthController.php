<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\AuthInterface;
use Illuminate\Support\Facades\Auth;

/**
 *
 */
class AuthController extends Controller
{
    /**
     * @var AuthInterface
     */
    protected $authInterface;

    /**
     * @param AuthInterface $authInterface
     */
    public function __construct(AuthInterface $authInterface)
    {
        $this->authInterface = $authInterface;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function index()
    {
        return redirect('/dashboard');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function login()
    {
        return view('auth.login');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function forgotView()
    {
        return view('auth.forgot');
    }

    /**
     * @param $token
     * @return mixed
     */
    public function resetPasswordView($token)
    {
        return $this->authInterface->resetPasswordView($token);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function dashboard()
    {
//        return view('dashboard.dashboard');
        if (auth()->user()) {
            return view('dashboard.dashboard');
        } else {
            return redirect('/login');
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function authenticate(Request $request)
    {
        return $this->authInterface->authenticate($request);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function forgotPassword(Request $request)
    {
        return $this->authInterface->forgotPassword($request);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function resetPassword(Request $request)
    {
        return $this->authInterface->resetPassword($request);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
