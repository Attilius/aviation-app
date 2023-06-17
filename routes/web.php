<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\SubscriberController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\RoutePath;
use App\Http\Controllers\Services\TravelInsuranceController;

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
    return Inertia::render('Welcome', ['status' => session('status')]);
});

Route::post(RoutePath::for('register.subscriber', '/'),
    [SubscriberController::class, 'subscribe'])
    ->name('register.subscriber');

Route::post(RoutePath::for('contactMessage.store', '/contact'),
    [ContactController::class, 'store'])
    ->name('contactMessage.store');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/home', function () {
        return Inertia::render('Home');
    })->name('home');

    Route::get('/about', function () {
        return Inertia::render('About');
    })->name('about');

    Route::get('/services', function () {
        return Inertia::render('Services');
    })->name('services');

    Route::get('/services/travel-insurance',
        [TravelInsuranceController::class, 'index'])->name('travel-insurance');

    Route::get('/contact', function () {
        return Inertia::render('Contact', ['status' => session('status')]);
    })->name('contact');
});
