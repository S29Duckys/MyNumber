<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PartieController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home.home');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/parties', [PartieController::class, 'createPartie'])->name('parties.create');
    Route::get('/parties/{token}', [PartieController::class, 'showPartie'])->name('game.afficher');
    Route::post('/parties/{token}/rejoindre', [PartieController::class, 'rejoindrePartie'])->name('parties.rejoindre');
    Route::post('/parties/{token}/combinaison', [PartieController::class, 'soumettreCombinaison'])->name('parties.combinaison');
    Route::post('/parties/{token}/proposer', [PartieController::class, 'soumettreProposition'])->name('parties.proposer');
});

require __DIR__.'/auth.php';
