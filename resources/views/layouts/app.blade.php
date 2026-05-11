<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Plateforme Web de Bien-être Étudiant')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #eef4fb; color: #22303a; }
        .navbar { background: #ffffff; }
        .btn-primary { background: #4d8cff; border: none; }
        .feature-card { border: none; border-radius: 16px; box-shadow: 0 10px 30px rgba(34, 48, 58, 0.08); }
        .page-title { color: #1d2939; }
        .hero { min-height: 70vh; }
        .footer { padding: 24px 0; color: #6b7280; }
        .brand-icon { display: inline-block; width: 28px; height: 28px; background: #4d8cff; color: white; border-radius: 50%; text-align: center; line-height: 28px; font-weight: bold; margin-right: 8px; }
    </style>
    @stack('styles')
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">
            <span class="brand-icon">B</span>Bien-être Étudiant
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Accueil</a></li>
                @auth
                    <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Tableau de bord</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('moods.index') }}">Humeur</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('chatbot.index') }}">Chatbot</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('resources.index') }}">Ressources</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('stats') }}">Statistiques</a></li>
                    @if(Auth::user() && Auth::user()->is_admin)
                        <li class="nav-item"><a class="nav-link text-primary fw-bold" href="{{ route('admin.index') }}">Admin</a></li>
                    @endif
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button class="btn btn-outline-secondary btn-sm">Déconnexion</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Connexion</a></li>
                    <li class="nav-item"><a class="btn btn-primary ms-3" href="{{ route('register') }}">S'inscrire</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
<main class="py-5">
    <div class="container">
        @yield('content')
    </div>
</main>
<footer class="footer text-center">
    <div class="container">
        <p class="mb-0">"Prenez soin de vous, un jour à la fois." - Plateforme Bien-être Étudiant &copy; 2026</p>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@stack('scripts')
</body>
</html>
