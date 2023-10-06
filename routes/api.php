<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
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

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum', ], function() {
    Route::group(['prefix' => 'user'], function() {
        Route::get('/', function (Request $request) {
            return $request->user();
        });
        Route::post('logout', [AuthController::class, 'logout']);
        Route::put('edit', [UserController::class, 'edit']);
        Route::delete('delete', [UserController::class, 'delete']);
    });
    Route::apiResource('/posts', PostController::class);
    Route::group(['prefix' => 'post'], function() {
        Route::post('/like', [PostController::class, 'like']);
        Route::post('/comment', [PostController::class, 'comment']);
    });
    Route::get('tags', [TagController::class, 'index']);
    Route::post('tag', [TagController::class, 'store']);
});