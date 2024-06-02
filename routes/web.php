<?php

use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::post('/upload-video', [VideoController::class, 'upload']);

Route::get('/upload', function(){
    return view('upload');
})->name('upload');





Route::get('/', function () {
//    return view('welcome');
    return redirect()->route('upload');
});
