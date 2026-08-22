{{-- Bibliotheque d'icones : un seul SVG cache, reutilise via <use href="#i-..."> --}}
<svg xmlns="http://www.w3.org/2000/svg" style="display:none" aria-hidden="true">
    @php
        $line = 'fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"';
    @endphp

    {{-- Marque et bien-etre --}}
    <symbol id="i-heart-pulse" viewBox="0 0 24 24" {!! $line !!}>
        <path d="M20.5 8.6a4.6 4.6 0 0 0-8.5-2.5A4.6 4.6 0 0 0 3.5 8.6c0 1.3.5 2.5 1.3 3.4H8l1.5-2.5 2 5 2-3.5 1 1h4.7c.8-.9 1.3-2.1 1.3-3.4Z"/>
        <path d="M5.6 13.5 12 20l6.4-6.5"/>
    </symbol>
    <symbol id="i-leaf" viewBox="0 0 24 24" {!! $line !!}>
        <path d="M4 20c8.5-1 14-6 15-16-7 0-13 2-14 8-.5 3 .5 5 2 6.5Z"/><path d="M4.5 19.5C8 16 11 13.5 15 11.5"/>
    </symbol>
    <symbol id="i-wind" viewBox="0 0 24 24" {!! $line !!}>
        <path d="M3 8h9a3 3 0 1 0-3-3"/><path d="M3 16h13a3 3 0 1 1-3 3"/><path d="M3 12h16"/>
    </symbol>
    <symbol id="i-sparkles" viewBox="0 0 24 24" {!! $line !!}>
        <path d="m12 3 1.9 4.6L18.5 9.5 13.9 11.4 12 16l-1.9-4.6L5.5 9.5l4.6-1.9Z"/><path d="M18.5 15.5 19.4 18l2.5.9-2.5.9-.9 2.5-.9-2.5-2.5-.9 2.5-.9Z"/>
    </symbol>

    {{-- Navigation --}}
    <symbol id="i-home" viewBox="0 0 24 24" {!! $line !!}>
        <path d="m3.5 10.5 8.5-7 8.5 7"/><path d="M5.5 9.5V20h13V9.5"/><path d="M9.75 20v-5.5h4.5V20"/>
    </symbol>
    <symbol id="i-grid" viewBox="0 0 24 24" {!! $line !!}>
        <rect x="3.5" y="3.5" width="7" height="7" rx="2"/><rect x="13.5" y="3.5" width="7" height="7" rx="2"/>
        <rect x="3.5" y="13.5" width="7" height="7" rx="2"/><rect x="13.5" y="13.5" width="7" height="7" rx="2"/>
    </symbol>
    <symbol id="i-smile" viewBox="0 0 24 24" {!! $line !!}>
        <circle cx="12" cy="12" r="8.5"/><path d="M8.5 14c.9 1.2 2.1 1.8 3.5 1.8s2.6-.6 3.5-1.8"/>
        <path d="M9.25 9.5h.01"/><path d="M14.75 9.5h.01"/>
    </symbol>
    <symbol id="i-message" viewBox="0 0 24 24" {!! $line !!}>
        <path d="M20.5 11.8a7.7 7.7 0 0 1-8.3 7.7c-.7 0-1.4-.1-2-.3L4 20.5l1.3-4.1a7.7 7.7 0 1 1 15.2-4.6Z"/>
        <path d="M9 11h.01"/><path d="M12 11h.01"/><path d="M15 11h.01"/>
    </symbol>
    <symbol id="i-book" viewBox="0 0 24 24" {!! $line !!}>
        <path d="M4 4.5h5a3 3 0 0 1 3 3V20a2.5 2.5 0 0 0-2.5-2.5H4Z"/><path d="M20 4.5h-5a3 3 0 0 0-3 3V20a2.5 2.5 0 0 1 2.5-2.5H20Z"/>
    </symbol>
    <symbol id="i-chart" viewBox="0 0 24 24" {!! $line !!}>
        <path d="M4 20V4"/><path d="M4 20h16"/><rect x="7.5" y="12" width="3.2" height="5"/><rect x="13.3" y="8" width="3.2" height="9"/>
    </symbol>
    <symbol id="i-trending" viewBox="0 0 24 24" {!! $line !!}>
        <path d="m3.5 15.5 5-5 3.5 3.5 6-6.5"/><path d="M14 7.5h4.5V12"/>
    </symbol>
    <symbol id="i-pie" viewBox="0 0 24 24" {!! $line !!}>
        <path d="M12 3.5a8.5 8.5 0 1 0 8.5 8.5H12Z"/><path d="M15.5 3.2A8.5 8.5 0 0 1 20.8 8.5h-5.3Z"/>
    </symbol>
    <symbol id="i-shield" viewBox="0 0 24 24" {!! $line !!}>
        <path d="M12 3.5 5 6v5.5c0 4 2.9 7.6 7 9 4.1-1.4 7-5 7-9V6Z"/><path d="m9.3 12 1.9 1.9 3.5-3.8"/>
    </symbol>
    <symbol id="i-users" viewBox="0 0 24 24" {!! $line !!}>
        <circle cx="9.5" cy="8.5" r="3.2"/><path d="M3.5 19.5a6 6 0 0 1 12 0"/>
        <path d="M16 5.6a3.2 3.2 0 0 1 0 5.9"/><path d="M17.5 14.2a6 6 0 0 1 3 5.3"/>
    </symbol>
    <symbol id="i-key" viewBox="0 0 24 24" {!! $line !!}>
        <circle cx="8" cy="14" r="4"/><path d="m11 11.2 8-8"/><path d="m16.5 5.7 2 2"/><path d="m19.3 2.9 2 2"/>
    </symbol>
    <symbol id="i-menu" viewBox="0 0 24 24" {!! $line !!}>
        <path d="M4 7h16"/><path d="M4 12h16"/><path d="M4 17h16"/>
    </symbol>

    {{-- Compte --}}
    <symbol id="i-login" viewBox="0 0 24 24" {!! $line !!}>
        <path d="M10 4.5H6.5A2.5 2.5 0 0 0 4 7v10a2.5 2.5 0 0 0 2.5 2.5H10"/><path d="m14.5 8.5 3.5 3.5-3.5 3.5"/><path d="M18 12H9"/>
    </symbol>
    <symbol id="i-logout" viewBox="0 0 24 24" {!! $line !!}>
        <path d="M9.5 4.5H6.5A2.5 2.5 0 0 0 4 7v10a2.5 2.5 0 0 0 2.5 2.5h3"/><path d="m16 8.5 3.5 3.5-3.5 3.5"/><path d="M19.5 12h-9"/>
    </symbol>
    <symbol id="i-user-plus" viewBox="0 0 24 24" {!! $line !!}>
        <circle cx="9.5" cy="8" r="3.4"/><path d="M3.5 19.5a6 6 0 0 1 12 0"/><path d="M18.5 8v5"/><path d="M21 10.5h-5"/>
    </symbol>
    <symbol id="i-lock" viewBox="0 0 24 24" {!! $line !!}>
        <rect x="4.5" y="10" width="15" height="10" rx="2.5"/><path d="M8 10V7.5a4 4 0 0 1 8 0V10"/><path d="M12 14v2"/>
    </symbol>
    <symbol id="i-mail" viewBox="0 0 24 24" {!! $line !!}>
        <rect x="3.5" y="5" width="17" height="14" rx="2.5"/><path d="m4 8 7.1 4.6a1.7 1.7 0 0 0 1.8 0L20 8"/>
    </symbol>
    <symbol id="i-eye" viewBox="0 0 24 24" {!! $line !!}>
        <path d="M2.5 12S6 5.8 12 5.8 21.5 12 21.5 12 18 18.2 12 18.2 2.5 12 2.5 12Z"/><circle cx="12" cy="12" r="2.8"/>
    </symbol>
    <symbol id="i-eye-off" viewBox="0 0 24 24" {!! $line !!}>
        <path d="M9.9 5.9a8.9 8.9 0 0 1 2.1-.2c6 0 9.5 6.3 9.5 6.3a16 16 0 0 1-2.7 3.5"/>
        <path d="M6.3 7.7A15.6 15.6 0 0 0 2.5 12S6 18.2 12 18.2c1.5 0 2.8-.3 3.9-.9"/>
        <path d="M10 10.1a2.8 2.8 0 0 0 3.9 3.9"/><path d="m3.5 3.5 17 17"/>
    </symbol>
    <symbol id="i-star" viewBox="0 0 24 24" {!! $line !!}>
        <path d="m12 4 2.4 4.9 5.4.8-3.9 3.8.9 5.4-4.8-2.6-4.8 2.6.9-5.4-3.9-3.8 5.4-.8Z"/>
    </symbol>

    {{-- Actions --}}
    <symbol id="i-plus" viewBox="0 0 24 24" {!! $line !!}><path d="M12 5.5v13"/><path d="M5.5 12h13"/></symbol>
    <symbol id="i-pencil" viewBox="0 0 24 24" {!! $line !!}>
        <path d="M4.5 19.5h4l10-10a2.5 2.5 0 0 0-3.5-3.5l-10 10Z"/><path d="m13.5 7.5 3 3"/>
    </symbol>
    <symbol id="i-trash" viewBox="0 0 24 24" {!! $line !!}>
        <path d="M4.5 6.5h15"/><path d="M9 6.5V5a1.5 1.5 0 0 1 1.5-1.5h3A1.5 1.5 0 0 1 15 5v1.5"/>
        <path d="M6.5 6.5 7.3 19a1.5 1.5 0 0 0 1.5 1.4h6.4a1.5 1.5 0 0 0 1.5-1.4l.8-12.5"/>
    </symbol>
    <symbol id="i-x" viewBox="0 0 24 24" {!! $line !!}><path d="m6.5 6.5 11 11"/><path d="m17.5 6.5-11 11"/></symbol>
    <symbol id="i-send" viewBox="0 0 24 24" {!! $line !!}><path d="M12 19.5v-15"/><path d="m5.5 11 6.5-6.5 6.5 6.5"/></symbol>
    <symbol id="i-arrow-right" viewBox="0 0 24 24" {!! $line !!}><path d="M4.5 12h15"/><path d="m13.5 6 6 6-6 6"/></symbol>
    <symbol id="i-arrow-left" viewBox="0 0 24 24" {!! $line !!}><path d="M19.5 12h-15"/><path d="m10.5 6-6 6 6 6"/></symbol>
    <symbol id="i-external" viewBox="0 0 24 24" {!! $line !!}>
        <path d="M13.5 4.5H19.5V10.5"/><path d="m19.5 4.5-8 8"/><path d="M18 14v4.5a1.5 1.5 0 0 1-1.5 1.5H6a1.5 1.5 0 0 1-1.5-1.5V8A1.5 1.5 0 0 1 6 6.5h4"/>
    </symbol>
    <symbol id="i-save" viewBox="0 0 24 24" {!! $line !!}>
        <path d="M5.5 4.5h10L19.5 8.5v11a1 1 0 0 1-1 1h-13a1 1 0 0 1-1-1v-14a1 1 0 0 1 1-1Z"/>
        <path d="M8.5 4.5v5h6v-5"/><path d="M8 20.5v-5h8v5"/>
    </symbol>

    {{-- Retours d'information --}}
    <symbol id="i-check" viewBox="0 0 24 24" {!! $line !!}>
        <circle cx="12" cy="12" r="8.5"/><path d="m8.5 12.2 2.4 2.4 4.6-5"/>
    </symbol>
    <symbol id="i-alert" viewBox="0 0 24 24" {!! $line !!}>
        <path d="M12 4.5 21 19.5H3Z"/><path d="M12 10v3.5"/><path d="M12 16.5h.01"/>
    </symbol>
    <symbol id="i-info" viewBox="0 0 24 24" {!! $line !!}>
        <circle cx="12" cy="12" r="8.5"/><path d="M12 11.5V16"/><path d="M12 8.2h.01"/>
    </symbol>
    <symbol id="i-lifebuoy" viewBox="0 0 24 24" {!! $line !!}>
        <circle cx="12" cy="12" r="8.5"/><circle cx="12" cy="12" r="3.6"/>
        <path d="m6 6 3.5 3.5"/><path d="m18 6-3.5 3.5"/><path d="m6 18 3.5-3.5"/><path d="m18 18-3.5-3.5"/>
    </symbol>
    <symbol id="i-inbox" viewBox="0 0 24 24" {!! $line !!}>
        <path d="M4 13h4l1.5 2.5h5L16 13h4"/><path d="M6.2 5h11.6l2.2 8v4.5a1.5 1.5 0 0 1-1.5 1.5H5.5A1.5 1.5 0 0 1 4 17.5V13Z"/>
    </symbol>
    <symbol id="i-clock" viewBox="0 0 24 24" {!! $line !!}>
        <circle cx="12" cy="12" r="8.5"/><path d="M12 7.5V12l3 1.8"/>
    </symbol>
    <symbol id="i-calendar" viewBox="0 0 24 24" {!! $line !!}>
        <rect x="4" y="5.5" width="16" height="14.5" rx="2.5"/><path d="M4 10h16"/><path d="M8.5 3.5V7"/><path d="M15.5 3.5V7"/>
    </symbol>
    <symbol id="i-sun" viewBox="0 0 24 24" {!! $line !!}>
        <circle cx="12" cy="12" r="4"/><path d="M12 2.5V4.5"/><path d="M12 19.5v2"/><path d="M4.2 4.2 5.6 5.6"/>
        <path d="m18.4 18.4 1.4 1.4"/><path d="M2.5 12h2"/><path d="M19.5 12h2"/><path d="m4.2 19.8 1.4-1.4"/><path d="m18.4 5.6 1.4-1.4"/>
    </symbol>
    <symbol id="i-moon" viewBox="0 0 24 24" {!! $line !!}>
        <path d="M20 14.5A8.5 8.5 0 0 1 9.5 4a8.5 8.5 0 1 0 10.5 10.5Z"/>
    </symbol>
</svg>
