<?php

use App\Http\Controllers\ItemsController;
use App\Http\Controllers\PitchController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth:sanctum'])->group(
    function () {
        Route::get(
            '/user',
            function (Request $request) {
                return (new UserResource($request->user()));
            }
        );

        Route::post('roles/{role}/syncPermissions', [RoleController::class, 'syncPermissions']);
        Route::resource('roles', RoleController::class);
        Route::resource('users', UserController::class);
    }
);
Route::resource('players', PlayerController::class);
Route::resource('items', ItemsController::class);
Route::resource('pitches',PitchController::class);
Route::resource('/player/{id}/pitching_stats',[PlayerController::class]);
