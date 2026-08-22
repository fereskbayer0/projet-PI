<?php

namespace App\Providers;

use App\Models\ChatbotMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /*
         * La bulle WellBot est presente sur toutes les pages : elle a donc
         * besoin des derniers echanges partout. Plutot que de repeter cette
         * requete dans chaque controleur, on l'attache une fois au layout.
         */
        view()->composer('layouts.app', function ($view) {
            $view->with('chatbotMessages', Auth::check()
                ? ChatbotMessage::where('user_id', Auth::id())->latest()->take(6)->get()->reverse()
                : collect());
        });
    }
}
