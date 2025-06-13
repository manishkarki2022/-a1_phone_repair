<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebSettingController;
use App\Http\Controllers\CategoryController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->prefix('admin')->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('backend.dashboard');
    })->name('dashboard');

    // Web Settings
    Route::get('/web-setting', [WebSettingController::class, 'show'])
         ->name('admin.web_setting.show');
    Route::post('/web-setting', [WebSettingController::class, 'update'])
         ->name('admin.web_setting.update');

         //Categories
    // Category Resource Routes
    Route::resource('categories', CategoryController::class);

    // Additional Category Routes
    Route::post('categories/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])
         ->name('categories.toggle-status');

    Route::get('api/categories', [CategoryController::class, 'getCategories'])
         ->name('categories.api');


});
