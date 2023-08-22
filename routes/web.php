<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;

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
    return view('home');
})->name('home');

Route::name('auth.')
    ->controller(AuthController::class)
    ->group(function () {
        Route::get('signup', 'signupForm')->name('signupForm');
        Route::post('signup', 'signup')->name('signup');
        Route::get('login', 'loginForm')->name('loginForm');
        Route::post('login', 'login')->name('login');
        Route::post('logout', 'logout')->name('logout'); // Ditambahkan
    });


Route::prefix('tasks')
->name('tasks.')
->controller(TaskController::class)
->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/', 'store')->name('store');  // Ditambahkan
    // Route::get('{id}/edit', 'edit')->name('edit');
    Route::get('{id}/edit', 'edit')->name('edit');
    Route::put('{id}/edit', 'update')->name('update');

    // Route delete
    Route::get('{id}/delete' , 'delete')->name('delete');
    Route::delete('{id}/delete' , 'destroy')->name('destroy');

    // Route Task Progress
    Route::get('progress', 'progress')->name('progress');
    // Route Move Task progress
    Route::patch('{id}/move', 'move')->name('move');
    Route::patch('{id}/check', 'move_tasklist')->name('move_tasklist');
   
});