<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        if ($search) {
            $data = Brand::where('name', 'LIKE', "%$search%")
                ->orWhere('slug', 'LIKE', "%$search%")
                ->latest()
                ->paginate(15)
                ->withQueryString();
            return view('admin.brand.index', compact('data', 'search'));
        }

        $data = Brand::latest()->paginate(15)->withQueryString();
        return view('admin.brand.index', compact('data'));
    }

    public function create()
    {
        return view('admin.brand.create');
    }

    public function store(Request $request)
    {
        $v = $this->validate($request, [
            'name' => 'required',
            'image' => 'required',
        ], [
            'name.required' => 'Kolom Nama Brand harus diisi!',
            'image.required' => 'Kolom Gambar Brand harus diisi!',
        ]);
        try {
            $data = new Brand();
            $data->name = $request->name;

            $image_parts = explode(";base64,", $request->image);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);

            $folderPath = storage_path('app/public/brand/');
            $image_name =  date('YmdHi') .  '_' . $request->name  . '.' . $image_type;
            $file = $folderPath . '' . $image_name;
            $data->image = $image_name;

            $data->save();

            if ($data) {
                file_put_contents($file, $image_base64);
                Alert::success('Success', 'Berhasil menambah Data Brand!');
                return redirect()->route('brand.index');
            } else {
                Alert::error('Failed', 'Gagal menambah Data Brand!');
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            Alert::error('Failed', $th->getMessage());
            return redirect()->back();
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $data = Brand::findOrFail($id);
        return view('admin.brand.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $v = $this->validate($request, [
            'name' => 'required',

        ], [
            'name.required' => 'Kolom Nama Brand harus diisi!',

        ]);
        try {
            $data = Brand::findOrFail($id);
            $data->name = $request->name;
            $data->slug = SlugService::createSlug(Brand::class, 'slug', $request->name);
            if ($request->image) {
                Storage::disk('public')->delete('brand/' . $data->image);

                $image_parts = explode(";base64,", $request->image);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);

                $folderPath = storage_path('app/public/brand/');
                $image_name =  date('YmdHi') .  '_' . $request->name  . '.' . $image_type;
                $file = $folderPath . '' . $image_name;
                file_put_contents($file, $image_base64);
                $data->image = $image_name;
            }

            $data->save();

            if ($data) {
                Alert::success('Success', 'Berhasil mengubah Data Brand!');
                return redirect()->route('brand.index');
            } else {
                Alert::error('Failed', 'Gagal mengubah Data Brand!');
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            Alert::error('Failed', $th->getMessage());
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        try {
            $data = Brand::findOrFail($id);
            $name_file = $data->image;
            $data->delete();
            if ($data) {
                Storage::disk('public')->delete('brand/' . $name_file);
                Alert::success('Success', 'Berhasil Menghapus Data!');
                return redirect()->back();
            } else {
                Alert::success('Error', 'Gagal Menghapus Data!');
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            Alert::error('Failed', $th->getMessage());
            return redirect()->back();
        }
    }
}
