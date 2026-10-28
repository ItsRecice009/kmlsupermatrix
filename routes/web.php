<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DesignatorController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\KmlProjectController;


// Protected Routes - Require login
Route::get('/', function () {
    return view('index');
})->middleware('auth')->name('dashboard');

Route::get('/dashboard', function () {
    return view('index');
})->middleware('auth');

Route::get('/dashboard2', function () {
    return view('index2');
})->name('dashboard2');

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout.get');
Route::get('/switch-account', [LoginController::class, 'switchAccount'])->name('switch.account');

// Registration Routes (Pendaftaran mandiri dinonaktifkan - dialihkan ke login)
Route::get('/register', function () {
    return redirect()->route('login')->with('info', 'Pendaftaran mandiri dinonaktifkan. Pembuatan akun pegawai dilakukan langsung oleh Administrator.');
})->name('register');
Route::post('/register', function () {
    return redirect()->route('login');
})->name('register.submit');

// Session close API (for browser close event)
Route::post('/api/session-close', [LoginController::class, 'sessionClose'])->middleware('auth');

// Admin Routes (require admin role)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    // Admin Dashboard dialihkan ke Kelola Pegawai
    Route::get('/', function () {
        return redirect()->route('admin.pegawai.index');
    })->name('admin.dashboard');
    
    // Kelola Pegawai
    Route::get('/pegawai', [App\Http\Controllers\PegawaiController::class, 'index'])->name('admin.pegawai.index');
    Route::post('/pegawai', [App\Http\Controllers\PegawaiController::class, 'store'])->name('admin.pegawai.store');
    Route::put('/pegawai/{id}', [App\Http\Controllers\PegawaiController::class, 'update'])->name('admin.pegawai.update');
    Route::delete('/pegawai/{id}', [App\Http\Controllers\PegawaiController::class, 'destroy'])->name('admin.pegawai.destroy');
    Route::post('/pegawai/{id}/reset-password', [App\Http\Controllers\PegawaiController::class, 'resetPassword'])->name('admin.pegawai.reset-password');
});

// API Routes untuk Designators
Route::get('/api/designators', [DesignatorController::class, 'index']);
Route::post('/api/designators', [DesignatorController::class, 'store']);
Route::post('/api/designators/validate', [DesignatorController::class, 'validateDesignators']);
Route::put('/api/designators/{id}', [DesignatorController::class, 'update']);
Route::delete('/api/designators/{id}', [DesignatorController::class, 'destroy']);

// API Routes untuk KML Projects (Data Manager)
Route::get('/api/dashboard/stats', [KmlProjectController::class, 'getDashboardStats'])->middleware('auth');
Route::get('/api/kml-projects', [KmlProjectController::class, 'index']);
Route::post('/api/kml-projects', [KmlProjectController::class, 'store']);
Route::get('/api/kml-projects/{id}', [KmlProjectController::class, 'show']);
Route::match(['put', 'post'], '/api/kml-projects/{id}', [KmlProjectController::class, 'update']);
Route::delete('/api/kml-projects/{id}', [KmlProjectController::class, 'destroy']);
Route::get('/api/kml-projects/{id}/download', [KmlProjectController::class, 'download']);

