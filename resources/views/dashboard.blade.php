@extends('layouts.app')

@section('title', 'Tableau de bord - WellBot')

@section('content')
@php
    $heure = now()->hour;
    $salutation = $heure < 12 ? 'Bonjour' : ($heure < 18 ? 'Bon après-midi' : 'Bonsoir');
    $prenom = Str::before($user->name, ' ');
@endphp

{{-- ------------------------------------------------------------- Accueil --}}
<section class="wb-card wb-card-accent wb-reveal mb-4" style="padding: 1.75rem">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div class="d-flex align-items-center gap-3">
            <span class="wb-avatar wb-avatar-lg">{{ Str::upper(Str::substr($user->name, 0, 1)) }}</span>
            <div>
                <span class="wb-eyebrow"><x-icon name="calendar" /> {{ now()->translatedFormat('l j F') }}</span>
                <h2 class="mt-2 mb-1">{{ $salutation }}, {{ $prenom }}.</h2>
                <p class="mb-0">
                    @if($latestMood)
                        Dernière note {{ $latestMood->created_at->diffForHumans() }}. Comment ça va maintenant ?
                    @else
                        Prenez trente secondes pour poser un mot sur votre journée.
                    @endif
                </p>
            </div>
        </div>

        <a href="{{ route('moods.index') }}" class="btn btn-primary btn-lg">
            <x-icon name="plus" /> Noter mon humeur
        </a>
    </div>
</section>

{{-- ---------------------------------------------------------- Indicateurs --}}
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="wb-card wb-stat wb-card-hover wb-reveal">
            <div class="d-flex align-items-start justify-content-between">
                <p class="wb-stat-label">Dernière humeur</p>
                <span class="wb-plate" style="width:36px;height:36px;border-radius:12px">
                    <x-icon name="smile" style="width:18px;height:18px" />
                </span>
            </div>
            @if($latestMood)
                <x-mood-chip :mood="$latestMood->mood" size="lg" />
                <p class="wb-stat-foot d-flex align-items-center gap-2">
                    <x-intensity-dots :value="$latestMood->intensity" :mood="$latestMood->mood" />
                    intensité {{ $latestMood->intensity }}/5
                </p>
            @else
                <p class="wb-stat-value">—</p>
                <p class="wb-stat-foot">Aucun enregistrement pour l'instant.</p>
            @endif
        </div>
    </div>

    <div class="col-md-4">
        <div class="wb-card wb-stat wb-card-hover wb-reveal">
            <div class="d-flex align-items-start justify-content-between">
                <p class="wb-stat-label">Humeurs notées</p>
                <span class="wb-plate wb-plate-lilac" style="width:36px;height:36px;border-radius:12px">
                    <x-icon name="book" style="width:18px;height:18px" />
                </span>
            </div>
            <p class="wb-stat-value">{{ $moodCount }}<span class="wb-stat-unit">au total</span></p>
            <p class="wb-stat-foot">{{ $joursSuivis }} jour{{ $joursSuivis > 1 ? 's' : '' }} suivi{{ $joursSuivis > 1 ? 's' : '' }} sur les 14 derniers.</p>
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
            <p class="wb-stat-value">{{ $moodCount ? $averageIntensity : '—' }}<span class="wb-stat-unit">/ 5</span></p>
            <div class="wb-meter" aria-hidden="true">
                <span style="width: {{ $moodCount ? min(100, ($averageIntensity / 5) * 100) : 0 }}%"></span>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    {{-- ------------------------------------------------------- Tendance --}}
    <div class="col-lg-7">
        <div class="wb-card h-100 wb-reveal">
            <div class="d-flex align-items-start justify-content-between flex-wrap gap-2 mb-1">
                <h5 class="wb-section-title mb-0"><x-icon name="trending" /> Vos 14 derniers jours</h5>
                <a href="{{ route('stats') }}" class="wb-resource-link">
                    Tout voir <x-icon name="arrow-right" />
                </a>
            </div>
            <p class="mb-3" style="font-size:.85rem">Intensité moyenne notée chaque jour.</p>

            @if($moodCount)
                <div class="wb-chart wb-chart-sm">
                    <canvas id="wbTrend"
                            data-labels='@json($trendLabels)'
                            data-scores='@json($trendScores)'></canvas>
                </div>
            @else
                <x-empty-state icon="chart" title="Votre courbe apparaîtra ici">
                    Notez au moins deux humeurs pour voir votre évolution se dessiner.
                </x-empty-state>
            @endif
        </div>
    </div>

    {{-- --------------------------------------------------------- Journal --}}
    <div class="col-lg-5">
        <div class="wb-card h-100 wb-reveal">
            <h5 class="wb-section-title"><x-icon name="clock" /> Dernières notes</h5>

            @forelse($recentMoods as $entry)
                <div class="d-flex align-items-center justify-content-between gap-2 py-2
                            {{ $loop->first ? '' : 'border-top' }}" style="border-color: var(--wb-line) !important">
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <x-mood-chip :mood="$entry->mood" />
                        <x-intensity-dots :value="$entry->intensity" :mood="$entry->mood" />
                    </div>
                    <span class="text-muted" style="font-size:.76rem; white-space:nowrap">
                        {{ $entry->created_at->format('d/m H:i') }}
                    </span>
                </div>
            @empty
                <x-empty-state icon="smile" title="Rien de noté pour l'instant">
                    Votre premier enregistrement prend moins d'une minute.
                    <x-slot:action>
                        <a href="{{ route('moods.index') }}" class="btn btn-primary btn-sm">
                            <x-icon name="plus" /> Commencer
                        </a>
                    </x-slot:action>
                </x-empty-state>
            @endforelse
        </div>
    </div>

    {{-- --------------------------------------------------- Accès rapides --}}
    <div class="col-12">
        <div class="row g-3">
            @php
                $shortcuts = [
                    ['route' => route('moods.index'),     'icon' => 'smile',   'plate' => '',              'title' => 'Suivi d\'humeur',  'text' => 'Noter et relire'],
                    ['route' => '#chatbot',               'icon' => 'message', 'plate' => 'wb-plate-sun',  'title' => 'Parler à WellBot', 'text' => 'Disponible 24/7'],
                    ['route' => route('resources.index'), 'icon' => 'book',    'plate' => 'wb-plate-lilac','title' => 'Ressources',       'text' => 'Conseils et liens'],
                    ['route' => route('stats'),           'icon' => 'chart',   'plate' => 'wb-plate-sky',  'title' => 'Statistiques',     'text' => 'Vos tendances'],
                ];
            @endphp

            @foreach($shortcuts as $shortcut)
                <div class="col-sm-6 col-lg-3">
                    <a class="wb-card wb-card-hover wb-card-pad-sm d-flex align-items-center gap-3 h-100 text-decoration-none wb-reveal"
                       href="{{ $shortcut['route'] === '#chatbot' ? '#' : $shortcut['route'] }}"
                       @if($shortcut['route'] === '#chatbot') data-chatbot-trigger @endif>
                        <span class="wb-plate {{ $shortcut['plate'] }}"><x-icon :name="$shortcut['icon']" /></span>
                        <span>
                            <span class="d-block fw-bold" style="color: var(--wb-ink); font-size:.92rem">{{ $shortcut['title'] }}</span>
                            <span class="d-block text-muted" style="font-size:.78rem">{{ $shortcut['text'] }}</span>
                        </span>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@push('scripts')
@if($moodCount)
<script>
    (function () {
        var canvas = document.getElementById('wbTrend');
        if (!canvas) return;

        var labels = JSON.parse(canvas.dataset.labels);
        var scores = JSON.parse(canvas.dataset.scores);
        var brand = '#199c88';

        new Chart(canvas, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Intensité moyenne',
                    data: scores,
                    borderColor: brand,
                    borderWidth: 2.5,
                    pointBackgroundColor: WellBot.surface(),
                    pointBorderColor: brand,
                    pointBorderWidth: 2,
                    pointRadius: 3.5,
                    pointHoverRadius: 6,
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
                        max: 5,
                        ticks: { stepSize: 1, color: WellBot.ink() },
                        grid: { color: WellBot.grid(), drawTicks: false },
                        border: { display: false }
                    },
                    x: {
                        ticks: { color: WellBot.ink(), maxRotation: 0, autoSkipPadding: 14 },
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
