@extends('layouts.app')

@section('title', 'WellBot - Respirez, notez, avancez')

@section('content')

{{-- ---------------------------------------------------------------- Héros --}}
<section class="wb-hero">
    <div class="wb-hero-grid">
        <div class="wb-reveal">
            <span class="wb-eyebrow"><x-icon name="leaf" /> Bien-être étudiant</span>

            <h1>Respirez. Notez ce que vous ressentez. <em>Avancez plus léger.</em></h1>

            <p class="lead">
                WellBot est un espace calme pour observer vos émotions au quotidien,
                parler à un assistant bienveillant et trouver les ressources qui vous
                aident vraiment — sans jugement, à votre rythme.
            </p>

            <div class="wb-hero-actions">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg">
                        <x-icon name="grid" /> Mon tableau de bord
                    </a>
                    <a href="{{ route('moods.index') }}" class="btn btn-ghost btn-lg">
                        <x-icon name="smile" /> Noter mon humeur
                    </a>
                @else
                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
                        <x-icon name="sparkles" /> Créer mon espace
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-ghost btn-lg">
                        <x-icon name="login" /> J'ai déjà un compte
                    </a>
                @endauth
            </div>

            <div class="wb-hero-proof">
                <div>
                    <strong>30 s</strong>
                    <span>pour noter une humeur</span>
                </div>
                <div>
                    <strong>24/7</strong>
                    <span>WellBot vous répond</span>
                </div>
                <div>
                    <strong>100 %</strong>
                    <span>privé, rien n'est partagé</span>
                </div>
            </div>
        </div>

        {{-- Cercle de respiration : le visuel donne déjà envie de ralentir --}}
        <div class="wb-breath-stage wb-reveal">
            <div class="wb-breath">
                <div>
                    <div class="wb-breath-label">Inspirez… expirez</div>
                    <div class="wb-breath-sub">4 s · 4 s</div>
                </div>
            </div>

            <div class="wb-float wb-float-a">
                <x-mood-chip mood="Heureux" />
                <span class="wb-float-sub">Aujourd'hui</span>
            </div>
            <div class="wb-float wb-float-b">
                <span class="wb-plate wb-plate-sun" style="width:34px;height:34px;border-radius:11px">
                    <x-icon name="trending" style="width:17px;height:17px" />
                </span>
                <div>
                    +18 %
                    <span class="wb-float-sub">cette semaine</span>
                </div>
            </div>
            <div class="wb-float wb-float-c">
                <span class="wb-plate" style="width:34px;height:34px;border-radius:11px">
                    <x-icon name="message" style="width:17px;height:17px" />
                </span>
                <div>
                    WellBot
                    <span class="wb-float-sub">« Je vous écoute. »</span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ------------------------------------------------------------ Fonctions --}}
<section class="mt-5 pt-4">
    <div class="wb-pagehead text-center wb-reveal">
        <span class="wb-eyebrow"><x-icon name="sparkles" /> Ce que vous trouverez ici</span>
        <h2 class="mt-3">Quatre outils simples, un seul objectif</h2>
        <p class="mx-auto">Rien de compliqué : des gestes courts, répétés, qui finissent par changer beaucoup.</p>
    </div>

    <div class="row g-4">
        @php
            $features = [
                ['icon' => 'smile',    'plate' => '',              'title' => 'Suivi d\'humeur',  'text' => 'Un emoji, une intensité, deux mots. Trente secondes suffisent pour garder une trace honnête de vos journées.'],
                ['icon' => 'message',  'plate' => 'wb-plate-sun',  'title' => 'WellBot, l\'assistant', 'text' => 'Un compagnon disponible à toute heure, qui écoute sans juger et propose des pistes concrètes pour souffler.'],
                ['icon' => 'book',     'plate' => 'wb-plate-lilac','title' => 'Ressources choisies', 'text' => 'Sommeil, révisions, anxiété, organisation : des conseils courts et des liens utiles, triés par thème.'],
                ['icon' => 'chart',    'plate' => 'wb-plate-sky',  'title' => 'Vos tendances',    'text' => 'Des graphiques clairs qui révèlent les cycles invisibles de votre semestre — et vos progrès.'],
            ];
        @endphp

        @foreach($features as $feature)
            <div class="col-sm-6 col-lg-3">
                <div class="wb-card wb-card-hover h-100 wb-reveal">
                    <span class="wb-plate wb-plate-lg {{ $feature['plate'] }}"><x-icon :name="$feature['icon']" /></span>
                    <h5 class="mt-3 mb-2">{{ $feature['title'] }}</h5>
                    <p class="mb-0" style="font-size:.885rem">{{ $feature['text'] }}</p>
                </div>
            </div>
        @endforeach
    </div>
</section>

{{-- --------------------------------------------------------- Comment faire --}}
<section class="mt-5 pt-5">
    <div class="row g-5 align-items-center">
        <div class="col-lg-5 wb-reveal">
            <span class="wb-eyebrow"><x-icon name="wind" /> En pratique</span>
            <h2 class="mt-3">Une routine de trois minutes</h2>
            <p>
                Pas de programme à suivre, pas de badge à gagner. Juste un rendez-vous
                court avec vous-même, aussi souvent que vous en avez besoin.
            </p>
            @guest
                <a href="{{ route('register') }}" class="btn btn-primary mt-2">
                    Commencer maintenant <x-icon name="arrow-right" />
                </a>
            @endguest
        </div>

        <div class="col-lg-7">
            <div class="wb-card wb-card-accent wb-reveal">
                @php
                    $steps = [
                        ['Notez votre humeur', 'Choisissez l\'emoji qui colle le mieux, réglez l\'intensité et ajoutez une note si le cœur vous en dit.'],
                        ['Parlez-en à WellBot', 'Décrivez ce qui pèse. WellBot répond avec bienveillance et vous propose une piste réaliste.'],
                        ['Observez vos courbes', 'Au bout de quelques jours, vos graphiques racontent une histoire que la mémoire seule oublie.'],
                    ];
                @endphp

                @foreach($steps as $index => $step)
                    <div class="wb-step {{ $index ? 'mt-4' : '' }}">
                        <span class="wb-step-num">{{ $index + 1 }}</span>
                        <div>
                            <h5>{{ $step[0] }}</h5>
                            <p>{{ $step[1] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ----------------------------------------------------------- Respiration --}}
<section class="mt-5 pt-5">
    <div class="wb-quote wb-reveal">
        <p>« Vous n'avez pas à aller bien tous les jours. Vous avez seulement à ne pas rester seul avec ce qui pèse. »</p>
        <cite>Rappel du jour</cite>
    </div>
</section>

{{-- ------------------------------------------------------------ Appel final --}}
@guest
<section class="mt-5 pt-4">
    <div class="wb-card wb-card-hover text-center wb-reveal" style="padding: 3rem 1.5rem">
        <span class="wb-plate wb-plate-lg mx-auto"><x-icon name="heart-pulse" /></span>
        <h2 class="mt-3 mb-2">Votre espace vous attend</h2>
        <p class="mx-auto mb-4" style="max-width: 48ch">
            Création de compte en quelques secondes. Vos humeurs et vos conversations
            restent visibles par vous seul.
        </p>
        <div class="d-flex flex-wrap justify-content-center gap-2">
            <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
                <x-icon name="user-plus" /> Créer mon compte
            </a>
            <a href="{{ route('login') }}" class="btn btn-ghost btn-lg">Se connecter</a>
        </div>
    </div>
</section>
@endguest

@endsection
