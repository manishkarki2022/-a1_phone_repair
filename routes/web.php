
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebSettingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest; // ← FIXED: Correct import

Route::get('/', function () {
    return view('welcome');
});

// ========================================
// EMAIL VERIFICATION ROUTES (Outside admin prefix)
// ========================================
Route::middleware('auth')->group(function () {
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect()->route('dashboard'); // ← FIXED: Use route name
    })->middleware(['signed'])->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Verification link sent!');
    })->middleware(['throttle:6,1'])->name('verification.send');
});

// ========================================
// ADMIN ROUTES (With admin prefix)
// ========================================
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'admin',
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

    // Categories
    Route::resource('categories', CategoryController::class);
    Route::post('categories/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])
         ->name('categories.toggle-status');
    Route::get('api/categories', [CategoryController::class, 'getCategories'])
         ->name('categories.api');

    // Brands
    Route::resource('brands', BrandController::class);

    // Products
    Route::resource('products', ProductController::class);

    // User Management
    Route::resource('users', UserController::class);
    Route::patch('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])
         ->name('users.toggle-status');
    Route::patch('users/{user}/reset-password', [UserController::class, 'resetPassword'])
         ->name('users.reset-password');
});
