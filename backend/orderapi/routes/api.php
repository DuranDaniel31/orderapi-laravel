<?php

use App\Http\Controllers\CausalController;
use App\Http\Controllers\ObservationController;
use App\Http\Controllers\TechnicianController;
use App\Http\Controllers\TypeActivityController;
use App\Models\TypeActivity;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/* Route::prefix('causal')->group(function () {
    Route::controller(CausalController::class)->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::get("/{causal}", "show");
        Route::put('/{causal}', 'update');
        Route::delete("/{causal}", "destroy");
    });
});  */

Route::apiResource('causal', CausalController::class);
Route::apiResource('observation', ObservationController::class);
Route::apiResource('technician', TechnicianController::class);
Route::apiResource('type_activity', TypeActivityController::class);
