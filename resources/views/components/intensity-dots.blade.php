@props(['value', 'mood' => null, 'max' => 5])

@php
    $token = $mood ? config('moods.list.' . $mood . '.token') : null;
    $var   = $token ? 'var(--wb-mood-' . $token . ')' : 'var(--wb-brand-500)';
@endphp

<span class="wb-dots" style="--wb-mood: {{ $var }}" role="img"
      aria-label="Intensite {{ $value }} sur {{ $max }}">
    @for($i = 1; $i <= $max; $i++)
        <i @class(['is-on' => $i <= (int) $value])></i>
    @endfor
</span>
