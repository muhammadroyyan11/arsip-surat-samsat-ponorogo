<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Simple authentication routes for demo
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (\Illuminate\Http\Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('dashboard');
    }

    return back()->withErrors([
        'email' => 'Kredensial tidak valid.',
    ])->onlyInput('email');
});

Route::post('/logout', function (\Illuminate\Http\Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return redirect('/dashboard');
    });

    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    // Mocks for Phase 4 to support Sidebar linking without crashing
    Route::resource('divisions', \App\Http\Controllers\DivisionController::class);
    Route::resource('positions', \App\Http\Controllers\PositionController::class);
    
    Route::resource('staffs', \App\Http\Controllers\StaffController::class);
    Route::resource('kategori-surats', \App\Http\Controllers\KategoriSuratController::class);
    
    Route::resource('users', \App\Http\Controllers\UserController::class);
    Route::get('users/{id}/access', [\App\Http\Controllers\UserController::class, 'getAccess']);
    Route::post('users/{id}/access', [\App\Http\Controllers\UserController::class, 'updateAccess']);
    
    Route::resource('surat-masuks', \App\Http\Controllers\SuratMasukController::class);
    Route::resource('surat-keluars', \App\Http\Controllers\SuratKeluarController::class);

    Route::resource('disposis', \App\Http\Controllers\DisposisiController::class);
    Route::post('disposis/{id}/done', [\App\Http\Controllers\DisposisiController::class, 'markDone']);

    Route::resource('menus', \App\Http\Controllers\MenuController::class);
    Route::resource('menu-sections', \App\Http\Controllers\MenuSectionController::class);
});
