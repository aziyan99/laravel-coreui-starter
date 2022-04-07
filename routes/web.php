<?php

use App\Http\Controllers\Admin\RoleController;
use Illuminate\Support\Facades\Route;

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
    return view('layouts.admin');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'admin'], function () {
    Route::resource('/roles', RoleController::class)->except('show');
    // Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    // Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
    // Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    // Route::get('/roles/{role}', [RoleController::class, 'edit'])->name('roles.edit');
    // Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
    // Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
});
