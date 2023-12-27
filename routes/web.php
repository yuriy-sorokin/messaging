<?php

use App\Http\Controllers\LoginUserController;
use App\Http\Controllers\MessagesCreateController;
use App\Http\Controllers\MessagesDeleteController;
use App\Http\Controllers\MessagesEditController;
use App\Http\Controllers\MessagesListController;
use App\Http\Controllers\RegisterUserController;
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

Route::get('/', [MessagesListController::class, 'list'])->name('messages-list');

Route::get('/register', function () {
    return view('register_form');
})->name('register');

Route::post('/register', [RegisterUserController::class, 'register']);

Route::get('/login', function () {
    return view('login_form');
})->name('login');


Route::post('/login', [LoginUserController::class, 'login']);
Route::get('/logout', [LoginUserController::class, 'logout'])->name('logout');

Route::post('/messages/create', [MessagesCreateController::class, 'create'])->name('messages-create');
Route::get('/messages/delete/{id}', [MessagesDeleteController::class, 'delete'])->name('messages-delete');

Route::get('/messages/{id}', [MessagesEditController::class, 'edit'])->name('messages-edit');
Route::post('/messages/{id}', [MessagesEditController::class, 'update'])->name('messages-update');
