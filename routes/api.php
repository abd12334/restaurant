<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\OrderController;
use App\Http\Resources\RestaurantResource;
use App\Models\restaurant;
use App\Http\Resources\OrderResource;
use App\Models\order;
use App\Http\Traits\GeneralTrait;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/register', [AuthController::class,'register']);
Route::post('/logout', [AuthController::class,'logout']);
Route::post('/login', [AuthController::class,'login'])->name('login');

#Route::get('/api/restaurants', function () {
    #return RestaurantResource::collection(Restaurant::all());
#});
Route::get('/restaurant', [RestaurantController::class,'index']);
Route::post('/restaurant/search', [RestaurantController::class,'search']);
Route::get('/restaurant/show/{id}', [RestaurantController::class,'show'])->name('show');
Route::post('/orders', [OrderController::class,'showByName']);
Route::post('/order/ask', [OrderController::class,'store']);
Route::post('/order/cancel/{id}', [OrderController::class,'OrderStatus']);
#Route::get('/api/restaurants/{id}', function ($id) {
    #return RestaurantResource::make(Restaurant::findOrFail($id));
#});