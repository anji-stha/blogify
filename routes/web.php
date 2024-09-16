<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

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
Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

// Registration
Route::get('/register/user', [AuthController::class, 'registerUser'])->name('register.user');
Route::get('/register/author', [AuthController::class, 'registerAuthor'])->name('register.author');
Route::post('/register/{type}', [AuthController::class, 'store'])->name('register');

// Login
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/authenticate', [AuthController::class, 'authenticate'])->name('authenticate');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Permission
Route::get('/permission', [PermissionController::class, 'index'])->name('index.permission');
Route::get('/create-permission', [PermissionController::class, 'create'])->name('create.permission');
Route::post('/permission', [PermissionController::class, 'store'])->name('store.permission');
Route::get('/permission/edit/{id}', [PermissionController::class, 'edit'])->name('edit.permission');
Route::post('/permission/{id}', [PermissionController::class, 'update'])->name('update.permission');
Route::delete('/permission', [PermissionController::class, 'delete'])->name('delete.permission');

// Roles
Route::get('/role', [RoleController::class, 'index'])->name('index.role');
Route::get('/create-role', [RoleController::class, 'create'])->name('create.role');
Route::post('/role', [RoleController::class, 'store'])->name('store.role');
Route::get('/role/edit/{id}', [RoleController::class, 'edit'])->name('edit.role');
Route::post('/role/{id}', [RoleController::class, 'update'])->name('update.role');
Route::delete('/role', [RoleController::class, 'delete'])->name('delete.role');


// Profile
Route::get('/profile', [AuthController::class, 'profile'])->name('profile');

// Verify email
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
