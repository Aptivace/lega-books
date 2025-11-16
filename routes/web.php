<?php

use App\Http\Controllers\AdminController;
use App\Http\Middleware\CheckAdmin;
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

Route::get('/', [AdminController::class, 'index']);

Route::post('/login', [AdminController::class, "login"]);
Route::get('/logout', [AdminController::class, "logout"]);

Route::middleware([CheckAdmin::class])->group(function () {
    Route::post('/books',[\App\Http\Controllers\BookController::class, "store"]);
    Route::post('/authors', [\App\Http\Controllers\AuthorController::class, "store"] );
    Route::post('/genres', [\App\Http\Controllers\GenreController::class, "store"] );
    Route::delete('/books/{book}', [\App\Http\Controllers\BookController::class, "destroy"]);
});
