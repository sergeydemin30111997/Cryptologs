<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//Route::get('api/v1/log', [App\Http\Controllers\Api\v1\DataProcessingController::class, 'validateData']);
//Route::get('/api/v1/log', function (Request $request) {
//    return response()->json(['baz' => 'bar']);
//});
Route::group([
    'prefix' => 'v1'
], function () {
    Route::post('log', [App\Http\Controllers\Api\v1\LogsController::class, 'store']);
    Route::post('sum_up_balance', [App\Http\Controllers\Api\v1\UserController::class, 'update']);
    Route::post('search_project_logs', [App\Http\Controllers\Api\v1\ProjectLogsController::class, 'index']);
});
