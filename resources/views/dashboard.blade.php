@extends('layouts.app')

@section('title', 'Tableau de bord - Bien-être Étudiant')

@section('content')
<div class="row gy-4">
    <div class="col-12">
        <div class="card feature-card p-4">
            <h2>Bonjour, {{ $user->name }} !</h2>
            <p class="text-muted">Bienvenue sur votre espace de bien-être étudiant.</p>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card feature-card p-4">
            <h5>Dernière humeur</h5>
            <p class="mb-1">{{ $latestMood ? $latestMood->mood : 'Aucune humeur enregistrée' }}</p>
            <p class="text-muted">Intensité : {{ $latestMood ? $latestMood->intensity : '-' }}</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card feature-card p-4">
            <h5>Total des humeurs</h5>
            <p class="display-6 mb-0">{{ $moodCount }}</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card feature-card p-4">
            <h5>Intensité moyenne</h5>
            <p class="display-6 mb-0">{{ $moodCount ? $averageIntensity : '-' }}</p>
        </div>
    </div>

    <div class="col-12">
        <div class="card feature-card p-4">
            <h5>Accès rapide</h5>
            <div class="row g-3">
                <div class="col-sm-4"><a href="{{ route('moods.index') }}" class="btn btn-primary w-100">Suivi d’humeur</a></div>
                <div class="col-sm-4"><a href="{{ route('chatbot.index') }}" class="btn btn-primary w-100">Chatbot</a></div>
                <div class="col-sm-4"><a href="{{ route('stats') }}" class="btn btn-primary w-100">Statistiques</a></div>
            </div>
        </div>
    </div>
</div>
@endsection
