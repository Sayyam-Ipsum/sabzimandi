<?php

namespace App\Repositories;

use App\Interfaces\AuthInterface;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

/**
 *
 */
class AuthRepository implements AuthInterface
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function authenticate(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required|email|max:50',
            'password' => 'required|min:8'
        ]);

        if (!$validation->fails()) {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                return redirect('/dashboard');
            } else {
                return redirect('/login')->with('error', 'Invalid Credentials');
            }
        } else {
            return redirect('/login')->withErrors( $validation->errors());
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|void
     */
    public function forgotPassword(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
        if (!$validation->fails()) {
            $user = User::where('email', $request->email)
                ->first();
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
            } else {
                return redirect('/forgot')->with('error', 'Invalid Email Address for your Account.');
            }
        } else {
            return redirect('/forgot')->withErrors($validation);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function resetPassword(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'password' => 'min:8|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'min:8',
            'user_id' => 'required',
            'reset_token' => 'required'
        ]);

        if (!$validation->fails()) {
            $user = User::find($request->user_id);
//            $newPassword = Hash::make($request->password);
            $newPassword = password_hash($request->password, PASSWORD_DEFAULT);
            if ($user->password == $newPassword) {
                return redirect('/reset/' . $request->reset_token)->with('error', 'Please Enter New Password');
            }
            $user->password = $newPassword;
            $user->save();

            return redirect('/login');
        } else {
            return redirect('/reset/' . $request->reset_token)->withErrors($validation);
        }
    }

    /**
     * @param $token
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function resetPasswordView($token)
    {
        if (!$token) {
            return redirect('/forgot')->with('error', 'Reset Password Token not found');
        }

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
            } else {
                return redirect('/forgot')->with('error', 'User does not exist.');
            }
        } else {
            return redirect('/forgot')->with('error', 'Invalid Password Reset Token');
        }
    }
}
