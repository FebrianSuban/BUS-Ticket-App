<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\ScheduleController as AdminScheduleController;
use App\Http\Controllers\Admin\BusController as AdminBusController;
use App\Http\Controllers\Admin\RouteController as AdminRouteController;
use App\Http\Controllers\Admin\PaymentSettingController as AdminPaymentSettingController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\PaymentProofController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BusController;
use App\Http\Controllers\RouteController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/my-profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/bookings', [BookingController::class, 'myBookings'])->name('bookings.index');
    Route::get('/bookings/create/{schedule}', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::post('/bookings/{booking}/notify-payment', [BookingController::class, 'notifyPayment'])->name('bookings.notifyPayment');
    Route::post('/bookings/{booking}/upload-proof', [BookingController::class, 'uploadPaymentProof'])->name('bookings.uploadProof');
    Route::get('/payment-proofs/{paymentProof}', [PaymentProofController::class, 'show'])->name('payment-proofs.show');
    Route::get('/buses', [BusController::class, 'index'])->name('buses.index');
    Route::get('/routes', [RouteController::class, 'index'])->name('routes.index');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::patch('/bookings/{booking}/status', [AdminBookingController::class, 'updateStatus'])->name('bookings.updateStatus');

    Route::resource('schedules', AdminScheduleController::class)->only(['index', 'create', 'store', 'destroy']);
    Route::resource('buses', AdminBusController::class)->only(['index', 'create', 'store', 'destroy']);
    Route::resource('routes', AdminRouteController::class)->only(['index', 'create', 'store', 'destroy']);
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');

    // Payment settings
    Route::get('/payment-settings', [AdminPaymentSettingController::class, 'edit'])->name('payment_settings.edit');
    Route::post('/payment-settings', [AdminPaymentSettingController::class, 'update'])->name('payment_settings.update');
});

require __DIR__.'/auth.php';
