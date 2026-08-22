/* ==========================================================================
   WellBot - comportements d'interface
   Theme clair/sombre, navigation, apparition au defilement, champs mot de
   passe, bulle WellBot et theme partage pour Chart.js.
   ========================================================================== */
(function () {
    'use strict';

    var root = document.documentElement;
    var THEME_KEY = 'wellbot-theme';

    /* ---------------------------------------------------------------------
       Theme clair / sombre
       --------------------------------------------------------------------- */
    function currentTheme() {
        return root.getAttribute('data-bs-theme') === 'dark' ? 'dark' : 'light';
    }

    function applyTheme(theme) {
        root.setAttribute('data-bs-theme', theme);
        try { localStorage.setItem(THEME_KEY, theme); } catch (e) { /* mode prive */ }
        document.dispatchEvent(new CustomEvent('wellbot:theme', { detail: { theme: theme } }));
    }

    document.querySelectorAll('[data-theme-toggle]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            applyTheme(currentTheme() === 'dark' ? 'light' : 'dark');
        });
    });

    /* ---------------------------------------------------------------------
       Page restauree depuis le cache "precedent/suivant" du navigateur :
       son jeton CSRF est peut-etre perime. On la recharge pour eviter
       l'ecran "session expiree" au moment de valider un formulaire.
       --------------------------------------------------------------------- */
    window.addEventListener('pageshow', function (event) {
        if (event.persisted) location.reload();
    });

    /* ---------------------------------------------------------------------
       Navigation : ombre au defilement
       --------------------------------------------------------------------- */
    var nav = document.querySelector('[data-nav]');
    if (nav) {
        var onScroll = function () { nav.classList.toggle('is-stuck', window.scrollY > 8); };
        onScroll();
        window.addEventListener('scroll', onScroll, { passive: true });
    }

    /* ---------------------------------------------------------------------
       Apparition progressive des blocs
       --------------------------------------------------------------------- */
    var reveals = document.querySelectorAll('.wb-reveal');
    if (reveals.length) {
        if (!('IntersectionObserver' in window)) {
            reveals.forEach(function (el) { el.classList.add('is-in'); });
        } else {
            var observer = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry, i) {
                    if (!entry.isIntersecting) return;
                    setTimeout(function () { entry.target.classList.add('is-in'); }, i * 60);
                    observer.unobserve(entry.target);
                });
            }, { rootMargin: '0px 0px -8% 0px', threshold: 0.06 });
            reveals.forEach(function (el) { observer.observe(el); });
        }
    }

    /* ---------------------------------------------------------------------
       Afficher / masquer un mot de passe
       --------------------------------------------------------------------- */
    document.querySelectorAll('[data-password-toggle]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var wrap = btn.closest('.wb-password');
            var input = wrap && wrap.querySelector('input');
            if (!input) return;
            var show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            wrap.classList.toggle('is-visible', show);
            btn.setAttribute('aria-label', show ? 'Masquer le mot de passe' : 'Afficher le mot de passe');
        });
    });

    /* ---------------------------------------------------------------------
       Bulle WellBot
       --------------------------------------------------------------------- */
    var widget = document.querySelector('[data-chatbot-widget]');
    if (widget) {
        var OPEN_KEY = 'wellbot-panel-open';
        var panel = widget.querySelector('[data-chatbot-panel]');
        var opener = widget.querySelector('[data-chatbot-open]');
        var input = widget.querySelector('[data-chatbot-input]');
        var messages = widget.querySelector('[data-chatbot-messages]');
        var form = widget.querySelector('.chatbot-form');

        var scrollToEnd = function () { messages.scrollTop = messages.scrollHeight; };

        var setOpen = function (open, focus) {
            widget.classList.toggle('is-open', open);
            panel.setAttribute('aria-hidden', String(!open));
            opener.setAttribute('aria-expanded', String(open));
            if (!open) return;
            scrollToEnd();
            if (focus !== false) input.focus();
        };

        opener.addEventListener('click', function () {
            setOpen(!widget.classList.contains('is-open'));
        });
        widget.querySelector('[data-chatbot-close]').addEventListener('click', function () {
            setOpen(false);
            opener.focus();
        });
        document.querySelectorAll('[data-chatbot-trigger]').forEach(function (trigger) {
            trigger.addEventListener('click', function (event) {
                event.preventDefault();
                setOpen(true);
            });
        });
        widget.querySelectorAll('[data-chatbot-prompt]').forEach(function (prompt) {
            prompt.addEventListener('click', function () {
                input.value = prompt.dataset.chatbotPrompt;
                input.focus();
                input.dispatchEvent(new Event('input'));
            });
        });

        // Zone de saisie qui grandit avec le texte
        input.addEventListener('input', function () {
            input.style.height = 'auto';
            input.style.height = Math.min(input.scrollHeight, 96) + 'px';
        });

        // Entree envoie, Maj+Entree passe a la ligne
        input.addEventListener('keydown', function (event) {
            if (event.key === 'Enter' && !event.shiftKey) {
                event.preventDefault();
                if (input.value.trim()) form.requestSubmit();
            }
        });

        // La reponse arrive apres rechargement : on affiche un indicateur,
        // puis on rouvre le panneau sur la nouvelle page.
        form.addEventListener('submit', function () {
            try { sessionStorage.setItem(OPEN_KEY, '1'); } catch (e) { /* mode prive */ }

            var sent = document.createElement('div');
            sent.className = 'chatbot-bubble chatbot-bubble-user';
            sent.textContent = input.value;

            var wait = document.createElement('div');
            wait.className = 'chatbot-bubble chatbot-bubble-bot';
            wait.innerHTML = '<span class="chatbot-typing"><i></i><i></i><i></i></span>';

            var empty = messages.querySelector('.chatbot-empty');
            if (empty) empty.remove();
            messages.append(sent, wait);
            scrollToEnd();

            // readOnly et non disabled : un champ desactive n'est pas envoye
            // avec le formulaire, le message serait perdu.
            input.readOnly = true;
            form.querySelector('button[type=submit]').disabled = true;
        });

        var wasOpen = false;
        try { wasOpen = sessionStorage.getItem(OPEN_KEY) === '1'; } catch (e) { /* mode prive */ }
        if (wasOpen) {
            try { sessionStorage.removeItem(OPEN_KEY); } catch (e) { /* mode prive */ }
            setOpen(true, false);
        }

        // Echap ferme le panneau
        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && widget.classList.contains('is-open')) {
                setOpen(false);
                opener.focus();
            }
        });

        scrollToEnd();
    }

    /* ---------------------------------------------------------------------
       Theme partage pour Chart.js
       --------------------------------------------------------------------- */
    var MOOD_COLORS = {
        'Heureux': '#24a97c',
        'Motive':  '#e39a1c',
        'Motivé':  '#e39a1c',
        'Stresse': '#d95a3f',
        'Stressé': '#d95a3f',
        'Anxieux': '#7b6ecd',
        'Fatigue': '#5b86b0',
        'Fatigué': '#5b86b0'
    };
    var FALLBACK = ['#199c88', '#f5b545', '#7b6ecd', '#5b86b0', '#d95a3f', '#6fd2bd'];

    window.WellBot = {
        moodColor: function (label, index) {
            return MOOD_COLORS[label] || FALLBACK[index % FALLBACK.length];
        },
        moodColors: function (labels) {
            return labels.map(function (label, i) { return window.WellBot.moodColor(label, i); });
        },
        ink: function () {
            return getComputedStyle(root).getPropertyValue('--wb-ink-soft').trim() || '#4a6560';
        },
        grid: function () {
            return getComputedStyle(root).getPropertyValue('--wb-line').trim() || 'rgba(13,66,61,.1)';
        },
        surface: function () {
            return getComputedStyle(root).getPropertyValue('--wb-surface').trim() || '#fff';
        },
        /** Degrade vertical doux sous une courbe. */
        fade: function (ctx, color) {
            var area = ctx.chartArea;
            if (!area) return 'transparent';
            var g = ctx.ctx.createLinearGradient(0, area.top, 0, area.bottom);
            g.addColorStop(0, color + '59');
            g.addColorStop(1, color + '00');
            return g;
        }
    };

    if (window.Chart) {
        var applyChartDefaults = function () {
            Chart.defaults.font.family = '"Inter", system-ui, sans-serif';
            Chart.defaults.font.size = 12;
            Chart.defaults.color = window.WellBot.ink();
            Chart.defaults.borderColor = window.WellBot.grid();
            Chart.defaults.plugins.legend.labels.usePointStyle = true;
            Chart.defaults.plugins.legend.labels.boxWidth = 8;
            Chart.defaults.plugins.legend.labels.padding = 16;
            Chart.defaults.plugins.tooltip.backgroundColor = 'rgba(13, 66, 61, .94)';
            Chart.defaults.plugins.tooltip.padding = 11;
            Chart.defaults.plugins.tooltip.cornerRadius = 10;
            Chart.defaults.plugins.tooltip.titleFont = { weight: '700' };
            Chart.defaults.plugins.tooltip.displayColors = false;
            Chart.defaults.maintainAspectRatio = false;
        };
        applyChartDefaults();

        // Les graphiques suivent le changement de theme
        document.addEventListener('wellbot:theme', function () {
            applyChartDefaults();
            Object.values(Chart.instances || {}).forEach(function (chart) {
                chart.options.scales && Object.values(chart.options.scales).forEach(function (scale) {
                    if (scale.ticks) scale.ticks.color = window.WellBot.ink();
                    if (scale.grid) scale.grid.color = window.WellBot.grid();
                });
                chart.update('none');
            });
        });
    }
})();
