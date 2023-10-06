<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InformasiController;
use App\Http\Controllers\PlantController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\HamaController;
use App\Http\Controllers\StageController;
use App\Http\Controllers\ContentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::controller(AdminController::class)->group(function () {
	Route::get('register', 'register')->name('register');
	Route::post('register', 'registerSimpan')->name('register.simpan');

	Route::get('login', 'login')->name('login');
	Route::post('login', 'loginAksi')->name('login.aksi');

	Route::get('logout', 'logout')->middleware('auth')->name('logout');
});

Route::get('/', function () {
	return view('welcome');
});


    Route::get('dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/informasi', [InformasiController::class, 'listdata'])->name('informasi.index');
    Route::get('/informasi/tambah', [InformasiController::class, 'tambah'])->name('informasi.tambah');
    Route::post('/informasi', [InformasiController::class, 'store'])->name('informasi.store');
    Route::delete('/informasi/{id}', [InformasiController::class, 'destroy'])->name('informasi.destroy');

    Route::get('/products', [ProductController::class, 'listdata'])->name('products.index');
    Route::get('/products/tambah', [ProductController::class, 'tambah'])->name('products.tambah');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

    Route::get('/categories', [CategoryController::class, 'listdata'])->name('categories.list');
    Route::get('/categories/tambah', [CategoryController::class, 'tambah'])->name('categories.tambah');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    Route::get('/plants', [PlantController::class, 'listdata'])->name('plants.index');
    Route::get('/plants/tambah', [PlantController::class, 'tambah'])->name('plants.tambah');
    Route::post('/plants', [PlantController::class, 'store'])->name('plants.store');
    Route::delete('/plants/{id}', [PlantController::class, 'destroy'])->name('plants.destroy');

    Route::get('/hamas', [HamaController::class, 'listdata'])->name('hamas.index');
    Route::get('/hamas/tambah', [HamaController::class, 'tambah'])->name('hamas.tambah');
    Route::post('/hamas', [HamaController::class, 'store'])->name('hamas.store');
    Route::delete('/hamas/{id}', [HamaController::class, 'destroy'])->name('hamas.destroy');

    Route::get('/banners', [BannerController::class, 'listdata'])->name('banners.index');
    Route::get('/banners/tambah', [BannerController::class, 'tambah'])->name('banners.tambah');
    Route::post('/banners', [BannerController::class, 'store'])->name('banners.store');
    Route::delete('/banners/{id}', [BannerController::class, 'destroy'])->name('banners.destroy');

    Route::get('/stages', [StageController::class, 'listdata'])->name('stages.index');
    Route::get('/stages/tambah', [StageController::class, 'tambah'])->name('stages.tambah');
    Route::post('/stages', [StageController::class, 'store'])->name('stages.store');
    Route::delete('/stages/{id}', [StageController::class, 'destroy'])->name('stages.destroy');

    Route::get('/contents', [ContentController::class, 'listdata'])->name('contents.index');
    Route::get('/contents/tambah', [ContentController::class, 'tambah'])->name('contents.tambah');
    Route::post('/contents', [ContentController::class, 'store'])->name('contents.store');
    Route::delete('/contents/{id}', [ContentController::class, 'destroy'])->name('contents.destroy');


