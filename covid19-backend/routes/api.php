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
Route::get('country/search',[CountryController::class,'search']);
Route::get('country/add',[CountryController::class,'create']);



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
