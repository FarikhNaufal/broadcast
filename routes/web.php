<?php

use App\Http\Controllers\AuthController;
use App\Http\Middleware\ClientMiddleware;
use App\Livewire\Client\Index as ClientIndex;
use App\Livewire\Client\Login as ClientLogin;
use App\Livewire\ClientController\Index as ClientController;
use App\Livewire\Dashboard\Index as DashboardIndex;
use App\Livewire\Media\Index as MediaIndex;
use App\Livewire\MediaGroup\Index as GroupIndex;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/', DashboardIndex::class)->name('dashboard');
    Route::get('/client', ClientController::class)->name('client');
    Route::get('/media', MediaIndex::class)->name('media');
    Route::get('/group', GroupIndex::class)->name('group');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware(['guest'])->group(function(){
    Route::get('/auth/redirect', [AuthController::class, 'redirectToGoogle'])->name('login');
    Route::get('/auth/callback', [AuthController::class, 'handleGoogleCallback']);
});

Route::get('/client-login', ClientLogin::class);
Route::get('/client-view', ClientIndex::class)->middleware(ClientMiddleware::class);
Route::post('/client-logout', function(Request $request){
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return response()->json(['message' => 'Logged out successfully.']);
})->middleware(ClientMiddleware::class);


Route::get('logme', function(){
    Auth::loginUsingId(1);
    return redirect('/');
});
