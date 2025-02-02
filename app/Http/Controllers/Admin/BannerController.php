<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class BannerController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        if ($search) {
            $data = Banner::where('name', 'LIKE', "%$search%")
                ->orWhere('slug', 'LIKE', "%$search%")
                ->latest()
                ->paginate(15)
                ->withQueryString();
            return view('admin.banner.index', compact('data', 'search'));
        }

        $data = Banner::latest()->paginate(15)->withQueryString();
        return view('admin.banner.index', compact('data'));
    }

    public function create()
    {
        return view('admin.banner.create');
    }

    public function store(Request $request)
    {
        $v = $this->validate($request, [
            'name' => 'required',
            'image' => 'required',
        ], [
            'name.required' => 'Kolom Nama banner harus diisi!',
            'image.required' => 'Kolom Gambar banner harus diisi!',
        ]);
        try {
            $data = new Banner();
            $data->name = $request->name;

            $image_parts = explode(";base64,", $request->image);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);

            $folderPath = storage_path('app/public/banner/');
            $image_name =  date('YmdHi') .  '_' . $request->name  . '.' . $image_type;
            $file = $folderPath . '' . $image_name;
            $data->image = $image_name;

            $data->save();

            if ($data) {
                file_put_contents($file, $image_base64);
                Alert::success('Success', 'Berhasil menambah Data banner!');
                return redirect()->route('banner.index');
            } else {
                Alert::error('Failed', 'Gagal menambah Data banner!');
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
        $data = Banner::findOrFail($id);
        return view('admin.banner.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $v = $this->validate($request, [
            'name' => 'required',

        ], [
            'name.required' => 'Kolom Nama banner harus diisi!',

        ]);
        try {
            $data = Banner::findOrFail($id);
            $data->name = $request->name;
            $data->slug = SlugService::createSlug(Banner::class, 'slug', $request->name);
            if ($request->image) {
                Storage::disk('public')->delete('banner/' . $data->image);

                $image_parts = explode(";base64,", $request->image);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);

                $folderPath = storage_path('app/public/banner/');
                $image_name =  date('YmdHi') .  '_' . $request->name  . '.' . $image_type;
                $file = $folderPath . '' . $image_name;
                file_put_contents($file, $image_base64);
                $data->image = $image_name;
            }

            $data->save();

            if ($data) {
                Alert::success('Success', 'Berhasil mengubah Data banner!');
                return redirect()->route('banner.index');
            } else {
                Alert::error('Failed', 'Gagal mengubah Data banner!');
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
            $data = Banner::findOrFail($id);
            $name_file = $data->image;
            $data->delete();
            if ($data) {
                Storage::disk('public')->delete('banner/' . $name_file);
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
