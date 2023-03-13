<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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

Route::get('stats',[CountryController::class,'stats']);
Route::get('countries',[CountryController::class,'index']);

Route::group(['prefix'=>'country'],function(){
    Route::get('search',[CountryController::class,'search']);
    Route::post('add',[CountryController::class,'create']);
    Route::post('edit/{country_slug}',[CountryController::class,'edit']);
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
