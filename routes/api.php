<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InformasiController;
use App\Http\Controllers\HamaController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('categories', [CategoryController::class, 'index']);
Route::get('categories/{id}', [CategoryController::class, 'show']);
Route::post('categories', [CategoryController::class, 'store']);
Route::put('categories/{id}', [CategoryController::class, 'update']); // Tambahkan baris ini untuk update
Route::delete('categories/{id}', [CategoryController::class, 'destroy']);

Route::get('products', [ProductController::class, 'index']);
Route::get('products/{id}', [ProductController::class, 'show']);
Route::get('products/category/{category_id}', [ProductController::class, 'getByCategory']); // Tambahkan baris ini
Route::post('/products', [ProductController::class, 'store']);
Route::put('products/{id}', [ProductController::class, 'update']);
Route::delete('products/{id}', [ProductController::class, 'destroy']);


Route::get('/hamas', [HamaController::class,'index']);
Route::post('/hamas', [HamaController::class,'store']);
Route::get('hamas/{id}', [HamaController::class,'show']);
Route::put('/hamas/{id}', [HamaController::class,'update']);
Route::delete('/hamas/{id}', [HamaController::class,'destroy']);

Route::get('/informasis', [InformasiController::class,'index']);
Route::post('/informasis', [InformasiController::class,'store']);
Route::get('informasis/{id}', [InformasiController::class,'show']);
Route::put('/informasis/{id}', [InformasiController::class,'update']);
Route::delete('/informasis/{id}', [InformasiController::class,'destroy']);



