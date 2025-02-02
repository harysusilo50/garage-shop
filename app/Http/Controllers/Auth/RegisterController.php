<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = RouteServiceProvider::HOME;


    public function __construct()
    {
        $this->middleware('guest');
    }


    protected function validator(array $data)
    {
        return Validator::make($data, [
            // 'g-recaptcha-response' => 'required|captcha',
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['required', 'numeric'],
            'address' => ['required', 'string', 'max:255'],
        ], [
            'name.required' => 'Kolom Nama lengkap harus diisi',
            'name.max' => 'Nama lengkap maksimal 255 karakter',
            'email.required' => 'Kolom Email harus diisi',
            'email.max' => 'Email maksimal 255 karakter',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Kolom Password harus diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi Password tidak sesuai',
            // 'g-recaptcha-response.required' => 'Pastikan anda adalah manusia!',
            // 'g-recaptcha-response.captcha' => 'Pastikan anda adalah manusia!',
            'phone.required' => 'Kolom Nomor Telepon harus diisi',
            'phone.numeric' => 'Nomor telepon harus berupa angka',
            'address.required' => 'Kolom Alamat harus diisi',
            'address.max' => 'Alamat maksimal 255 karakter',
        ]);
    }


    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'],
            'address' => $data['address'],
            'role' => 'user',
        ]);
    }

    protected function registered(Request $request, $user)
    {
        Alert::success('Berhasil Mendaftar!', 'Silakan cek email dan lakukan verifikasi !');
        return redirect()->route('verification.notice');
    }
}
