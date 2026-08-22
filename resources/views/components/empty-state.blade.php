@props(['icon' => 'inbox', 'title'])

<div {{ $attributes->class('wb-empty') }}>
    <span class="wb-empty-art"><x-icon :name="$icon" /></span>
    <h5>{{ $title }}</h5>
    @if(trim($slot) !== '')
        <p>{{ $slot }}</p>
    @endif
    @isset($action)
        <div class="mt-3">{{ $action }}</div>
    @endisset
</div>
