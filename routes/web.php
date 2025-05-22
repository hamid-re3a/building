<?php

use App\Http\Controllers\BuildingController;
use App\Http\Controllers\CommandController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [BuildingController::class, 'index']);
Route::get('/command', [CommandController::class, 'runCommand'])->name('command.page');
Route::post('/command', [CommandController::class, 'runCommand'])->name('command.run');
Route::post('/wallet/deposit', [BuildingController::class, 'deposit'])->name('wallet.deposit')->middleware('auth');
Route::post('/create/invoice', [BuildingController::class, 'invoice'])->name('create.invoice')->middleware('auth');
//
//
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
