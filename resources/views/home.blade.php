@extends('layouts.app')

@section('title', 'Accueil - Bien-être Étudiant')

@section('content')
<div class="row align-items-center hero">
    <div class="col-lg-6">
        <h1 class="display-6 page-title">Plateforme Web de Bien-être Étudiant</h1>
        <p class="lead text-muted">Un site simple pour suivre votre humeur, obtenir des ressources de bien-être et discuter avec un assistant personnel.</p>
        <div class="mt-4">
            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg me-2">Voir le tableau</a>
                <a href="{{ route('resources.index') }}" class="btn btn-outline-secondary btn-lg">Ressources</a>
            @else
                <a href="{{ route('register') }}" class="btn btn-primary btn-lg me-2">S’inscrire</a>
                <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-lg">Connexion</a>
            @endauth
        </div>
    </div>
    <div class="col-lg-5 offset-lg-1">
        <div class="card feature-card p-4">
            <h4 class="mb-3">Fonctionnalités</h4>
            <ul class="list-unstyled fw-medium">
                <li class="mb-2">Suivi simple de l’humeur</li>
                <li class="mb-2">Chatbot de soutien par mot-clé</li>
                <li class="mb-2">Ressources de gestion du stress</li>
                <li>Graphiques d’évolution émotionnelle</li>
            </ul>
        </div>
    </div>
</div>

<div class="row mt-5 gy-4">
    <div class="col-md-4">
        <div class="card feature-card p-4 h-100">
            <h5>Suivi d’humeur</h5>
            <p class="text-muted">Enregistrez votre humeur, votre intensité et vos notes chaque jour.</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card feature-card p-4 h-100">
            <h5>Chatbot de soutien</h5>
            <p class="text-muted">Posez une question et obtenez une réponse basée sur des mots-clés.</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card feature-card p-4 h-100">
            <h5>Statistiques</h5>
            <p class="text-muted">Visualisez l’évolution de votre humeur avec des graphiques simples.</p>
        </div>
    </div>
</div>
@endsection
