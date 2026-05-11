<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MoodController;
use App\Http\Controllers\ResourceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Routes du site Bien-etre Etudiant
|--------------------------------------------------------------------------
*/

// Page d'accueil
Route::get('/', function () {
    return view('home');
})->name('home');

// --- Authentification (accessible a tous) ---
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// --- Pages reservees aux utilisateurs connectes ---
Route::middleware('auth')->group(function () {

    // Tableau de bord et statistiques
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/stats', [DashboardController::class, 'stats'])->name('stats');

    // Suivi humeur (CRUD complet)
    Route::get('/moods', [MoodController::class, 'index'])->name('moods.index');
    Route::post('/moods', [MoodController::class, 'store'])->name('moods.store');
    Route::get('/moods/{mood}/edit', [MoodController::class, 'edit'])->name('moods.edit');
    Route::put('/moods/{mood}', [MoodController::class, 'update'])->name('moods.update');
    Route::delete('/moods/{mood}', [MoodController::class, 'destroy'])->name('moods.destroy');

    // Chatbot (IA Gemini ou mots cles)
    Route::get('/chatbot', [ChatbotController::class, 'index'])->name('chatbot.index');
    Route::post('/chatbot', [ChatbotController::class, 'send'])->name('chatbot.send');
    Route::delete('/chatbot/clear', [ChatbotController::class, 'clear'])->name('chatbot.clear');
    Route::delete('/chatbot/{chatbotMessage}', [ChatbotController::class, 'destroy'])->name('chatbot.destroy');

    // Ressources (CRUD complet)
    Route::get('/resources', [ResourceController::class, 'index'])->name('resources.index');
    Route::get('/resources/create', [ResourceController::class, 'create'])->name('resources.create');
    Route::post('/resources', [ResourceController::class, 'store'])->name('resources.store');
    Route::get('/resources/{resource}/edit', [ResourceController::class, 'edit'])->name('resources.edit');
    Route::put('/resources/{resource}', [ResourceController::class, 'update'])->name('resources.update');
    Route::delete('/resources/{resource}', [ResourceController::class, 'destroy'])->name('resources.destroy');


    // --- Espace administrateur (reserve aux comptes is_admin) ---
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');
        Route::post('/users/{user}/promote', [AdminController::class, 'promote'])->name('users.promote');

        // Mots-clés chatbot
        Route::get('/keywords', [AdminController::class, 'keywords'])->name('keywords');
        Route::post('/keywords', [AdminController::class, 'storeKeyword'])->name('keywords.store');
        Route::delete('/keywords/{keyword}', [AdminController::class, 'destroyKeyword'])->name('keywords.destroy');
    });
});
