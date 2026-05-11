@extends('layouts.app')

@section('title', 'Espace Administrateur')

@section('content')
<div class="row gy-4">
    <div class="col-12">
        <div class="card feature-card p-4">
            <h2>Espace Administrateur</h2>
            <p class="text-muted">Bonjour {{ Auth::user()->name }}, voici un apercu de la plateforme.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="col-12"><div class="alert alert-success">{{ session('success') }}</div></div>
    @endif

    <div class="col-md-3">
        <div class="card feature-card p-4 text-center">
            <h3 class="text-primary">{{ $nbUtilisateurs }}</h3>
            <p class="text-muted mb-0">Utilisateurs</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card feature-card p-4 text-center">
            <h3 class="text-primary">{{ $nbHumeurs }}</h3>
            <p class="text-muted mb-0">Humeurs enregistrees</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card feature-card p-4 text-center">
            <h3 class="text-primary">{{ $nbRessources }}</h3>
            <p class="text-muted mb-0">Ressources</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card feature-card p-4 text-center">
            <h3 class="text-primary">{{ $nbMessagesChatbot }}</h3>
            <p class="text-muted mb-0">Messages chatbot</p>
        </div>
    </div>

    <div class="col-12 mt-3">
        <div class="card feature-card p-4">
            <h5>Actions rapides</h5>
            <a href="{{ route('admin.users') }}" class="btn btn-primary me-2">Gérer les utilisateurs</a>
            <a href="{{ route('resources.index') }}" class="btn btn-outline-primary me-2">Gérer les ressources</a>
            <a href="{{ route('admin.keywords') }}" class="btn btn-outline-secondary me-2">Mots-clés Chatbot</a>
        </div>
    </div>

    <div class="col-12 mt-4">
        <div class="card feature-card p-4">
            <h5>Tendance globale de l'humeur (7 derniers jours)</h5>
            <p class="text-muted small">Moyenne de l'intensité de l'humeur de tous les étudiants.</p>
            <canvas id="globalMoodChart" height="100"></canvas>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('globalMoodChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($chartLabels) !!},
                    datasets: [{
                        label: 'Humeur moyenne',
                        data: {!! json_encode($chartScores) !!},
                        borderColor: '#4d8cff',
                        backgroundColor: 'rgba(77, 140, 255, 0.1)',
                        borderWidth: 2,
                        tension: 0.3,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 10
                        }
                    }
                }
            });
        }
    });
</script>
@endpush
