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
| Routes de WellBot
|--------------------------------------------------------------------------
| Trois niveaux d'acces, du plus ouvert au plus restreint :
|
|   public          -> accueil, connexion, inscription
|   middleware auth -> humeurs, chatbot, ressources, statistiques
|   middleware admin-> gestion des utilisateurs, des ressources, des mots-cles
|
| Le middleware "admin" est defini dans App\Http\Middleware\EnsureUserIsAdmin.
*/

// --- Public -----------------------------------------------------------------

Route::view('/', 'home')->name('home');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// --- Etudiant connecte -------------------------------------------------------

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/stats', [DashboardController::class, 'stats'])->name('stats');

    // Suivi de l'humeur : chaque etudiant ne voit et ne modifie que ses entrees
    Route::get('/moods', [MoodController::class, 'index'])->name('moods.index');
    Route::post('/moods', [MoodController::class, 'store'])->name('moods.store');
    Route::get('/moods/{mood}/edit', [MoodController::class, 'edit'])->name('moods.edit');
    Route::put('/moods/{mood}', [MoodController::class, 'update'])->name('moods.update');
    Route::delete('/moods/{mood}', [MoodController::class, 'destroy'])->name('moods.destroy');

    // Assistant WellBot (IA Gemini, sinon reponses par mots-cles)
    Route::get('/chatbot', [ChatbotController::class, 'index'])->name('chatbot.index');
    Route::post('/chatbot', [ChatbotController::class, 'send'])->name('chatbot.send');
    Route::delete('/chatbot/clear', [ChatbotController::class, 'clear'])->name('chatbot.clear');
    Route::delete('/chatbot/{chatbotMessage}', [ChatbotController::class, 'destroy'])->name('chatbot.destroy');

    // Bibliotheque de ressources : lecture ouverte a tous les comptes
    Route::get('/resources', [ResourceController::class, 'index'])->name('resources.index');


    // --- Administrateur ------------------------------------------------------

    Route::middleware('admin')->group(function () {

        // Ecriture sur les ressources
        Route::get('/resources/create', [ResourceController::class, 'create'])->name('resources.create');
        Route::post('/resources', [ResourceController::class, 'store'])->name('resources.store');
        Route::get('/resources/{resource}/edit', [ResourceController::class, 'edit'])->name('resources.edit');
        Route::put('/resources/{resource}', [ResourceController::class, 'update'])->name('resources.update');
        Route::delete('/resources/{resource}', [ResourceController::class, 'destroy'])->name('resources.destroy');

        Route::prefix('admin')->name('admin.')->group(function () {
            Route::get('/', [AdminController::class, 'index'])->name('index');

            Route::get('/users', [AdminController::class, 'users'])->name('users');
            Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');
            Route::post('/users/{user}/promote', [AdminController::class, 'promote'])->name('users.promote');

            // Reponses de secours du chatbot quand l'IA est indisponible
            Route::get('/keywords', [AdminController::class, 'keywords'])->name('keywords');
            Route::post('/keywords', [AdminController::class, 'storeKeyword'])->name('keywords.store');
            Route::delete('/keywords/{keyword}', [AdminController::class, 'destroyKeyword'])->name('keywords.destroy');
        });
    });
});
