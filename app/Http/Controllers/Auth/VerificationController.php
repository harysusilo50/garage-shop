<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

class VerificationController extends Controller
{
    use VerifiesEmails;

    protected $redirectTo = RouteServiceProvider::HOME;


    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    public function show(Request $request)
    {
        return $request->user()->hasVerifiedEmail()
            ? redirect($this->redirectPath())
            : view('auth.verify');
    }

    protected function verified(Request $request)
    {
        Alert::success('Success', 'Verifikasi Email Berhasil!');
        return redirect($this->redirectPath());
    }

    public function resend(Request $request)
    {
        // $validate = Validator::make($request->all(), [
        //     'g-recaptcha-response' => 'required|captcha'
        // ]);

        // if (!($validate->getMessageBag()->isEmpty())) {
        //     Alert::error('error', 'Harap pastikan Anda adalah manusia!');
        //     return redirect()->back();
        // } else {
            if ($request->user()->hasVerifiedEmail()) {
                return $request->wantsJson()
                    ? new JsonResponse([], 204)
                    : redirect($this->redirectPath());
            }
            $request->user()->sendEmailVerificationNotification();

            if ($request->wantsJson()) {
                return new JsonResponse([], 202);
            } else {
                Alert::success('Terkirim!', 'Link verifikasi terbaru telah dikirimkan ke Email anda');
                return redirect()->back();
            }
        // }
    }
}
