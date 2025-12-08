<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DeveloperController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('language/{locale}', function ($locale) {
    if (! in_array($locale, ['en', 'pt'])) abort(400);
    session(['locale' => $locale]);
    return redirect()->back()->withCookie(cookie('crow_locale', $locale, 525600));
})->name('language.switch');

Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');
Route::post('/properties/{property}/visit', [PropertyController::class, 'sendVisitRequest'])->name('properties.visit');
Route::post('/access-request', [App\Http\Controllers\AccessRequestController::class, 'store'])->name('access-request.store');

Route::middleware(['auth', 'active_access'])->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'admin') return redirect()->route('admin.dashboard');
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('can:manageProperties,App\Models\User')->group(function () {
        Route::get('/my-properties', [PropertyController::class, 'myProperties'])->name('properties.my');
        Route::get('/properties/create', [PropertyController::class, 'create'])->name('properties.create');
        Route::post('/properties', [PropertyController::class, 'store'])->name('properties.store');
        Route::get('/properties/{property}/edit', [PropertyController::class, 'edit'])->name('properties.edit');
        Route::patch('/properties/{property}', [PropertyController::class, 'update'])->name('properties.update');
        Route::delete('/properties/{property}', [PropertyController::class, 'destroy'])->name('properties.destroy');

        Route::get('/my-clients', [DeveloperController::class, 'index'])->name('developer.clients');
        Route::post('/my-clients', [DeveloperController::class, 'store'])->name('developer.clients.store');
        Route::patch('/my-clients/{client}/toggle', [DeveloperController::class, 'toggleClientStatus'])->name('developer.clients.toggle');
        Route::patch('/my-clients/{client}/toggle-market', [DeveloperController::class, 'toggleMarketAccess'])->name('developer.clients.toggle-market');
        Route::patch('/my-clients/{client}/reset-password', [DeveloperController::class, 'resetClientPassword'])->name('developer.clients.reset-password');
        Route::delete('/my-clients/{client}', [DeveloperController::class, 'destroy'])->name('developer.clients.destroy');
        
        Route::get('/properties/{property}/access-list', [PropertyController::class, 'getAccessList'])->name('properties.access-list');
        Route::post('/properties/{property}/access', [DeveloperController::class, 'toggleAccess'])->name('properties.access');
    });

    Route::middleware('can:isAdmin,App\Models\User')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        
        Route::get('/access-requests', [AdminController::class, 'accessRequests'])->name('access-requests');
        Route::get('/access-requests/{accessRequest}', [AdminController::class, 'showAccessRequest'])->name('access-requests.show');
        Route::patch('/access-requests/{accessRequest}/approve', [AdminController::class, 'approveAccessRequest'])->name('access-requests.approve');
        Route::patch('/access-requests/{accessRequest}/reject', [AdminController::class, 'rejectAccessRequest'])->name('access-requests.reject');
        
        Route::get('/exclusive-requests', [AdminController::class, 'exclusiveRequests'])->name('exclusive-requests');
        Route::patch('/exclusive-requests/{user}/approve', [AdminController::class, 'approveExclusiveRequest'])->name('exclusive-requests.approve');
        Route::delete('/exclusive-requests/{user}/reject', [AdminController::class, 'rejectExclusiveRequest'])->name('exclusive-requests.reject');

        // --- ROTAS DE APROVAÇÃO DE IMÓVEIS (FALTAVAM AQUI) ---
        Route::get('/properties/pending', [AdminController::class, 'pendingProperties'])->name('properties.pending');
        Route::patch('/properties/{property}/approve-listing', [AdminController::class, 'approveProperty'])->name('properties.approve-listing');
        Route::patch('/properties/{property}/reject-listing', [AdminController::class, 'rejectProperty'])->name('properties.reject-listing');
        // -----------------------------------------------------

        Route::patch('/users/{user}/toggle-status', [AdminController::class, 'toggleUserStatus'])->name('users.toggle-status');
        Route::patch('/users/{user}/reset-password', [AdminController::class, 'resetUserPassword'])->name('users.reset-password');
        Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');

        Route::get('/properties', [AdminController::class, 'properties'])->name('properties');
        Route::delete('/properties/{property}', [AdminController::class, 'deleteProperty'])->name('properties.destroy');
    });
});

Route::get('/properties/{property}', [PropertyController::class, 'show'])->name('properties.show');

require __DIR__.'/auth.php';