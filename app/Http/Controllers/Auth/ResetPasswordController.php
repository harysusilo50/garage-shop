<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function reset(Request $request)
    {
        $validate = Validator::make($request->all(), $this->rules());

        // dd($validate->getMessageBag());
        if (!($validate->getMessageBag()->isEmpty())) {
            $validator = $validate->getMessageBag()->getMessages();
            // if (isset($validator['g-recaptcha-response']) && $validator['g-recaptcha-response'] != null) {
            //     Alert::error(
            //         'error',
            //         'Harap pastikan Anda adalah manusia!'
            //     );
            //     return redirect()->back();
            // }
            $validate->validate();
        }

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $response = $this->broker()->reset(
            $this->credentials($request),
            function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $response == Password::PASSWORD_RESET
            ? $this->sendResetResponse($request, $response)
            : $this->sendResetFailedResponse(
                $request,
                $response
            );
    }

    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed',  Rules\Password::defaults()],
            // 'g-recaptcha-response' => 'required|captcha',
        ];
    }

    protected function sendResetResponse(Request $request, $response)
    {
        $validate = Validator::make($request->all(), $this->rules());

        // dd($validate->getMessageBag());
        if (!($validate->getMessageBag()->isEmpty())) {
            $validator = $validate->getMessageBag()->getMessages();
            // if (isset($validator['g-recaptcha-response']) && $validator['g-recaptcha-response'] != null) {
            //     Alert::error(
            //         'error',
            //         'Harap pastikan Anda adalah manusia!'
            //     );
            //     return redirect()->back();
            // }
            $validate->validate();
        }

        if ($request->wantsJson()) {
            return new JsonResponse(['message' => trans($response)], 200);
        }

        Alert::success('Berhasil', trans($response));
        return redirect($this->redirectPath())->with('status', trans($response));
    }

    protected function sendResetFailedResponse(Request $request, $response)
    {
        if ($request->wantsJson()) {
            throw ValidationException::withMessages([
                'email' => [trans($response)],
            ]);
        }

        Alert::error('Gagal', trans($response));
        return redirect()->back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => trans($response)]);
    }
}
