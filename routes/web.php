<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\EventBookingController;
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

Route::get('/', function () {
    return view('home');
});

Route::get('/plans', function () {
    return view('plans');
});

Route::get('/contact', function () {
    return view('contact');
});

// Route::get('events', function () {
//     return view('events', [
//         'events' => App\Models\Event::all()
//     ]);
// });

// Objective: limit Event controller to Index + CRUD as a set standard
Route::get('events', [EventController::class, 'index'])->name('events');
Route::get('events/create', [EventController::class, 'create']);
Route::post('events/create', [EventController::class, 'store']);
Route::get('events/{event:slug}', [EventController::class, 'show']);
Route::get('events/{event:slug}/edit', [EventController::class, 'edit']);
Route::get('events/{event:slug}/edit', [EventController::class, 'update']);

Route::get('bookings/create', [EventBookingController::class, 'create']);
Route::get('bookings/create', [EventBookingController::class, 'store']);
Route::get('bookings/{event:slug}', [EventBookingController::class, 'show']);