<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

/**
 *
 */
interface AuthInterface
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function authenticate(Request $request);

    /**
     * @param Request $request
     * @return mixed
     */
    public function forgotPassword(Request $request);

    /**
     * @param Request $request
     * @return mixed
     */
    public function resetPassword(Request $request);

    /**
     * @param $token
     * @return mixed
     */
    public function resetPasswordView($token);
}
