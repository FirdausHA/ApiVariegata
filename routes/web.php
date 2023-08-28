<?php

use App\Http\Controllers\AuthController;
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

Route::controller(AuthController::class)->group(function () {
	Route::get('register', 'register')->name('register');
	Route::post('register', 'registerSimpan')->name('register.simpan');

	Route::get('login', 'login')->name('login');
	Route::post('login', 'loginAksi')->name('login.aksi');

	Route::get('logout', 'logout')->middleware('auth')->name('logout');
});

Route::get('/', function () {
	return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::prefix('product')->group(function () {
        Route::get('products', [ProductController::class, 'index'])->name('product');
        Route::get('products/tambah', [ProductController::class, 'tambah'])->name('product.tambah');
        Route::post('products/simpan', [ProductController::class, 'simpan'])->name('product.tambah.simpan');
        Route::get('products/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
        Route::post('products/update/{id}', [ProductController::class, 'update'])->name('product.update');
        Route::get('products/hapus/{id}', [ProductController::class, 'hapus'])->name('product.hapus');
    });

    Route::prefix('Category')->group(function () {
        Route::get('/category', [CategoryController::class, 'index'])->name('category');
        Route::get('/category/tambah', [CategoryController::class, 'tambah'])->name('category.tambah');
        Route::post('/category/simpan', [CategoryController::class, 'simpan'])->name('category.tambah.simpan');
        Route::get('/category/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
        Route::post('/category/update/{id}', [CategoryController::class, 'update'])->name('category.update');
        Route::get('/category/hapus/{id}', [CategoryController::class, 'hapus'])->name('category.hapus');
    });

    Route::prefix('informasi')->group(function () {
        Route::get('informasis', [InformasiController::class, 'index'])->name('informasi');
        Route::get('informasis/tambah', [InformasiController::class, 'tambah'])->name('informasi.tambah');
        Route::post('informasis/simpan', [InformasiController::class, 'simpan'])->name('informasi.tambah.simpan');
        Route::get('informasis/edit/{id}', [InformasiController::class, 'edit'])->name('informasi.edit');
        Route::post('informasis/update/{id}', [InformasiController::class, 'update'])->name('informasi.update');
        Route::get('informasis/hapus/{id}', [InformasiController::class, 'hapus'])->name('informasi.hapus');
    });

    Route::prefix('plant')->group(function () {
        Route::get('plants', [PlantController::class, 'index'])->name('plant');
        Route::get('plants/tambah', [PlantController::class, 'tambah'])->name('plant.tambah');
        Route::post('plants/simpan', [PlantController::class, 'simpan'])->name('plant.tambah.simpan');
        Route::get('plants/edit/{id}', [PlantController::class, 'edit'])->name('plant.edit');
        Route::post('plants/update/{id}', [PlantController::class, 'update'])->name('plant.update');
        Route::get('plants/hapus/{id}', [PlantController::class, 'hapus'])->name('plant.hapus');
    });

    Route::prefix('banner')->group(function () {
        Route::get('banners/', [BannerController::class, 'index'])->name('banner');
        Route::get('banners/tambah', [BannerController::class, 'tambah'])->name('banner.tambah');
        Route::post('banners/simpan', [BannerController::class, 'simpan'])->name('banner.tambah.simpan');
        Route::get('banners/edit/{id}', [BannerController::class, 'edit'])->name('banner.edit');
        Route::post('banners/update/{id}', [BannerController::class, 'update'])->name('banner.update');
        Route::get('banners/hapus/{id}', [BannerController::class, 'hapus'])->name('banner.hapus');
    });

    Route::prefix('stage')->group(function () {
        Route::get('stages/', [StageController::class, 'index'])->name('stage');
        Route::get('stages/tambah', [StageController::class, 'tambah'])->name('stage.tambah');
        Route::post('stages/simpan', [StageController::class, 'simpan'])->name('stage.tambah.simpan');
        Route::get('stages/edit/{id}', [StageController::class, 'edit'])->name('stage.edit');
        Route::post('stages/update/{id}', [StageController::class, 'update'])->name('stage.update');
        Route::get('stages/hapus/{id}', [StageController::class, 'hapus'])->name('stage.hapus');
    });

    Route::prefix('hama')->group(function () {
        Route::get('hamas/', [HamaController::class, 'index'])->name('hama');
        Route::get('hamas/tambah', [HamaController::class, 'tambah'])->name('hama.tambah');
        Route::post('hamas/simpan', [HamaController::class, 'simpan'])->name('hama.tambah.simpan');
        Route::get('hamas/edit/{id}', [HamaController::class, 'edit'])->name('hama.edit');
        Route::post('hamas/update/{id}', [HamaController::class, 'update'])->name('hama.update');
        Route::get('hamas/hapus/{id}', [HamaController::class, 'hapus'])->name('hama.hapus');
    });

    Route::prefix('content')->group(function () {
        Route::get('contents/', [ContentController::class, 'index'])->name('content');
        Route::get('contents/tambah', [ContentController::class, 'tambah'])->name('content.tambah');
        Route::post('contents/simpan', [ContentController::class, 'simpan'])->name('content.tambah.simpan');
        Route::get('contents/edit/{id}', [ContentController::class, 'edit'])->name('content.edit');
        Route::post('contents/update/{id}', [ContentController::class, 'update'])->name('content.update');
        Route::get('contents/hapus/{id}', [ContentController::class, 'hapus'])->name('content.hapus');
    });

});
