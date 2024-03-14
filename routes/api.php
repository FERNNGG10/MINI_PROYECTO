<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ConsoleController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\OrderConsoleController;
use App\Http\Controllers\OrderGameController;
use App\Http\Controllers\SaleConsoleController;
use App\Http\Controllers\SaleGameController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Models\Supplier;
use Monolog\Handler\RotatingFileHandler;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('register',[AuthController::class,'register']);
    Route::middleware(['status'])->post('login', [AuthController::class,'login']);
    Route::post('logout', [AuthController::class,'logout']);
    Route::post('refresh', [AuthController::class,'refresh']);
    Route::get('me', [AuthController::class,'me']);
    Route::get('activate/{user}',[AuthController::class,'activate'])->name('activate')->middleware('signed');
    Route::get('verifytoken',[AuthController::class,'verifytoken']);
});

Route::middleware('auth:api')->prefix('users')->group(function(){
    Route::middleware('admin')->get('index',[UserController::class,'index']);
    Route::middleware('admin')->post('store',[UserController::class,'store']);
    Route::middleware('admin')->get('show/{id}',[UserController::class,'show'])->where('id','[0-9]+');
    Route::middleware('admin')->put('update/{id}',[UserController::class,'update'])->where('id','[0-9]+');
    Route::middleware('admin')->delete('destroy/{id}',[UserController::class,'destroy'])->where('id','[0-9]+');
    Route::middleware('admin')->get('role',[UserController::class,'roles']);
});

Route::middleware('auth:api')->prefix('games')->group(function(){
    Route::middleware('admin.guest')->get('index',[GameController::class,'index']);
    Route::middleware('admin')->post('store',[GameController::class,'store']);
    Route::middleware('admin.guest')->get('show/{id}',[GameController::class,'show'])->where('id','[0-9]+');
    Route::middleware('admin')->put('update/{id}',[GameController::class,'update'])->where('id','[0-9]+');
    Route::middleware('admin')->delete('destroy/{id}',[GameController::class,'destroy'])->where('id','[0-9]+');
});


Route::middleware('auth:api')->prefix('consoles')->group(function(){
    Route::middleware('admin.guest')->get('index',[ConsoleController::class,'index']);
    Route::middleware('admin')->post('store',[ConsoleController::class,'store']);
    Route::middleware('admin.guest')->get('show/{id}',[ConsoleController::class,'show'])->where('id','[0-9]+');
    Route::middleware('admin')->put('update/{id}',[ConsoleController::class,'update'])->where('id','[0-9]+');
    Route::middleware('admin')->delete('destroy/{id}',[ConsoleController::class,'destroy'])->where('id','[0-9]+');
});


Route::middleware('auth:api')->prefix('categories')->group(function(){
    Route::get('index',[CategoryController::class,'index']);
    Route::middleware('admin.user')->post('store',[CategoryController::class,'store']);
    Route::get('show/{id}',[CategoryController::class,'show'])->where('id','[0-9]+');
    Route::middleware('admin.user')->put('update/{id}',[CategoryController::class,'update'])->where('id','[0-9]+');
    Route::middleware('admin')->delete('destroy/{id}',[CategoryController::class,'destroy'])->where('id','[0-9]+');

});


Route::middleware('auth:api')->prefix('suppliers')->group(function(){
    Route::middleware('admin.guest')->get('index',[SupplierController::class,'index']);
    Route::middleware('admin.user')->post('store',[SupplierController::class,'store']);
    Route::middleware('admin.guest')->get('show/{id}',[SupplierController::class,'show'])->where('id','[0-9]+');
    Route::middleware('admin.user')->put('update/{id}',[SupplierController::class,'update'])->where('id','[0-9]+');
    Route::middleware('admin')->delete('destroy/{id}',[SupplierController::class,'destroy'])->where('id','[0-9]+');
});


Route::middleware('auth:api')->prefix('games/sales')->group(function(){
    Route::get('index',[SaleGameController::class,'index']);
    Route::post('store',[SaleGameController::class,'store']);
    Route::get('show/{id}',[SaleGameController::class,'show'])->where('id','[0-9]+');

});

Route::middleware('auth:api')->prefix('consoles/sales')->group(function(){
    Route::middleware('admin.guest')->get('index',[SaleConsoleController::class,'index']);
    Route::post('store',[SaleConsoleController::class,'store']);
    Route::get('show/{id}',[SaleConsoleController::class,'show'])->where('id','[0-9]+');

});

Route::middleware('auth:api')->prefix('games/orders')->group(function(){
    Route::middleware('admin.guest')->get('index',[OrderGameController::class,'index']);
    Route::middleware('admin')->post('store',[OrderGameController::class,'store']);
    Route::middleware('admin.guest')->get('show/{id}',[OrderGameController::class,'show'])->where('id','[0-9]+');
});

Route::middleware('auth:api')->prefix('consoles/orders')->group(function(){
    Route::middleware('admin.guest')->get('index',[OrderConsoleController::class,'index']);
    Route::middleware('admin')->post('store',[OrderConsoleController::class,'store']);
    Route::middleware('admin.guest')->get('show/{id}',[OrderConsoleController::class,'show'])->where('id','[0-9]+');
   
});