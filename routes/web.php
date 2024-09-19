<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return redirect('/login');
});
// Protect the dashboard route
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth');

// Authentication routes
Auth::routes();

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

// You can set a route to redirect to the dashboard after login
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
