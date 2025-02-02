<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CategoryController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->get('search');
        if ($search) {
            $data = Category::where('name', 'LIKE', "%$search%")
                ->latest()
                ->paginate(15)
                ->withQueryString();
            return view('admin.category.index', compact('data', 'search'));
        }

        $data = Category::latest()->paginate(15)->withQueryString();
        return view('admin.category.index', compact('data'));
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        $v = $this->validate($request, [
            'name' => 'required',
            'icon' => 'required',
        ], [
            'name.required' => 'Kolom Nama Kategori harus diisi!',
            'icon.required' => 'Kolom Icon kategori harus diisi!',
        ]);
        try {
            $data = new Category();
            $data->name = $request->name;
            $data->icon = $request->icon;

            $data->save();

            if ($data) {
                Alert::success('Success', 'Berhasil menambah Data Category!');
                return redirect()->route('category.index');
            } else {
                Alert::error('Failed', 'Gagal menambah Data Category!');
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            Alert::error('Failed', $th->getMessage());
            return redirect()->back();
        }
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
        $data = Category::findOrFail($id);
        return view('admin.category.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $v = $this->validate($request, [
            'name' => 'required',
            'icon' => 'required'
        ], [
            'name.required' => 'Kolom Nama Kategori harus diisi!',
            'icon.required' => 'Kolom Icon Kategori harus diisi!',

        ]);
        try {
            $data = Category::findOrFail($id);
            $data->name = $request->name;
            $data->slug = SlugService::createSlug(Category::class, 'slug', $request->name);
            $data->icon = $request->icon;
            $data->save();

            if ($data) {
                Alert::success('Success', 'Berhasil mengubah Data Kategori!');
                return redirect()->route('category.index');
            } else {
                Alert::error('Failed', 'Gagal mengubah Data Kategori!');
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
            $data = Category::findOrFail($id);
            $data->delete();
            if ($data) {
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
