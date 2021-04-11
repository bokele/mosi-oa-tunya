<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SettingController;
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
});
