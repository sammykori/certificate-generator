<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CertificatesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('certificates')->group(function () {

    Route::get('/create', function () {
        return view('create');
    })->middleware(['auth'])->name('certificates/create');

    Route::get('/{id}', [CertificatesController::class, 'show']);

    Route::get('/', [CertificatesController::class, 'cert'])->middleware(['auth'])->name('certificates');

    
});
Route::post('certificates/store', [CertificatesController::class, 'store'])->middleware(['auth'])->name('certificates/store');
Route::post('certificates/file-store', [CertificatesController::class, 'fileStore'])->middleware(['auth'])->name('certificates/file-store');
require __DIR__.'/auth.php';
