<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\PhotoProduct;
use App\Models\Product;
use App\Models\Stock;
use App\Models\VariantProduct;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        if ($search) {
            $data = Product::with('photo')
                ->where('name', 'LIKE', "%$search%")
                ->orWhere('price', 'LIKE', "%$search%")
                ->orWhere('arrival', 'LIKE', "%$search%")
                ->latest()
                ->paginate(15)
                ->withQueryString();
            return view('admin.product.index', compact('data', 'search'));
        }
        $data = Product::with('photo')->latest()->paginate(15)->withQueryString();
        return view('admin.product.index', compact('data'));
    }

    public function create()
    {
        $brand = Brand::select('id', 'name')->get();
        $category = Category::select('id', 'name')->get();
        return view('admin.product.create', compact('brand', 'category'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'brand_id' => 'required',
            'category_id' => 'required',
            'name' => 'required',
            'code' => 'required|unique:products',
            'stock' => 'required',
            'price' => 'required',
            'modal_price' => 'required',
            'description_short' => 'required',
            'description_long' => 'required',
            'image' => 'required',
            'image_gallery' => 'required',
        ], [
            'brand_id.required' => 'Kolom Nama Brand harus diisi!',
            'category_id.required' => 'Kolom Nama Kategori harus diisi!',
            'name.required' => 'Kolom Nama Produk harus diisi!',
            'code.required' => 'Kolom Kode Produk harus diisi!',
            'code.unique' => 'Kode Produk sudah ada',
            'stock.required' => 'Kolom Stok Produk harus diisi!',
            'modal_price.required' => 'Kolom Total Harga Modal Produk harus diisi!',
            'price.required' => 'Kolom Harga Produk harus diisi!',
            'description_short.required' => 'Kolom Deskripsi Singkat harus diisi!',
            'description_long.required' => 'Kolom Deskripsi Lengkap harus diisi!',
            'image.required' => 'Kolom Thumbnail Produk harus diisi!',
            'image_gallery.required' => 'Kolom Gallery Produk harus diisi!',
        ]);
        DB::beginTransaction();
        try {
            $product = new Product();
            $product->brand_id = $request->brand_id;
            $product->category_id = $request->category_id;
            $product->name = $request->name;
            $product->code = $request->code;
            $product->stock = $request->stock;
            $product->price = $request->price;
            $product->description_long = $request->description_long;
            $product->description_short = $request->description_short;
            $product->is_active = 'yes';

            if ($request->discount_price) {
                $product->discount_price = $request->discount_price;
            }

            if ($request->arrival == 'no_label') {
                $product->arrival = NULL;
            } else {
                $product->arrival = $request->arrival;
            }

            $image_parts1 = explode(";base64,", $request->image);
            $image_type_aux1 = explode("image/", $image_parts1[0]);
            $image_type1 = $image_type_aux1[1];
            $image_base641 = base64_decode($image_parts1[1]);

            $folderPath1 = storage_path('app/public/product_thumbnail/');
            $image_name1 =  date('YmdHi') .  '_' . $request->name  . '.' . $image_type1;
            $file1 = $folderPath1 . '' . $image_name1;
            $product->thumbnail = $image_name1;


            $product->save();

            if ($product) {
                $stock = new Stock();
                $stock->product_id = $product->id;
                $stock->qty = $product->stock;
                $stock->type = 'in';
                $stock->amount = $request->modal_price;
                $stock->date = now();
                $stock->description = 'New Product ' . $product->name . ' added';
                $stock->save();

                file_put_contents($file1, $image_base641);
                if ($request->variant_name) {
                    $array = explode(',', $request->variant_name);
                    foreach ($array as $item) {
                        $data = new VariantProduct();
                        $data->product_id = $product->id;
                        $data->name = $item;
                        $data->save();
                    }
                }
                foreach ($request->image_gallery as $key => $value) {
                    $data_image_gallery = new PhotoProduct();
                    $image_parts = explode(";base64,", $value);
                    $image_type_aux = explode("image/", $image_parts[0]);
                    $image_type = $image_type_aux[1];
                    $image_base64 = base64_decode($image_parts[1]);

                    $folderPath = storage_path('app/public/product_gallery/');
                    $image_name =  date('YmdHi') .  '_' . $key . '_' . $product->name  . '.' . $image_type;
                    $file = $folderPath . '' . $image_name;
                    file_put_contents($file, $image_base64);
                    $data_image_gallery->product_id = $product->id;
                    $data_image_gallery->image = $image_name;
                    $data_image_gallery->save();
                }
                DB::commit();
                Alert::success('Success', 'Berhasil menambah Data Produk!');
                return redirect()->route('product.index');
            } else {
                DB::rollBack();
                Alert::error('Failed', 'Gagal menambah Data Brand!');
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            DB::rollBack();
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
        $brand = Brand::select('id', 'name')->get();
        $category = Category::select('id', 'name')->get();
        $product = Product::lockForUpdate()->with('photo', 'variant')->findOrFail($id);
        return view('admin.product.edit', compact('brand', 'category', 'product'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'brand_id' => 'required',
            'category_id' => 'required',
            'name' => 'required',
            'code' => 'required',
            'price' => 'required',
            'description_short' => 'required',
            'description_long' => 'required',
        ], [
            'brand_id.required' => 'Kolom Nama Brand harus diisi!',
            'category_id.required' => 'Kolom Nama Kategori harus diisi!',
            'name.required' => 'Kolom Nama Produk harus diisi!',
            'code.required' => 'Kolom Kode Produk harus diisi!',
            'price.required' => 'Kolom Harga Produk harus diisi!',
            'description_short.required' => 'Kolom Deskripsi Singkat harus diisi!',
            'description_long.required' => 'Kolom Deskripsi Lengkap harus diisi!',
        ]);
        DB::beginTransaction();
        try {
            $product = Product::lockForUpdate()->findOrFail($id);
            $product->brand_id = $request->brand_id;
            $product->category_id = $request->category_id;
            $product->name = $request->name;
            $product->price = $request->price;
            $product->description_long = $request->description_long;
            $product->description_short = $request->description_short;

            if ($request->discount_price) {
                $product->discount_price = $request->discount_price;
            }

            if ($request->arrival == 'no_label') {
                $product->arrival = NULL;
            } else {
                $product->arrival = $request->arrival;
            }

            if ($request->image) {

                $image_parts1 = explode(";base64,", $request->image);
                $image_type_aux1 = explode("image/", $image_parts1[0]);
                $image_type1 = $image_type_aux1[1];
                $image_base641 = base64_decode($image_parts1[1]);

                $folderPath1 = storage_path('app/public/product_thumbnail/');
                $image_name1 =  date('YmdHi') .  '_' . $request->name  . '.' . $image_type1;
                $file1 = $folderPath1 . '' . $image_name1;
                file_put_contents($file1, $image_base641);
                $product->thumbnail = $image_name1;
            }


            $product->save();

            if ($product) {
                if ($request->variant_name) {
                    $array = explode(',', $request->variant_name);
                    foreach ($array as $item) {
                        $data = new VariantProduct();
                        $data->product_id = $product->id;
                        $data->name = $item;
                        $data->save();
                    }
                }
                if ($request->image_gallery) {
                    foreach ($request->image_gallery as $key => $value) {
                        $data_image_gallery = new PhotoProduct();
                        $image_parts = explode(";base64,", $value);
                        $image_type_aux = explode("image/", $image_parts[0]);
                        $image_type = $image_type_aux[1];
                        $image_base64 = base64_decode($image_parts[1]);

                        $folderPath = storage_path('app/public/product_gallery/');
                        $image_name =  date('YmdHi') .  '_' . $key . '_' . $product->name  . '.' . $image_type;
                        $file = $folderPath . '' . $image_name;
                        file_put_contents($file, $image_base64);
                        $data_image_gallery->product_id = $product->id;
                        $data_image_gallery->image = $image_name;
                        $data_image_gallery->save();
                    }
                }
                DB::commit();
                Alert::success('Success', 'Berhasil mengubah Data Produk!');
                return redirect()->route('product.index');
            } else {
                DB::rollBack();
                Alert::error('Failed', 'Gagal mengubah Data Brand!');
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
            $data = Product::findOrFail($id);
            Storage::disk('public')->delete('product_thumbnail/' . $data->thumbnail);

            $photo =  PhotoProduct::where('product_id', $data->id)->get();
            foreach ($photo as $item) {
                Storage::disk('public')->delete('product_gallery/' . $item->image);
            }
            $data->delete();
            DB::commit();
            if ($data) {
                Alert::success('Success', 'Berhasil Menghapus Data Transaksi!');
                return redirect()->route('product.index');
            } else {
                DB::rollBack();
                Alert::success('Error', 'Gagal Menghapus Data Transaksi!');
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            Alert::error('Failed', $th->getMessage());
            return redirect()->back();
        }
    }

    public function is_active(Request $request, $id)
    {
        try {
            $data = Product::findOrFail($id);
            if ($data->is_active == 'yes') {
                $data->is_active = 'no';
            } else {
                $data->is_active = 'yes';
            }
            $data->save();

            if ($data) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Berhasil Merubah Status Produk',
                    'is_active' => $data->is_active
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Berhasil Merubah Status Produk'
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ]);
        }
    }

    public function delete_gallery($id)
    {
        DB::beginTransaction();
        try {
            $photo = PhotoProduct::lockForUpdate()->findOrFail($id);
            $photo->delete();
            DB::commit();
            Storage::disk('public')->delete('product_gallery/' . $photo->image);
            Alert::success('success', 'Berhasil menghapus foto produk!');
            return redirect()->back();
        } catch (\Throwable $th) {
            DB::rollBack();
            Alert::error('error', $th->getMessage());
            return redirect()->back();
        }
    }
    public function delete_variant($id)
    {
        DB::beginTransaction();
        try {
            $variant = VariantProduct::lockForUpdate()->findOrFail($id);
            $variant->delete();
            DB::commit();
            Alert::success('success', 'Berhasil menghapus variant produk!');
            return redirect()->back();
        } catch (\Throwable $th) {
            DB::rollBack();
            Alert::error('error', $th->getMessage());
            return redirect()->back();
        }
    }

    public function stock_report(Request $request)
    {
        $date_start = $request->get('date_start');
        $date_end = $request->get('date_end');

        if ($date_start || $date_end) {
            $date_start = empty($date_start) ? now() : $date_start;
            $date_end = empty($date_end) ? now() : $date_end;
            $data = Stock::with('product')->whereDate('date', '>=', $date_start)
                ->whereDate('date', '<=', $date_end)
                ->orderBy('date', 'ASC')
                ->paginate(30)
                ->withQueryString();

            $barang_keluar = Stock::where('type', 'out')->whereDate('date', '>=', $date_start)->whereDate('date', '<=', $date_end)->sum('qty');
            $barang_masuk = Stock::where('type', 'in')->whereDate('date', '>=', $date_start)->whereDate('date', '<=', $date_end)->sum('qty');

            $total_produk = Stock::whereDate('date', '>=', $date_start)->whereDate('date', '<=', $date_end)->count();
            return view('admin.stock.report', compact('data', 'barang_keluar', 'barang_masuk', 'total_produk', 'date_start', 'date_end'));
        }

        $barang_keluar = Stock::where('type', 'out')->sum('qty');
        $barang_masuk = Stock::where('type', 'in')->sum('qty');
        $total_produk = Stock::count();

        $data = Stock::with('product')->latest()->paginate(30)->withQueryString();
        return view('admin.stock.report', compact('data', 'barang_keluar', 'barang_masuk', 'total_produk'));
    }

    public function product_report()
    {
        $data = Product::with('stock_product')->latest()->get();
        foreach ($data as $value) {
            if ($value->stock_product->isNotEmpty()) {
                $value->stock_in = $value->stock_product->where('type', 'in')->sum('qty');
                $value->stock_out = $value->stock_product->where('type', 'out')->sum('qty');
            } else {
                $value->stock_in = 0;
                $value->stock_out = 0;
            }
        }

        $jumlah_produk = Product::get()->count();
        $produk_habis = Product::where('stock', 0)->get()->count();

        $pdf = Pdf::loadView('admin.product.report', ['data' => $data, 'jumlah_produk' => $jumlah_produk, 'produk_habis' => $produk_habis]);
        return $pdf->stream('report_product_stock_' . now() . '.pdf');
    }
}
