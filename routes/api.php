<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AlatController;
use App\Http\Controllers\BenihController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PupukController;
use App\Http\Controllers\InformasiController;
use App\Http\Controllers\HamaController;
use App\Http\Controllers\KatalogController;


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

Route::get('/products', [ProductController::class,'index']);
Route::post('/products', [ProductController::class,'store']);
Route::get('products/{id}', [ProductController::class,'show']);
Route::put('/products/{id}', [ProductController::class,'update']);
Route::delete('/products/{id}', [ProductController::class,'destroy']);

Route::get('/katalogs', [KatalogController::class,'index']);
Route::post('/katalogs', [KatalogController::class,'store']);
Route::get('katalogs/{id}', [KatalogController::class,'show']);
Route::put('/katalogs/{id}', [KatalogController::class,'update']);
Route::delete('/katalogs/{id}', [KatalogController::class,'destroy']);

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

Route::get('/pupuks', [PupukController::class,'index']);
Route::post('/pupuks', [PupukController::class,'store']);
Route::get('pupuks/{id}', [PupukController::class,'show']);
Route::put('/pupuks/{id}', [PupukController::class,'update']);
Route::delete('/pupuks/{id}', [PupukController::class,'destroy']);

Route::get('/obats', [ObatController::class,'index']);
Route::post('/obats', [ObatController::class,'store']);
Route::get('obats/{id}', [ObatController::class,'show']);
Route::put('/obats/{id}', [ObatController::class,'update']);
Route::delete('/obats/{id}', [ObatController::class,'destroy']);

Route::get('/benihs', [BenihController::class,'index']);
Route::post('/benihs', [BenihController::class,'store']);
Route::get('benihs/{id}', [BenihController::class,'show']);
Route::put('/benihs/{id}', [BenihController::class,'update']);
Route::delete('/benihs/{id}', [BenihController::class,'destroy']);

Route::get('/alats', [AlatController::class,'index']);
Route::post('/alats', [AlatController::class,'store']);
Route::get('alats/{id}', [AlatController::class,'show']);
Route::put('/alats/{id}', [AlatController::class,'update']);
Route::delete('/alats/{id}', [AlatController::class,'destroy']);



