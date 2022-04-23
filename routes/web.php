<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProfileController;
use App\Models\Setting;
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
    return redirect()->route('login');
});

$settingData = Setting::first();
Auth::routes([
    'reset' => !(($settingData->reset_password_enabled == 0)),
    'register' => !(($settingData->register_enabled == 0)),
    'verify' => true,
]);

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::resource('/roles', RoleController::class)->except('show');
    Route::resource('/permissions', PermissionController::class)->except('show');
    Route::resource('/users', UserController::class);
    Route::put('/users/reset/{user}/password', [UserController::class, 'resetPassword'])->name('users.reset.password');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile/{user}/update_password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::put('/profile/{user}/update_avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');
    Route::put('/profile/{user}', [ProfileController::class, 'updateGeneralData'])->name('profile.update');
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('/settings/update_general_data', [SettingController::class, 'updateGeneralData'])->name('settings.general.update');
    Route::put('/settings/update_logo', [SettingController::class, 'updateLogo'])->name('settings.logo.update');
});
