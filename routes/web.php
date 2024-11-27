<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Verified;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [AuthController::class, 'index']);

// Registration
Route::get('/register/user', [AuthController::class, 'registerUser'])->name('register.user');
Route::get('/register/author', [AuthController::class, 'registerAuthor'])->name('register.author');
Route::post('/register/{type}', [AuthController::class, 'store'])->name('register');

// Login
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/authenticate', [AuthController::class, 'authenticate'])->name('authenticate');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->middleware(['auth', 'verified']);

// Roles and Permission
Route::middleware(['auth', 'verified', 'role:super-admin'])->group(function () {
    Route::get('/permission', [PermissionController::class, 'index'])->name('index.permission');
    Route::get('/create-permission', [PermissionController::class, 'create'])->name('create.permission');
    Route::post('/permission', [PermissionController::class, 'store'])->name('store.permission');
    Route::get('/permission/edit/{id}', [PermissionController::class, 'edit'])->name('edit.permission');
    Route::post('/permission/{id}', [PermissionController::class, 'update'])->name('update.permission');
    Route::delete('/permission', [PermissionController::class, 'delete'])->name('delete.permission');

    Route::get('/role', [RoleController::class, 'index'])->name('index.role');
    Route::get('/create-role', [RoleController::class, 'create'])->name('create.role');
    Route::post('/role', [RoleController::class, 'store'])->name('store.role');
    Route::get('/role/edit/{id}', [RoleController::class, 'edit'])->name('edit.role');
    Route::post('/role/{id}', [RoleController::class, 'update'])->name('update.role');
    Route::delete('/role', [RoleController::class, 'delete'])->name('delete.role');
});

// Profile
Route::get('/profile', [AuthController::class, 'profile'])->name('profile')->middleware(['auth', 'verified']);

// Verify email notice
Route::get('/email/verify', function () {
    $user = auth()->user();

    if ($user->hasVerifiedEmail()) {
        return $user->hasRole('author|super-admin') ? redirect('/dashboard') : redirect('/');
    }

    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// Verify email with id and hash
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $user = $request->user();

    // Check if already verified
    if ($user->hasVerifiedEmail()) {
        return redirect($user->hasRole('author|super-admin') ? '/dashboard' : '/')->with('success', 'You are already verified.');
    }

    // Mark email as verified
    $user->markEmailAsVerified();
    event(new Verified($user));

    return redirect($user->hasRole('author|super-admin') ? '/dashboard' : '/')->with('success', 'Your email has been verified.');
})->middleware(['auth', 'signed'])->name('verification.verify');

// Resend verification notification
Route::post('/email/verification-notification', function (Request $request) {
    $user = $request->user();

    if ($user->hasVerifiedEmail()) {
        return redirect($user->hasRole('author|super-admin') ? '/dashboard' : '/')->with('success', 'You are already verified.');
    }

    $user->sendEmailVerificationNotification();
    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// Admin
Route::middleware(['auth', 'verified', 'role:super-admin|author'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // Blogs
    Route::get('/blogs', [BlogController::class, 'index'])->name('blog.index');
    Route::get('/blogs/create', [BlogController::class, 'create'])->name('blog.create');
    Route::post('/blogs/save', [BlogController::class, 'save'])->name('blog.save');
    Route::delete('/blog', [BlogController::class, 'delete'])->name('blog.delete');

    // Categories
    Route::get('/categories', [CategoryController::class, 'index'])->name('category.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('/categories/store', [CategoryController::class, 'store'])->name('category.store');
    Route::get('/category/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
    Route::post('/category/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/category', [CategoryController::class, 'delete'])->name('category.delete');

    // Tags
    Route::get('/tags', [TagController::class, 'index'])->name('tags.index');
    Route::get('/tags/create', [TagController::class, 'create'])->name('tags.create');
    Route::post('tags/store', [TagController::class, 'store'])->name('tags.store');
    Route::get('/tags/edit/{id}', [TagController::class, 'edit'])->name('tags.edit');
    Route::post('/tags/{id}', [TagController::class, 'update'])->name('tags.update');
    Route::delete('/delete', [TagController::class, 'delete'])->name('tags.delete');
});
