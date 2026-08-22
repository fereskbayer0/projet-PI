@extends('layouts.app')

@section('title', 'Statistiques - WellBot')

@section('content')
@php
    $total = array_sum($distribution);
    arsort($distribution);
    $dominante = $total ? array_key_first($distribution) : null;
    $moyenne = count($scores) ? round(array_sum($scores) / count($scores), 1) : 0;
@endphp

<div class="wb-pagehead wb-reveal">
    <div class="wb-pagehead-row">
        <div>
            <span class="wb-eyebrow"><x-icon name="chart" /> Vos tendances</span>
            <h1 style="font-size: clamp(1.7rem, 1.3rem + 1.4vw, 2.3rem)">Statistiques émotionnelles</h1>
            <p>Ce que vos notes racontent, mises bout à bout.</p>
        </div>
        <a href="{{ route('moods.index') }}" class="btn btn-soft">
            <x-icon name="plus" /> Ajouter une note
        </a>
    </div>
</div>

@if(!$total)
    <div class="wb-card wb-reveal">
        <x-empty-state icon="pie" title="Pas encore assez de données">
            Vos graphiques se construisent à partir de vos enregistrements d'humeur.
            Notez-en quelques-uns et revenez voir.
            <x-slot:action>
                <a href="{{ route('moods.index') }}" class="btn btn-primary">
                    <x-icon name="smile" /> Noter ma première humeur
                </a>
            </x-slot:action>
        </x-empty-state>
    </div>
@else

{{-- ------------------------------------------------------ Chiffres clés --}}
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="wb-card wb-stat wb-card-hover wb-reveal">
            <div class="d-flex align-items-start justify-content-between">
                <p class="wb-stat-label">Humeur dominante</p>
                <span class="wb-plate" style="width:36px;height:36px;border-radius:12px">
                    <x-icon name="star" style="width:18px;height:18px" />
                </span>
            </div>
            <x-mood-chip :mood="$dominante" size="lg" />
            <p class="wb-stat-foot">
                {{ $distribution[$dominante] }} fois sur {{ $total }}
                ({{ round($distribution[$dominante] / $total * 100) }} %)
            </p>
        </div>
    </div>

    <div class="col-md-4">
        <div class="wb-card wb-stat wb-card-hover wb-reveal">
            <div class="d-flex align-items-start justify-content-between">
                <p class="wb-stat-label">Intensité moyenne</p>
                <span class="wb-plate wb-plate-sun" style="width:36px;height:36px;border-radius:12px">
                    <x-icon name="trending" style="width:18px;height:18px" />
                </span>
            </div>
            <p class="wb-stat-value">{{ $moyenne }}<span class="wb-stat-unit">/ 5</span></p>
            <div class="wb-meter" aria-hidden="true"><span style="width: {{ min(100, $moyenne / 5 * 100) }}%"></span></div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="wb-card wb-stat wb-card-hover wb-reveal">
            <div class="d-flex align-items-start justify-content-between">
                <p class="wb-stat-label">Humeurs différentes</p>
                <span class="wb-plate wb-plate-lilac" style="width:36px;height:36px;border-radius:12px">
                    <x-icon name="pie" style="width:18px;height:18px" />
                </span>
            </div>
            <p class="wb-stat-value">{{ count($distribution) }}<span class="wb-stat-unit">sur 5</span></p>
            <p class="wb-stat-foot">{{ $total }} enregistrement{{ $total > 1 ? 's' : '' }} au total.</p>
        </div>
    </div>
</div>

{{-- --------------------------------------------------------- Graphiques --}}
<div class="row g-4">
    <div class="col-lg-5">
        <div class="wb-card h-100 wb-reveal">
            <h5 class="wb-section-title"><x-icon name="pie" /> Répartition des humeurs</h5>
            <div class="wb-chart"><canvas id="moodDistribution"></canvas></div>

            <div class="wb-legend">
                @foreach($distribution as $label => $count)
                    @php $token = config('moods.list.' . $label . '.token'); @endphp
                    <span>
                        <i style="background: {{ $token ? 'var(--wb-mood-' . $token . ')' : 'var(--wb-brand-500)' }}"></i>
                        {{ $label }} · {{ $count }}
                    </span>
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="wb-card h-100 wb-reveal">
            <h5 class="wb-section-title"><x-icon name="trending" /> Évolution de l'intensité</h5>
            <p class="mb-3" style="font-size:.85rem">Chaque point correspond à un enregistrement, du plus ancien au plus récent.</p>
            <div class="wb-chart wb-chart-wide"><canvas id="moodEvolution"></canvas></div>
        </div>
    </div>
</div>

@endif
@endsection

@push('scripts')
@if($total)
<script>
    (function () {
        var distLabels = @json(array_keys($distribution));
        var distData   = @json(array_values($distribution));
        var lineLabels = @json($labels);
        var lineScores = @json($scores);
        var brand = '#199c88';

        new Chart(document.getElementById('moodDistribution'), {
            type: 'doughnut',
            data: {
                labels: distLabels,
                datasets: [{
                    data: distData,
                    backgroundColor: WellBot.moodColors(distLabels),
                    borderColor: WellBot.surface(),
                    borderWidth: 3,
                    hoverOffset: 10
                }]
            },
            options: {
                cutout: '64%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function (item) {
                                var total = item.dataset.data.reduce(function (a, b) { return a + b; }, 0);
                                return item.label + ' : ' + item.parsed + ' (' + Math.round(item.parsed / total * 100) + ' %)';
                            }
                        }
                    }
                }
            }
        });

        new Chart(document.getElementById('moodEvolution'), {
            type: 'line',
            data: {
                labels: lineLabels,
                datasets: [{
                    label: 'Intensité',
                    data: lineScores,
                    borderColor: brand,
                    borderWidth: 2.5,
                    pointBackgroundColor: WellBot.surface(),
                    pointBorderColor: brand,
                    pointBorderWidth: 2,
                    pointRadius: 3.5,
                    pointHoverRadius: 6,
                    tension: .35,
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
                        max: 5,
                        ticks: { stepSize: 1, color: WellBot.ink() },
                        grid: { color: WellBot.grid(), drawTicks: false },
                        border: { display: false }
                    },
                    x: {
                        ticks: { color: WellBot.ink(), maxRotation: 0, autoSkipPadding: 16 },
                        grid: { display: false },
                        border: { display: false }
                    }
                }
            }
        });
    })();
</script>
@endif
@endpush
