<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Validation\ValidatesRequests;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;
    use ValidatesRequests;

    protected $redirectTo = '/home'; // Change this to your desired redirect path after password reset

    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    protected function reset(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $credentials = $request->only('email', 'password', 'password_confirmation');

        $status = Password::reset($credentials, function ($user, $password) {
            $user->password = bcrypt($password);
            $user->save();
        });

        return $status == Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', trans($status))
            : back()->withErrors(['email' => trans($status)]);
    }
}
