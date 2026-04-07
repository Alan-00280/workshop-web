<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MarketVendorController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\WilayahController;
use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\HomeController::class, 'landingPage'])->name('landing-page');
Route::get('/products', [App\Http\Controllers\HomeController::class, 'productsPage'])->name('products-page');
Route::get('/store/{id}', [App\Http\Controllers\HomeController::class, 'storeShow'])->name('store-show');

//? API ?//
Route::get('/products/filter', [MenuController::class, 'filterMenu'])->name('api-products-filter');
//? API ?//

Route::get('/cart', [App\Http\Controllers\HomeController::class, 'cartShow'])->name('cart-show');
Route::post('/cart', [CartController::class, 'cartPost'])->name('cart-post');
Route::put('/cart', [CartController::class, 'cartUpdateByArray'])->name('cart-put');

Route::get('/checkout', [PaymentController::class, 'goCheckOut'])->name('checkout-show');
Route::post('/checkout/save', [PaymentController::class, 'saveOrder'])->name('checkout-save');
Route::get('/checkout/sukses/{id}', [PaymentController::class, 'suksesShow'])->name('checkout-sukses');
Route::get('/checkout/gagal', [PaymentController::class, 'errorCheckout'])->name('checkout-error');

Route::middleware('isAnyAdmin')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'dashboard'])->name('dashboard');
});

Route::middleware('isVendorAdmin')->group(function () {
    Route::get('/store', [App\Http\Controllers\HomeController::class, 'storeVendorShow'])->name('store-vendor-show');

    Route::get('/orders', [App\Http\Controllers\HomeController::class, 'ordersVendorShow'])->name('orders-vendor-show');

    Route::get('/products-vendor', [App\Http\Controllers\HomeController::class, 'productsVendorShow'])->name('products-vendor-show');
    Route::get('/products/edit/{id}', [App\Http\Controllers\HomeController::class, 'productsVendorEdit'])->name('products-vendor-edit');
    Route::get('/products/add', [App\Http\Controllers\HomeController::class, 'productsVendorAdd'])->name('products-vendor-add');

    Route::patch('/products/edit/{id}', [MarketVendorController::class, 'productsVendorPatch'])->name('products-vendor-patch');
    Route::put('/products/add', [MarketVendorController::class, 'productsVendorPut'])->name('products-vendor-put');
    Route::delete('/products/delete/{id}', [MarketVendorController::class, 'productsVendorDelete'])->name('products-vendor-delete');
});

Route::middleware('isAdministrator')->group(function () {
    Route::get('/books', [App\Http\Controllers\HomeController::class, 'book'])->name('book');
    Route::get('/books/add', [App\Http\Controllers\HomeController::class, 'addBook'])->name('add-book');
    Route::get('/books/edit/{id}', [App\Http\Controllers\HomeController::class, 'editBook'])->name('edit-book');
    Route::post('/books/add', [App\Http\Controllers\BukuController::class, 'createBuku'])->name('create-book');
    Route::patch('/books/edit', [App\Http\Controllers\BukuController::class, 'updateBuku'])->name('update-book');
    Route::delete('/books/delete/{id}', [App\Http\Controllers\BukuController::class, 'deleteBuku'])->name('delete-book');

    Route::get('/book-categories', [App\Http\Controllers\HomeController::class, 'bookCategories'])->name('book-categories');
    Route::post('/book-categories/add', [App\Http\Controllers\CategoryController::class, 'createCateory'])->name('create-book-categories');
    Route::patch('/book-categories/edit', [App\Http\Controllers\CategoryController::class, 'editCategory'])->name('edit-book-categories');
    Route::delete('/book-categories/delete/{id}', [App\Http\Controllers\CategoryController::class, 'deleteCategory'])->name('delete-book-categories');
    Route::get('/book-categories/get/{id}', [App\Http\Controllers\CategoryController::class, 'getCategoryByID'])->name('get-book-categories');

    Route::get('/document', [HomeController::class, 'createDocument'])->name('create-document');
    Route::get('/document/generate/certificate', [HomeController::class, 'createCertificate'])->name('create-certificate');
    Route::post('/document/generate/certificate', [DocumentController::class, 'generateCertificate'])->name('generate-certificate');
    Route::get('/document/generate/invitation', [HomeController::class, 'createInvitation'])->name('create-invitation');
    Route::post('/document/generate/invitation', [DocumentController::class, 'generateInvitation'])->name('generate-invitation');

    Route::get('/barang', [HomeController::class, 'showBarang'])->name('show-barang');
    Route::get('/barang/edit/{id}', [HomeController::class, 'editBarang'])->name('edit-barang');
    Route::patch('/barang/edit', [BarangController::class, 'updateBarang'])->name('api-edit-barang');
    Route::get('/barang/add', [HomeController::class, 'addBarang'])->name('add-barang');
    Route::post('/barang/add', [BarangController::class, 'createBarang'])->name('api-add-barang');
    Route::delete('/barang/delete', [BarangController::class, 'deleteBarang'])->name('api-delete-barang');
    Route::post('/barang/cetak-label', [BarangController::class, 'cetakLabelShow'])->name('cetak-labelBarang-preview');
    Route::post('/barang/cetak-label-final', [DocumentController::class, 'generateLabels'])->name('cetak-labelBarang-final');
    Route::post('/barang/get', [BarangController::class, 'getBarang'])->name('get-barang');

    Route::get('/v2-brg', [HomeController::class, 'showBarangV2'])->name('show-barang-v2');
    Route::get('/v2datatable-brg', [HomeController::class, 'showBarangV2Datatable'])->name('show-barang-v2-datatable');

    Route::get('/kota', [HomeController::class, 'daftarKotaShow'])->name('show-kota');

    Route::get('/wilayah-ajax', [HomeController::class, 'wilayahShow'])->name('show-wilayah');
    Route::get('/wilayah-axios', [HomeController::class, 'wilayahShowAxios'])->name('show-wilayah-axios');
    Route::post('/wilayah/provinsi', [WilayahController::class, 'getProvinsi'])->name('get-provinsi');
    Route::post('/wilayah/kota', [WilayahController::class, 'getKota'])->name('get-kota');
    Route::post('/wilayah/kecamatan', [WilayahController::class, 'getKecamatan'])->name('get-kecamatan');
    Route::post('/wilayah/kelurahan', [WilayahController::class, 'getKelurahan'])->name('get-kelurahan');

    Route::get('/POS-ajax', [HomeController::class, 'POSShow'])->name('show-POS');
    Route::get('/POS-axios', [HomeController::class, 'POSShowAxios'])->name('show-POS-axios');
    Route::post('/penjualan', [PenjualanController::class, 'storePenjualan'])->name('post-penjualan');
        
});

// Auth Routes
Auth::routes(['reset' => false]);

Route::get('/logout', function () {
    Auth::logout();
    Session::flush();
    return redirect('/');
})->name('logout');

Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google-login-redirect');
Route::get('/auth/google/cb', [GoogleController::class, 'callback']);


Route::middleware('auth')->group(function () {
    Route::get('/verify-otp', [OtpController::class, 'show']);
    Route::post('/verify-otp', [OtpController::class, 'verify']);
});
