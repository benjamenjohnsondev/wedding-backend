<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RsvpController;

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('login', [AuthController::class, 'authenticate']);

Route::group(['middleware' => ['jwt.verify', 'api', \App\Http\Middleware\TrustHosts::class]], function() {
    Route::get('logout', [AuthController::class, 'logout']);
    Route::post('get_user', [AuthController::class, 'getUser']);

    Route::post('update_rsvp', [RsvpController::class, 'updateUser']);
});
