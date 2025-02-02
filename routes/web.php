<?php

use App\Http\Controllers\Admin\BrandController as AdminBrandController;
use App\Http\Controllers\Admin\BannerController as AdminBannerController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\FinanceController as AdminFinanceController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\TransactionController as AdminTransactionController;
use App\Http\Controllers\Admin\StockController as AdminStockController;
use App\Http\Controllers\Pages\CartController;
use App\Http\Controllers\Pages\HomeController;
use App\Http\Controllers\Pages\ProductController;
use App\Http\Controllers\Pages\ProfileController;
use App\Http\Controllers\Pages\TransactionController;
use App\Http\Controllers\TrackingController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Auth::routes(['verify' => true]);

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index']);
Route::get('/category', [HomeController::class, 'show_category'])->name('pages.show.category');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('pages.show.product');

Route::get('/search', [HomeController::class, 'search'])->name('pages.search');

Route::group(['middleware' => 'auth', 'middleware' => 'verified'], function () {

    Route::get('/cart', [CartController::class, 'index'])->name('pages.cart.index');
    Route::get('/cart/store/{product_id}', [CartController::class, 'add'])->name('pages.cart.store');
    Route::post('/cart/delete/{product_id}', [CartController::class, 'destroy'])->name('pages.cart.destroy');

    Route::post('/checkout', [TransactionController::class, 'checkout'])->name('pages.checkout.index');
    Route::post('/checkout-process', [TransactionController::class, 'checkout_process'])->name('pages.checkout.process');
    Route::get('order/invoice/{id}', [TransactionController::class, 'invoice'])->name('order.invoice');

    Route::get('/profile/{id}', [ProfileController::class, 'show_profile'])->name('pages.profile.index');

    Route::get('/order-tracking', [TrackingController::class, 'index'])->name('pages.tracking');


    // ADMIN
    Route::group(['middleware' => 'check.admin', 'prefix' => 'admin/'], function () {
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard.admin');

        Route::resource('brand', AdminBrandController::class);
        Route::resource('banner', AdminBannerController::class);
        Route::resource('category', AdminCategoryController::class);
        Route::resource('product', AdminProductController::class);

        Route::get('product-report', [AdminProductController::class, 'product_report'])->name('product.report');
        Route::post('product-active-status/{id}', [AdminProductController::class, 'is_active'])->name('product.is_active');
        Route::post('product-gallery/delete/{id}', [AdminProductController::class, 'delete_gallery'])->name('product-pic.delete');
        Route::post('product-variant/delete/{id}', [AdminProductController::class, 'delete_variant'])->name('product-variant.delete');
        Route::post('product-variant/delete/{id}', [AdminProductController::class, 'delete_variant'])->name('product-variant.delete');

        Route::get('order', [AdminTransactionController::class, 'index'])->name('order.index');
        Route::get('order/{id}', [AdminTransactionController::class, 'show'])->name('order.show');
        Route::post('order/delete/{id}', [AdminTransactionController::class, 'destroy'])->name('order.destroy');
        Route::post('order/change-status-order/{id}', [AdminTransactionController::class, 'change_status_order'])->name('order.change-status');

        Route::get('user', [AdminUserController::class, 'index'])->name('admin.user.index');
        Route::get('user/create', [AdminUserController::class, 'create'])->name('admin.user.create');
        Route::post('user/store', [AdminUserController::class, 'store'])->name('admin.user.store');
        Route::get('user/edit/{id}', [AdminUserController::class, 'edit'])->name('admin.user.edit');
        Route::put('user/update/{id}', [AdminUserController::class, 'update'])->name('admin.user.update');
        Route::post('user/delete/{id}', [AdminUserController::class, 'destroy'])->name('admin.user.destroy');
        Route::get('/user/report/', [AdminUserController::class, 'report'])->name('admin.user.report');

        Route::group(['middleware' => 'check.bendahara'], function () {
            Route::get('/finance', [AdminFinanceController::class, 'index'])->name('finance.index');
            Route::get('/finance/report/', [AdminFinanceController::class, 'report'])->name('finance.report');
            Route::post('finance/delete/{id}', [AdminFinanceController::class, 'destroy'])->name('finance.destroy');
        });

        Route::group(['middleware' => 'check.warehouse'], function () {
            Route::get('product-stock-report', [AdminProductController::class, 'stock_report'])->name('product.stock.report');
            Route::get('stock', [AdminStockController::class, 'index'])->name('stock.index');
            Route::get('stock/report', [AdminStockController::class, 'report'])->name('stock.report');
            Route::post('stock/delete/{id}', [AdminStockController::class, 'destroy'])->name('stock.destroy');
            Route::post('stock/add/{product_id}', [AdminStockController::class, 'add'])->name('stock.add');
        });
    });
});
