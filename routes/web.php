<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\EventBookingController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;

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

Route::get('/plans', function () {
    return view('plans');
});

Route::get('/contact', function () {
    return view('contact');
});

Route::get('login', [SessionController::class, 'create'])->middleware('guest');
Route::post('login', [SessionController::class, 'store']);
Route::get('logout', [SessionController::class, 'destroy'])->middleware('auth');

Route::get('/', [EventController::class, 'home']);
// Objective: RESTful Events Controller
    // Route::resource('events', EventController::class); //->except('show');
Route::get('events', [EventController::class, 'index'])->name('events');
Route::post('events', [EventController::class, 'store']);
Route::get('events/create', [EventController::class, 'create']);
Route::get('events/{event:slug}/edit', [EventController::class, 'edit']);
Route::get('events/{event:slug}', [EventController::class, 'show']);
// Route::patch('events/{event:slug}', [EventController::class, 'update']);
// Route::delete('events/{event:slug}', [EventController::class, 'destroy']);

Route::get('bookings/{user:id}/review/{selected_date?}', [EventBookingController::class, 'edit']);
Route::get('bookings/{event:slug}/{selected_date?}', [EventBookingController::class, 'show']);
Route::post('bookings/{event:id}', [EventBookingController::class, 'store']);
Route::delete('bookings/{id}', [EventBookingController::class, 'destroy']);
