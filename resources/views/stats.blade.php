@extends('layouts.app')

@section('title', 'Statistiques - Bien-être Étudiant')

@section('content')
<div class="row gy-4">
    <div class="col-12">
        <div class="card feature-card p-4">
            <h2>Statistiques émotionnelles</h2>
            <p class="text-muted">Visualisez la répartition de vos humeurs et l’évolution de votre intensité.</p>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card feature-card p-4">
            <h5>Distribution des humeurs</h5>
            <canvas id="moodDistribution"></canvas>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card feature-card p-4">
            <h5>Évolution de l’intensité</h5>
            <canvas id="moodEvolution"></canvas>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const distributionLabels = {!! json_encode(array_keys($distribution)) !!};
    const distributionData = {!! json_encode(array_values($distribution)) !!};
    const lineLabels = {!! json_encode($labels) !!};
    const lineScores = {!! json_encode($scores) !!};

    new Chart(document.getElementById('moodDistribution'), {
        type: 'doughnut',
        data: {
            labels: distributionLabels,
            datasets: [{
                data: distributionData,
                backgroundColor: ['#4d8cff', '#7dd3fc', '#a5b4fc', '#fbbf24', '#f87171'],
            }]
        },
    });

    new Chart(document.getElementById('moodEvolution'), {
        type: 'line',
        data: {
            labels: lineLabels,
            datasets: [{
                label: 'Intensité de l’humeur',
                data: lineScores,
                borderColor: '#4d8cff',
                backgroundColor: 'rgba(77, 140, 255, 0.15)',
                tension: 0.3,
                fill: true,
            }]
        },
        options: {
            scales: {
                y: { beginAtZero: true, suggestedMax: 5 }
            }
        }
    });
</script>
@endpush
