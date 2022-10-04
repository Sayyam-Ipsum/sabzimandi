<?php

namespace App\Repositories;

use App\Interfaces\AuthInterface;
use App\Models\User;
use DateTime;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AuthRepository implements AuthInterface
{
    public function authenticate(Request $request): bool
    {
        $login = false;

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $login = true;
        }

        return $login;
    }

    public function forgotPassword(Request $request): bool|RedirectResponse
    {
        $user = User::where('email', $request->email)->first();

        if ($user) {
            $token = Str::random(64);
            $resetPassword = DB::table('password_resets')
                ->insert([
                    'email' => $user->email,
                    'token' => $token
                ]);
            $data = [
                'user' => $user,
                'token' => $token
            ];
            if ($resetPassword) {
                $isMailSent = send_email($user->email, 'Reset Password', $data, 'forgotPassword');
                if (!$isMailSent) {
                    return redirect('/forgot')->with('error', 'Email Sending Failed.');
                }

                return redirect('/forgot')->with(
                    'success',
                    'Password Reset Link sent to your Email Account.'
                );
            }
        }

        return redirect('/forgot')->with('error', 'Invalid Email Address for your Account.');
    }

    public function resetPassword(Request $request): bool|RedirectResponse
    {
        $user = User::find($request->user_id);
        $newPassword = password_hash($request->password, PASSWORD_DEFAULT);
        if ($user->password == $newPassword) {
            return redirect('/reset/' . $request->reset_token)->with('error', 'Please Enter New Password');
        }

        $user->password = $newPassword;
        $user->save();

        return redirect('/login');
    }

    public function resetPasswordView($token): View|RedirectResponse
    {
        $resetToken = DB::table('password_resets')
            ->where('token', $token)
            ->get()
            ->last();
        if ($resetToken) {
            $user = User::where('email', $resetToken->email)
                ->first();
            if ($user) {
                $date1 = new DateTime(date('Y-m-d h:i:s'));
                $date2 = new DateTime($resetToken->created_at);
                $interval = $date1->diff($date2);
                $hours = $interval->format('%h');
                if ($hours > 3) {
                    return redirect('/forgot')->with('error', 'Password Reset Link has been expired.');
                }

                return view('auth.reset')->with(compact(['user', 'resetToken']));
            }

            return redirect('/forgot')->with('error', 'User does not exist.');
        }

        return redirect('/forgot')->with('error', 'Invalid Password Reset Token');
    }
}
