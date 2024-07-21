<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class AuthController extends Controller
{

    private $allowedEmails = ['muhammad.tajuddin20@student.uisi.ac.id'];

    public function redirectToGoogle(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request): RedirectResponse
    {


        if ($request->input('error')) {
            return redirect('/auth/redirect');
        }

        $googleUser = Socialite::driver('google')->user();

        if (in_array($googleUser->email, $this->allowedEmails)) {
            $user = User::updateOrCreate(
                ['email' => $googleUser->email],
                [
                    'name' => $googleUser->name,
                    'google_id' => $googleUser->id,
                    'avatar' => $googleUser->avatar,
                    'password' => bcrypt(Str::random(16)),
                ]
            );

            Auth::login($user, true);
            activityLog('Masuk', 'enter', 'success', 'Berhasil masuk');
            return redirect()->intended('/');
        } else {
            return redirect('/auth/redirect');
        }


    }

    public function logout(){
        activityLog('Keluar', 'exit', 'error', 'Berhasil keluar');
        Auth::logout();

        return redirect('/auth/redirect');
    }
}
