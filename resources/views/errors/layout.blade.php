{{--
    Coquille autonome pour les pages d'erreur.
    Volontairement independante de layouts.app : aucune requete base de donnees,
    aucun composant, afin de rester affichable meme quand l'application casse.
--}}
<!DOCTYPE html>
<html lang="fr" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Erreur') - WellBot</title>
    <script>
        (function () {
            document.documentElement.classList.add('wb-js');
            try {
                var saved = localStorage.getItem('wellbot-theme');
                var dark = saved ? saved === 'dark'
                    : window.matchMedia('(prefers-color-scheme: dark)').matches;
                document.documentElement.setAttribute('data-bs-theme', dark ? 'dark' : 'light');
            } catch (e) { /* mode prive */ }
        })();
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/wellbot.css') }}" rel="stylesheet">
</head>
<body>
<svg xmlns="http://www.w3.org/2000/svg" style="display:none" aria-hidden="true">
    <symbol id="i-heart-pulse" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
        <path d="M20.5 8.6a4.6 4.6 0 0 0-8.5-2.5A4.6 4.6 0 0 0 3.5 8.6c0 1.3.5 2.5 1.3 3.4H8l1.5-2.5 2 5 2-3.5 1 1h4.7c.8-.9 1.3-2.1 1.3-3.4Z"/>
        <path d="M5.6 13.5 12 20l6.4-6.5"/>
    </symbol>
    <symbol id="i-clock" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="12" cy="12" r="8.5"/><path d="M12 7.5V12l3 1.8"/>
    </symbol>
    <symbol id="i-compass" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="12" cy="12" r="8.5"/><path d="m15 9-1.8 4.2L9 15l1.8-4.2Z"/>
    </symbol>
    <symbol id="i-lock" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
        <rect x="4.5" y="10" width="15" height="10" rx="2.5"/><path d="M8 10V7.5a4 4 0 0 1 8 0V10"/><path d="M12 14v2"/>
    </symbol>
    <symbol id="i-alert" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
        <path d="M12 4.5 21 19.5H3Z"/><path d="M12 10v3.5"/><path d="M12 16.5h.01"/>
    </symbol>
    <symbol id="i-wind" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
        <path d="M3 8h9a3 3 0 1 0-3-3"/><path d="M3 16h13a3 3 0 1 1-3 3"/><path d="M3 12h16"/>
    </symbol>
</svg>

<main class="wb-error">
    <div class="wb-error-inner">
        <a class="wb-error-brand" href="{{ url('/') }}">
            <span><svg aria-hidden="true"><use href="#i-heart-pulse"></use></svg></span>
            WellBot
        </a>

        <div class="wb-error-art @yield('art-class')">
            <svg aria-hidden="true"><use href="#i-@yield('icon', 'alert')"></use></svg>
        </div>

        <span class="wb-error-code">Erreur @yield('code')</span>
        <h1>@yield('heading')</h1>
        <p>@yield('message')</p>

        <div class="wb-error-actions">
            @yield('actions')
        </div>
    </div>
</main>
</body>
</html>
