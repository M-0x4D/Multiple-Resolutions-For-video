<?php

use App\Http\Controllers\VideoController;
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

Route::post('/video', function(Request $request){
    if ($request->speed > 2) {
        return asset("storage/videos/240p_{$request->name}");
    }
});

//getVideoWithFitResolution
Route::post('fit/resolution', [VideoController::class , 'getVideoWithFitResolution'])->name('fit');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
