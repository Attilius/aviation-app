<?php

use App\Http\Controllers\Checkout\AncillariesController;
use App\Http\Controllers\Checkout\PassengerController;
use App\Http\Controllers\Checkout\PaymentController;
use App\Http\Controllers\Invoice\InvoiceController;
use App\Http\Controllers\Pages\AboutController;
use App\Http\Controllers\Pages\ContactController;
use App\Http\Controllers\Pages\HomeController;
use App\Http\Controllers\Pages\ServicesController;
use App\Http\Controllers\Pages\TravelGuide\DestinationController;
use App\Http\Controllers\Pages\TravelGuide\FavoritePlacesController;
use App\Http\Controllers\Pages\TravelGuide\TravelGuideController;
use App\Http\Controllers\Pages\WelcomeController;
use App\Http\Controllers\Paypal\PaypalWebhookController;
use App\Http\Controllers\Services\BookingCancellationController;
use App\Http\Controllers\Services\GroupDiscountController;
use App\Http\Controllers\Services\LuggageInsuranceController;
use App\Http\Controllers\Services\PremiumComfortController;
use App\Http\Controllers\Services\PrivateJetRentController;
use App\Http\Controllers\Services\TravelInsuranceController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\Ticket\TicketController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\RoutePath;

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

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Route::post(RoutePath::for('register.subscriber', '/'),
    [SubscriberController::class, 'subscribe'])
    ->name('register.subscriber');

Route::post(RoutePath::for('contactMessage.store', '/contact'),
    [ContactController::class, 'store'])
    ->name('contactMessage.store');

Route::post('/webhooks/paypal/ipn',
    [PaypalWebhookController::class, 'verifyIPN'])->name('ipn-verify');

Route::get('/use-ipn',
    [PaypalWebhookController::class, 'useIpnMessage'])->name('use-ipn');


Route::get('/invoice', [InvoiceController::class, 'index']);
Route::get('/ticket', [TicketController::class, 'index']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('/about', [AboutController::class, 'index'])->name('about');

    Route::get('/services', [ServicesController::class, 'index'])->name('services');

    Route::get('/services/travel-insurance',
        [TravelInsuranceController::class, 'index'])->name('travel-insurance');

    Route::get('/services/luggage-insurance',
        [LuggageInsuranceController::class, 'index'])->name('luggage-insurance');

    Route::get('/services/premium-comfort',
        [PremiumComfortController::class, 'index'])->name('premium-comfort');

    Route::get('/services/private-jet-rent',
        [PrivateJetRentController::class, 'index'])->name('private-jet-rent');

    Route::get('/services/group-discount',
        [GroupDiscountController::class, 'index'])->name('group-discount');

    Route::get('/services/booking-cancellation',
        [BookingCancellationController::class, 'index'])->name('booking-cancellation');

    Route::get('/contact', [ContactController::class, 'index'])->name('contact');

    /* Booking progress endpoints */

    Route::get('/checkout/passenger-details',
        [PassengerController::class, 'index'])->name('create-passenger');

    Route::post('/checkout/passenger-details/cretate-reservation-cost',
        [PassengerController::class, 'createReservationCost'])->name('create-reservation-cost');

    Route::post('/checkout/passenger-details/cretate-passenger',
        [PassengerController::class, 'storePassenger'])->name('store-passenger');

    Route::post('/checkout/passenger-details/cretate-reservation-contact',
        [PassengerController::class, 'storeReservationContact'])->name('store-reservation-contact');

    Route::get('/checkout/ancillaries',
        [AncillariesController::class, 'index'])->name('create-ancillaries');

    Route::post('/checkout/ancillaries/create-reservation-cost',
        [AncillariesController::class, 'crateReservationCost'])->name('create-new-reservation-cost');

    Route::get('/checkout/payment',
        [PaymentController::class, 'index'])->name('summary-before-payment');

    Route::post('/checkout/paypal-payment',
        [PaymentController::class, 'paymentHandle'])->name('payment-handle');

    Route::get('/checkout/payment-success',
        [PaymentController::class, 'paymentSuccess'])->name('payment-success');

    Route::get('/checkout/payment/cancel',
        [PaymentController::class, 'paymentCancel'])->name('payment-cancel');

    Route::get('/checkout/payment/success',
        [PaymentController::class, 'successfullPayment'])->name('successfull-payment');

    Route::get('/travel-guide', [TravelGuideController::class, 'index'])->name('travel-guide');


    Route::get('/travel-guide/destination', [DestinationController::class, 'index'])->name('show-city');
    Route::post('/travel-guide/destination/{city}/{service}/{place}', [DestinationController::class, 'showService'])->name('show-service');

    Route::get('/user/favorites', [FavoritePlacesController::class, 'index'])->name('get-favorites');
    Route::post('/travel-guide/favorite/store', [FavoritePlacesController::class, 'addFavoritePlace'])->name('add-favorite');
    Route::post('/travel-guide/favorite/remove', [FavoritePlacesController::class, 'deleteFavoritePlace'])->name('remove-favorite');
});

require 'api.php';

// 404 Page Not Found endpoints

Route::get('/{any}', function () {
    return view('errors.404');
})->where('any', '.*');
