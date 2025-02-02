<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{

    use AuthenticatesUsers;


    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function validateLogin(Request $request)
    {
        $request->validate(
            [
                $this->username() => 'required|string',
                'password' => 'required|string',
                // 'g-recaptcha-response' => 'required|captcha'
            ]
            // , [
            //     'g-recaptcha-response.required' => 'Pastikan anda adalah manusia!',
            //     'g-recaptcha-response.captcha' => 'Pastikan anda adalah manusia!',

            // ]
        );
    }
    protected function attemptLogin(Request $request)
    {
        // Lakukan percobaan login dengan pengecekan status user
        return $this->guard()->attempt(
            array_merge(
                $this->credentials($request),
                ['status' => true]  // Menambahkan kondisi untuk status
            ),
            $request->boolean('remember')
        );
    }

    protected function authenticated(Request $request, $user)
    {
        if ($user->role == 'admin') {
            Alert::success('Success', 'Selamat datang admin!');
            return redirect()->route('dashboard.admin');
        } else {
            if ($request->user()->hasVerifiedEmail()) {
                Alert::success('Success', 'Berhasil Login !');
                return redirect()->route('home');
            } else {
                $request->user()->sendEmailVerificationNotification();
                return redirect()->route('verification.notice');
            }
            return redirect()->route('home');
        }
    }
    protected function sendFailedLoginResponse(Request $request)
    {
        Alert::error('Gagal!', 'Username atau Password salah atau akun non aktif!');
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
            'password' => [trans('auth.failed')],
        ]);
    }
    protected function loggedOut(Request $request)
    {
        Alert::success('Success', 'Berhasil Logout!');
        return redirect()->route('home');
    }
}
