<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\PermissionController;
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

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    //APP SETTING  LINKS
    Route::get('/setting', [SettingController::class, 'index'])->name('setting');
    Route::post('/setting/store', [SettingController::class, 'storeSetting'])->name('setting.store');
    Route::post('/setting/update/{id}', [SettingController::class, 'storeSetting'])->name('setting.update');
    Route::get('/setting/seo', [SettingController::class, 'indexSeo'])->name('setting.seo');
    Route::post('/setting/seo/store', [SettingController::class, 'storeSeo'])->name('setting.seo.store');
    Route::post('/setting/seo/update/{id}', [SettingController::class, 'storeSeo'])->name('setting.seo.update');
    Route::get('/setting/social-media', [SettingController::class, 'indexSocilaMedia'])->name('setting.socila.media');
    Route::post('/setting/social-media/store', [SettingController::class, 'storeSocialMedia'])->name('setting.socila.media.store');
    Route::post('/setting/social-media/update/{id}', [SettingController::class, 'storeSocialMedia'])->name('setting.socila.media.update');


    // Permission management
    Route::resource('permissions', PermissionController::class);
    Route::get('/get/permissions/all', [PermissionController::class, 'permissions'])->name('get.all.permissions');
    // Permission management
    Route::resource('roles', RoleController::class);
    Route::get('/get/roles/all', [RoleController::class, 'roles'])->name('get.all.roles');

    // user management
    Route::resource('users', UserController::class);
    Route::get('/all-users', [UserController::class, 'index'])->name('all.users');
    Route::get('/users/staff', [UserController::class, 'index'])->name('all.staff');
    Route::get('/users/investor', [UserController::class, 'index'])->name('all.investor');
    Route::get('/users/candidate', [UserController::class, 'index'])->name('all.candidate');
    Route::get('/users/entrepreneur', [UserController::class, 'index'])->name('all.entrepreneur');
    Route::get('/get-users', [UserController::class, 'getAllUser'])->name('get.all.users');

    // user ajax
    Route::get('/get/users/all', [UserController::class, 'getAllUser'])->name('get.all.user');
    Route::get('/get/users/staff', [UserController::class, 'getAllAdminstrative'])->name('get.all.saff');
    Route::get('/get/users/investor', [UserController::class, 'getAllInvestor'])->name('get.all.investor');
    Route::get('/get/users/candidate', [UserController::class, 'getAllCandidate'])->name('get.all.candidate');
    Route::get('/get/users/entrepreneur', [UserController::class, 'getAllEntrepreneur'])->name('get.all.entrepreneur');
    Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
    Route::post('/user/active/{id}', [UserController::class, 'activity'])->name('user.activity');
    Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::post('/user/update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::post('/user/delete/{id}', [UserController::class, 'destroy'])->name('user.delete');
});
