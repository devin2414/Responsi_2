<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Auth;


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

// Halaman utama
Route::get('/', function () {
    return view('welcome');
});


// Dashboard dengan middleware auth dan verified
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rute untuk profil pengguna
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('/admin/products', ProductController::class)->names([
        'index' => 'admin.products.index',
        'create' => 'admin.products.create',
        'store' => 'admin.products.store',
        'edit' => 'admin.products.edit',
        'update' => 'admin.products.update',
        'destroy' => 'admin.products.destroy',
    ]);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return view('dashboard'); // Halaman dashboard user
    })->middleware(['auth', 'verified'])->name('dashboard');
    
});


// Route::get('/', function () {
//     return view('welcome');
// })->name('welcome');

Route::get('/', function () {
    return view('welcome');
})->name('home');


// Halaman pemberitahuan verifikasi email
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// Proses verifikasi email
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');

// Kirim ulang email verifikasi
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// Halaman konfirmasi password
Route::get('/confirm-password', function () {
    return view('auth.confirm-password');
})->middleware(['auth', 'verified'])->name('password.confirm');

// Proses konfirmasi password
Route::post('/confirm-password', function (Request $request) {
    if (!Hash::check($request->password, $request->user()->password)) {
        return back()->withErrors(['password' => 'Password Anda salah.']);
    }

    $request->session()->put('password_confirmed_at', time());

    return redirect()->intended('dashboard');
})->middleware(['auth', 'verified']);

Route::get('/results', function () {
    return view('results-page'); // Sesuaikan dengan nama file Blade Anda
})->name('results');

Route::get('/about-me', function () {
    return view('about-me');
});

Route::get('/welcome', function () {
    return view('welcome');
})->middleware('auth')->name('welcome');

Route::get('/login', function () {
    if (auth()->check()) {
        return redirect('/welcome');
    }
    return view('auth.login'); // Sesuaikan dengan view form login Anda
})->name('login');



Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/admin', [AdminController::class, 'index']);

// Logout Route
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/'); // Redirect to welcome.blade.php
})->name('logout');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/admin/product', [ProductController::class,'index'])->name('products.index');
Route::get('/admin/product/create', [ProductController::class,'create'])->name('products.create');
Route::post('/admin/product/store', [ProductController::class,'store'])->name('products.store');
Route::get('/admin/product/edit/{id}', [ProductController::class,'edit'])->name('products.edit');
Route::get('/admin/product/destroy/{id}', [ProductController::class,'destroy'])->name('products.destroy');
Route::get('/admin/product/collections', [ProductController::class,'show'])->name('products.show');
Route::get('/admin/product/update', [ProductController::class,'update'])->name('products.update');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');



// Rute untuk otentikasi
require __DIR__ . '/auth.php';