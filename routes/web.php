<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Request;
use App\Http\Controllers\PostController;
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

Route::get('/welcome', function () {
    return view('welcome');
})->middleware('guest')
    ->name('welcome');

Route::get('/', [PostController::class, 'index'])
    ->middleware('auth')
    ->name('root');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('advisor/register', function () {
    return view('advisor.register');
})->middleware('guest')
    ->name('advisor.register');

Route::resource('posts', PostController::class)
    ->only(['create', 'store', 'edit', 'update', 'destroy'])
    ->middleware('can:advisor');

Route::resource('posts', PostController::class)
    ->only(['show', 'index'])
    ->middleware('auth');
