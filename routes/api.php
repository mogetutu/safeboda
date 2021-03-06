<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('promo-codes/check', CheckPromoCode::class);
Route::post('promo-codes/deactivate', DeactivatePromocodes::class);
Route::get('promo-codes/active', ActivePromocodes::class);
Route::apiResource('promo-codes', Promocodes::class);
