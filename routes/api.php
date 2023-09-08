<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InformasiController;
use App\Http\Controllers\HamaController;
use App\Http\Controllers\PlantController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\StageController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;


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

Route::get('/users', [AuthController::class, 'getAllUsers']);
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/addresses', [AddressController::class, 'index']);
Route::post('/addresses', [AddressController::class, 'store']);
Route::put('/addresses/{id}', [AddressController::class, 'update']);
Route::delete('/addresses/{id}', [AddressController::class, 'destroy']);

Route::middleware('auth:sanctum')->post('/checkout', [OrderController::class, 'checkout']);
Route::middleware('auth:sanctum')->post('/callback', [OrderController::class, 'callback']);
Route::get('/user-transactions', [OrderController::class, 'userTransactions']);

Route::get('plants', [PlantController::class, 'index']);
Route::post('plants', [PlantController::class, 'store']);
Route::get('plants/{id}', [PlantController::class, 'show']);
Route::put('/plants/{id}', [PlantController::class, 'update']);
Route::delete('/plants/{id}', [PlantController::class, 'destroy']);

Route::get('/banners/plants/{plant_id}', [BannerController::class, 'getbyPlant']);
Route::get('/banners', [BannerController::class, 'index']);
Route::post('/banners', [BannerController::class, 'store']);
Route::get('banners/{id}', [BannerController::class, 'show']);
Route::put('/banners/{id}', [BannerController::class, 'update']);
Route::delete('/banners/{id}', [BannerController::class, 'destroy']);


Route::get('categories', [CategoryController::class, 'index']);
Route::get('/categories/{id}', [CategoryController::class, 'show']);
Route::post('categories', [CategoryController::class, 'store']);
Route::put('categories/{id}', [CategoryController::class, 'update']);
Route::delete('categories/{id}', [CategoryController::class, 'destroy']);

Route::get('products/category/{category_id}', [ProductController::class, 'getByCategory']);
Route::get('products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::post('/products', [ProductController::class, 'store']);
Route::put('/products/{id}', [ProductController::class, 'update']);
Route::delete('products/{id}', [ProductController::class, 'destroy']);

Route::get('cart', [CartController::class, 'index']);
Route::post('add-to-cart', [CartController::class, 'addToCart']);
Route::delete('remove-from-cart/{cartItemId}', [CartController::class, 'removeFromCart']);
Route::put('update-cart-item/{cartItemId}', [CartController::class, 'updateCartItem']);
Route::get('calculate-total-price', [CartController::class, 'calculateTotalPrice']);

Route::get('/hamas/plants/{plant_id}', [HamaController::class, 'getbyPlant']);
Route::get('/hamas', [HamaController::class,'index']);
Route::post('/hamas', [HamaController::class,'store']);
Route::get('hamas/{id}', [HamaController::class,'show']);
Route::put('/hamas/{id}', [HamaController::class,'update']);
Route::delete('/hamas/{id}', [HamaController::class,'destroy']);

Route::get('stages/banners/{banner_id}', [StageController::class, 'getByBanner']);
Route::get('/stages', [StageController::class,'index']);
Route::post('/stages', [StageController::class,'store']);
Route::get('stages/{id}', [StageController::class,'show']);
Route::put('/stages/{id}', [StageController::class,'update']);
Route::delete('/stages/{id}', [StageController::class,'destroy']);

Route::get('/contents/stages/{stage_id}', [ContentController::class, 'getbyStage']);
Route::get('/contents', [ContentController::class,'index']);
Route::post('/contents', [ContentController::class,'store']);
Route::get('contents/{id}', [ContentController::class,'show']);
Route::put('/contents/{id}', [ContentController::class,'update']);
Route::delete('/contents/{id}', [ContentController::class,'destroy']);

Route::get('/informasis', [InformasiController::class,'index']);
Route::post('/informasis', [InformasiController::class,'store']);
Route::get('informasis/{id}', [InformasiController::class,'show']);
Route::put('/informasis/{id}', [InformasiController::class,'update']);
Route::delete('/informasis/{id}', [InformasiController::class,'destroy']);



