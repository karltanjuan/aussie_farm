<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KangarooController;

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
    return redirect('/kangaroos');
});


// Route::resource('kangaroos', KangarooController::class);

Route::get('/kangaroos', [KangarooController::class, 'index']);
Route::get('/kangaroos/list', [KangarooController::class, 'list']);
Route::post('/kangaroos/validate-name', [KangarooController::class, 'validateName']);
Route::get('/kangaroos/create', [KangarooController::class, 'create']);
Route::post('/kangaroos', [KangarooController::class, 'store']);
// Route::get('/kangaroos/{kangaroo}', [KangarooController::class, 'show']);
Route::get('/kangaroos/{kangaroo}/edit', [KangarooController::class, 'edit']);
Route::post('/kangaroos/{kangaroo}', [KangarooController::class, 'update']);
Route::delete('/kangaroos/{kangaroo}', [KangarooController::class, 'destroy']);
