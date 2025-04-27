<?php

use App\Http\Controllers\ConnectWithGoogleController;
use App\Http\Controllers\OauthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect(route("login"));
    // return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

# Oauth Routes ---> Login
Route::get('auth/redirect', [OauthController::class, 'redirect'])->name('oauth.redirect');
Route::get('auth/callback', [OauthController::class, 'HenadlercCallback'])->name('oauth.callback');


# Linking Account Routes ---> Google Connect
Route::get('account/connect/redirect', [ConnectWithGoogleController::class, 'redirectToGoogle'])->name('google.connect.redirect');

Route::get('account/connect/google', [ConnectWithGoogleController::class, 'handleGoogleCallback'])->name('google.connect.callback');

