@extends('layouts.app')

@section('title', 'Espace administrateur - WellBot')

@section('content')
<div class="wb-pagehead wb-reveal">
    <div class="wb-pagehead-row">
        <div>
            <span class="wb-eyebrow"><x-icon name="shield" /> Administration</span>
            <h1 style="font-size: clamp(1.7rem, 1.3rem + 1.4vw, 2.3rem)">Vue d'ensemble</h1>
            <p>Bonjour {{ Str::before(Auth::user()->name, ' ') }}, voici l'état de la plateforme aujourd'hui.</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('admin.users') }}" class="btn btn-primary"><x-icon name="users" /> Utilisateurs</a>
            <a href="{{ route('admin.keywords') }}" class="btn btn-soft"><x-icon name="key" /> Mots-clés</a>
        </div>
    </div>
</div>

{{-- ------------------------------------------------------ Chiffres clés --}}
@php
    $tiles = [
        ['label' => 'Utilisateurs',        'value' => $nbUtilisateurs,     'icon' => 'users',    'plate' => '',               'foot' => 'Comptes inscrits'],
        ['label' => 'Humeurs',             'value' => $nbHumeurs,          'icon' => 'smile',    'plate' => 'wb-plate-sun',   'foot' => 'Enregistrements cumulés'],
        ['label' => 'Ressources',          'value' => $nbRessources,       'icon' => 'book',     'plate' => 'wb-plate-lilac', 'foot' => 'Publiées dans la bibliothèque'],
        ['label' => 'Messages chatbot',    'value' => $nbMessagesChatbot,  'icon' => 'message',  'plate' => 'wb-plate-sky',   'foot' => 'Échanges avec WellBot'],
    ];
@endphp

<div class="row g-4 mb-4">
    @foreach($tiles as $tile)
        <div class="col-sm-6 col-xl-3">
            <div class="wb-card wb-stat wb-card-hover wb-reveal">
                <div class="d-flex align-items-start justify-content-between">
                    <p class="wb-stat-label">{{ $tile['label'] }}</p>
                    <span class="wb-plate {{ $tile['plate'] }}" style="width:36px;height:36px;border-radius:12px">
                        <x-icon :name="$tile['icon']" style="width:18px;height:18px" />
                    </span>
                </div>
                <p class="wb-stat-value">{{ $tile['value'] }}</p>
                <p class="wb-stat-foot">{{ $tile['foot'] }}</p>
            </div>
        </div>
    @endforeach
</div>

<div class="row g-4">
    {{-- ------------------------------------------------ Tendance globale --}}
    <div class="col-lg-8">
        <div class="wb-card h-100 wb-reveal">
            <h5 class="wb-section-title"><x-icon name="trending" /> Tendance globale — 7 derniers jours</h5>
            <p class="mb-3" style="font-size:.85rem">
                Intensité moyenne de l'humeur, tous étudiants confondus. Une chute
                prolongée peut signaler une période de tension collective (examens, rentrée…).
            </p>
            <div class="wb-chart wb-chart-sm"><canvas id="globalMoodChart"></canvas></div>
        </div>
    </div>

    {{-- --------------------------------------------------- Actions rapides --}}
    <div class="col-lg-4">
        <div class="wb-card h-100 wb-reveal">
            <h5 class="wb-section-title"><x-icon name="grid" /> Actions rapides</h5>

            @php
                $actions = [
                    ['route' => route('admin.users'),     'icon' => 'users', 'plate' => '',               'title' => 'Gérer les utilisateurs', 'text' => 'Promouvoir ou supprimer un compte'],
                    ['route' => route('resources.index'), 'icon' => 'book',  'plate' => 'wb-plate-lilac', 'title' => 'Gérer les ressources',   'text' => 'Ajouter, corriger, retirer'],
                    ['route' => route('admin.keywords'),  'icon' => 'key',   'plate' => 'wb-plate-sun',   'title' => 'Mots-clés du chatbot',   'text' => 'Réponses de secours sans IA'],
                ];
            @endphp

            <div class="d-flex flex-column gap-2">
                @foreach($actions as $action)
                    <a href="{{ $action['route'] }}"
                       class="wb-card wb-card-hover wb-card-pad-sm d-flex align-items-center gap-3 text-decoration-none">
                        <span class="wb-plate {{ $action['plate'] }}"><x-icon :name="$action['icon']" /></span>
                        <span class="flex-grow-1">
                            <span class="d-block fw-bold" style="color: var(--wb-ink); font-size:.9rem">{{ $action['title'] }}</span>
                            <span class="d-block text-muted" style="font-size:.76rem">{{ $action['text'] }}</span>
                        </span>
                        <x-icon name="arrow-right" style="width:16px;height:16px;color:var(--wb-ink-faint)" />
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    (function () {
        var canvas = document.getElementById('globalMoodChart');
        if (!canvas) return;

        var brand = '#199c88';

        new Chart(canvas, {
            type: 'line',
            data: {
                labels: @json($chartLabels),
                datasets: [{
                    label: 'Humeur moyenne',
                    data: @json($chartScores),
                    borderColor: brand,
                    borderWidth: 2.5,
                    pointBackgroundColor: WellBot.surface(),
                    pointBorderColor: brand,
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6.5,
                    tension: .38,
                    spanGaps: true,
                    fill: true,
                    backgroundColor: function (ctx) { return WellBot.fade(ctx.chart, brand); }
                }]
            },
            options: {
                plugins: { legend: { display: false } },
                interaction: { intersect: false, mode: 'index' },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { color: WellBot.ink() },
                        grid: { color: WellBot.grid(), drawTicks: false },
                        border: { display: false }
                    },
                    x: {
                        ticks: { color: WellBot.ink(), maxRotation: 0 },
                        grid: { display: false },
                        border: { display: false }
                    }
                }
            }
        });
    })();
</script>
@endpush
