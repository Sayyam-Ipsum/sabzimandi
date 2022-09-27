<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface AuthInterface
{
    public function authenticate(Request $request);

    public function forgotPassword(Request $request);

    public function resetPassword(Request $request);

    public function resetPasswordView($token);
}
