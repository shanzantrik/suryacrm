<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\HolidayController;


Route::get('/', function () {
    return redirect('/login');
});
// Protect the dashboard route
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth');
// Protect all the other routes
Route::middleware('auth')->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('subcategories', SubCategoryController::class);
    Route::resource('states', StateController::class);
    Route::resource('districts', DistrictController::class);
    Route::get('holidays/calendar-data', [HolidayController::class, 'getHolidaysForCalendar']);
    Route::resource('holidays', HolidayController::class);
    Route::get('get-subcategories-by-category/{category_id}', [HolidayController::class, 'getSubcategoriesByCategory']);
});
// Authentication routes
Auth::routes();

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

// You can set a route to redirect to the dashboard after login
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
