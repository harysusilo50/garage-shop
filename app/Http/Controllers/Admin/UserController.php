<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        if ($search) {
            $data = User::where('name', 'LIKE', "%$search%")
                ->orWhere('email', 'LIKE', "%$search%")
                ->orWhere('role', 'LIKE', "%$search%")
                ->latest()
                ->paginate(15)
                ->withQueryString();
            return view('admin.user.index', compact('data', 'search'));
        }

        $data = User::latest()->paginate(15)->withQueryString();

        return view('admin.user.index', compact('data'));
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'password' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required|numeric',
            'address' => 'required',
            'role' => 'required'
        ], [
            'name.required' => 'Kolom Nama Lengkap harus diisi!',
            'password.required' => 'Kolom Password harus diisi!',
            'phone.required' => 'Kolom No Telepon harus diisi!',
            'email.required' => 'Kolom Email harus diisi!',
            'address.required' => 'Kolom Alamat harus diisi!',
            'role.required' => 'Kolom Role harus diisi!',
        ]);
        DB::beginTransaction();
        try {
            $data = new User();
            $data->name = $request->name;
            $data->password = $request->password;
            $data->email = $request->email;
            $data->phone = $request->phone;
            $data->address = $request->address;
            $data->role = $request->role;
            $data->email_verified_at = Carbon::now()->toDateTimeString();
            $data->created_at = Carbon::now()->toDateTimeString();
            $data->updated_at = Carbon::now()->toDateTimeString();

            $data->save();
            if ($data) {
                DB::commit();
                Alert::success('Success', 'Berhasil menambah Data User!');
                return redirect()->route('admin.user.index');
            } else {
                DB::rollBack();
                Alert::error('Failed', 'Gagal menambah Data User!');
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            Alert::error('Failed', $th->getMessage());
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required|numeric',
            'address' => 'required',
            'role' => 'required'
        ], [
            'name.required' => 'Kolom Nama Lengkap harus diisi!',
            'phone.required' => 'Kolom No Telepon harus diisi!',
            'address.required' => 'Kolom Alamat harus diisi!',
            'role.required' => 'Kolom Role harus diisi!',
        ]);
        DB::beginTransaction();
        try {
            $data = User::findOrFail($id);
            $data->name = $request->name;
            if ($request->password) {
                $data->password = Hash::make($request->password);
            }
            $data->email = $request->email;
            $data->phone = $request->phone;
            $data->address = $request->address;
            $data->role = $request->role;

            $data->save();
            if ($data) {
                DB::commit();
                Alert::success('Success', 'Berhasil mengedit Data User!');
                return redirect()->route('admin.user.index');
            } else {
                DB::rollBack();
                Alert::error('Failed', 'Gagal mengedit Data User!');
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            Alert::error('Failed', $th->getMessage());
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $data = User::findOrFail($id);
            $data->status = $data->status == 1 ? 0 : 1;
            $data->save();
            
            DB::commit();
            if ($data) {
                Alert::success('Success', 'Berhasil Mengubah Status Data User!');
                return redirect()->route('admin.user.index');
            } else {
                Alert::success('Error', 'Gagal Mengubah Status Data User!');
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            Alert::error('Failed', $th->getMessage());
            return redirect()->back();
        }
    }

    public function report()
    {
        $data = User::orderBy('email_verified_at')->get();
        $pdf = Pdf::loadView('admin.user.report', ['data' => $data]);
        return $pdf->stream('report_user_' . now() . '.pdf');
    }
}
