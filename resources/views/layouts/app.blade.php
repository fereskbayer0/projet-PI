<!DOCTYPE html>
<html lang="fr" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0e7d6e">
    <meta name="description" content="WellBot : suivez votre humeur, discutez avec un assistant bienveillant et trouvez des ressources de bien-etre pensees pour la vie etudiante.">
    <title>@yield('title', 'WellBot - Bien-être Étudiant')</title>

    {{-- Le theme est applique avant le premier rendu pour eviter tout clignotement --}}
    <script>
        (function () {
            // Signale que JavaScript repond : les animations d'apparition
            // ne se declenchent que dans ce cas, sinon tout reste visible.
            document.documentElement.classList.add('wb-js');
            try {
                var saved = localStorage.getItem('wellbot-theme');
                var dark = saved ? saved === 'dark'
                    : window.matchMedia('(prefers-color-scheme: dark)').matches;
                document.documentElement.setAttribute('data-bs-theme', dark ? 'dark' : 'light');
            } catch (e) { /* mode prive : on garde le theme clair */ }
        })();
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/wellbot.css') }}?v={{ @filemtime(public_path('css/wellbot.css')) ?: 1 }}" rel="stylesheet">
    @stack('styles')
</head>
<body>
@include('partials.icons')

<a class="visually-hidden-focusable btn btn-primary m-2" href="#wb-content">Aller au contenu</a>

<header class="wb-nav" data-nav>
    <nav class="container navbar navbar-expand-lg p-0" aria-label="Navigation principale">
        <a class="wb-brand" href="{{ route('home') }}">
            <span class="wb-brand-mark"><x-icon name="heart-pulse" /></span>
            <span>
                WellBot
                <span class="wb-brand-sub">Bien-être étudiant</span>
            </span>
        </a>

        <div class="d-flex align-items-center gap-2 ms-auto d-lg-none">
            <button class="wb-theme-toggle" type="button" data-theme-toggle aria-label="Changer de thème">
                <x-icon name="sun" class="wb-icon-sun" />
                <x-icon name="moon" class="wb-icon-moon" />
            </button>
            <button class="wb-nav-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#wbNav"
                    aria-controls="wbNav" aria-expanded="false" aria-label="Ouvrir le menu">
                <x-icon name="menu" />
            </button>
        </div>

        <div class="collapse navbar-collapse" id="wbNav">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1 mb-0 wb-navmenu">
                <li class="nav-item">
                    <a class="wb-navlink @if(request()->routeIs('home')) is-active @endif"
                       href="{{ route('home') }}" @if(request()->routeIs('home')) aria-current="page" @endif>
                        <x-icon name="home" /> Accueil
                    </a>
                </li>

                @auth
                    <li class="nav-item">
                        <a class="wb-navlink @if(request()->routeIs('dashboard')) is-active @endif"
                           href="{{ route('dashboard') }}" @if(request()->routeIs('dashboard')) aria-current="page" @endif>
                            <x-icon name="grid" /> Tableau de bord
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="wb-navlink @if(request()->routeIs('moods.*')) is-active @endif"
                           href="{{ route('moods.index') }}" @if(request()->routeIs('moods.*')) aria-current="page" @endif>
                            <x-icon name="smile" /> Humeur
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="wb-navlink @if(request()->routeIs('chatbot.*')) is-active @endif"
                           href="{{ route('chatbot.index') }}" @if(request()->routeIs('chatbot.*')) aria-current="page" @endif>
                            <x-icon name="message" /> WellBot
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="wb-navlink @if(request()->routeIs('resources.*')) is-active @endif"
                           href="{{ route('resources.index') }}" @if(request()->routeIs('resources.*')) aria-current="page" @endif>
                            <x-icon name="book" /> Ressources
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="wb-navlink @if(request()->routeIs('stats')) is-active @endif"
                           href="{{ route('stats') }}" @if(request()->routeIs('stats')) aria-current="page" @endif>
                            <x-icon name="chart" /> Statistiques
                        </a>
                    </li>

                    @if(Auth::user()->estAdmin())
                        <li class="nav-item">
                            <a class="wb-navlink wb-navlink-admin @if(request()->routeIs('admin.*')) is-active @endif"
                               href="{{ route('admin.index') }}" @if(request()->routeIs('admin.*')) aria-current="page" @endif>
                                <x-icon name="shield" /> Admin
                            </a>
                        </li>
                    @endif

                    <li class="nav-item d-none d-lg-block ms-lg-2">
                        <button class="wb-theme-toggle" type="button" data-theme-toggle aria-label="Changer de thème">
                            <x-icon name="sun" class="wb-icon-sun" />
                            <x-icon name="moon" class="wb-icon-moon" />
                        </button>
                    </li>

                    <li class="nav-item ms-lg-1">
                        <div class="wb-navuser">
                            <div class="me-1">
                                <div class="wb-navuser-name">{{ Str::limit(Auth::user()->name, 16) }}</div>
                                <div class="wb-navuser-role">{{ Auth::user()->estAdmin() ? 'Administrateur' : 'Étudiant' }}</div>
                            </div>
                            <span class="wb-avatar" aria-hidden="true">{{ Str::upper(Str::substr(Auth::user()->name, 0, 1)) }}</span>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="wb-iconbtn" type="submit" title="Se déconnecter" aria-label="Se déconnecter">
                                    <x-icon name="logout" />
                                </button>
                            </form>
                        </div>
                    </li>
                @else
                    <li class="nav-item d-none d-lg-block ms-lg-2">
                        <button class="wb-theme-toggle" type="button" data-theme-toggle aria-label="Changer de thème">
                            <x-icon name="sun" class="wb-icon-sun" />
                            <x-icon name="moon" class="wb-icon-moon" />
                        </button>
                    </li>
                    <li class="nav-item">
                        <a class="wb-navlink" href="{{ route('login') }}"><x-icon name="login" /> Connexion</a>
                    </li>
                    <li class="nav-item ms-lg-1">
                        <a class="btn btn-primary" href="{{ route('register') }}">
                            <x-icon name="sparkles" /> Commencer
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </nav>
</header>

<main class="wb-main" id="wb-content">
    <div class="container">
        @include('partials.flash')
        @yield('content')
    </div>
</main>

<footer class="wb-footer">
    <div class="container">
        <div class="wb-footer-grid">
            <div>
                <a class="wb-brand mb-3" href="{{ route('home') }}">
                    <span class="wb-brand-mark"><x-icon name="heart-pulse" /></span>
                    <span>WellBot<span class="wb-brand-sub">Bien-être étudiant</span></span>
                </a>
                <p class="mb-0" style="max-width: 40ch; font-size: .88rem;">
                    Un espace calme pour observer vos émotions, respirer et retrouver de l'élan pendant vos études.
                </p>
            </div>
            <div>
                <h6>Plateforme</h6>
                <ul>
                    <li><a href="{{ route('home') }}">Accueil</a></li>
                    @auth
                        <li><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
                        <li><a href="{{ route('moods.index') }}">Suivi d'humeur</a></li>
                        <li><a href="{{ route('resources.index') }}">Ressources</a></li>
                    @else
                        <li><a href="{{ route('register') }}">Créer un compte</a></li>
                        <li><a href="{{ route('login') }}">Se connecter</a></li>
                    @endauth
                </ul>
            </div>
            <div>
                <h6>Projet</h6>
                <ul>
                    <li><span class="text-muted">2ème Licence Business Computing</span></li>
                    <li><span class="text-muted">Projet intégré — BIS 2025/2026</span></li>
                    <li><span class="text-muted">Aziz Ben Kbaier</span></li>
                </ul>
            </div>
        </div>

        <div class="wb-sos">
            <x-icon name="lifebuoy" />
            <div>
                <strong>WellBot ne remplace pas un professionnel de santé.</strong>
                En cas de détresse immédiate, contactez les services d'urgence de votre pays,
                le service de santé de votre université ou une personne de confiance.
            </div>
        </div>

        <div class="wb-footer-bottom">
            <span>&copy; {{ date('Y') }} WellBot — Prenez soin de vous, un jour à la fois.</span>
            <span class="d-inline-flex align-items-center gap-2">
                <x-icon name="leaf" style="width:15px;height:15px" /> Conçu pour la sérénité étudiante
            </span>
        </div>
    </div>
</footer>

@include('partials.chatbot-widget')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script src="{{ asset('js/wellbot.js') }}?v={{ @filemtime(public_path('js/wellbot.js')) ?: 1 }}"></script>
@stack('scripts')
</body>
</html>
