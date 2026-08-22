@props(['mood', 'size' => null])

@php
    $meta = config('moods.list.' . $mood, ['emoji' => '🙂', 'token' => null]);
    $var  = $meta['token'] ? 'var(--wb-mood-' . $meta['token'] . ')' : 'var(--wb-brand-500)';
@endphp

<span {{ $attributes->class(['wb-mood-chip', 'wb-mood-chip-lg' => $size === 'lg'])->merge(['style' => '--wb-mood: ' . $var]) }}>
    <span class="wb-mood-emoji">{{ $meta['emoji'] }}</span>{{ $mood }}
</span>
