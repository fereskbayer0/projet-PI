@extends('layouts.app')

@section('title', 'Modifier l\'humeur - WellBot')

@section('content')
@php $moodList = config('moods.list'); @endphp

<div class="wb-pagehead wb-reveal">
    <a href="{{ route('moods.index') }}" class="btn btn-ghost btn-sm mb-3">
        <x-icon name="arrow-left" /> Retour au journal
    </a>
    <h1 style="font-size: clamp(1.7rem, 1.3rem + 1.4vw, 2.3rem)">Modifier cette note</h1>
    <p>Enregistrée le {{ $mood->created_at->translatedFormat('j F Y') }} à {{ $mood->created_at->format('H:i') }}.</p>
</div>

<div class="row g-4">
    <div class="col-lg-7">
        <div class="wb-card wb-card-accent wb-reveal">
            <form method="POST" action="{{ route('moods.update', $mood) }}">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="form-label d-block">Votre humeur</label>
                    <div class="wb-moodpicker">
                        @foreach($moodList as $label => $meta)
                            <input type="radio" id="mood-{{ $meta['token'] }}" name="mood" value="{{ $label }}"
                                   @checked(old('mood', $mood->mood) === $label) required>
                            <label for="mood-{{ $meta['token'] }}" style="--wb-mood: var(--wb-mood-{{ $meta['token'] }})"
                                   title="{{ $meta['hint'] }}">
                                <span>{{ $meta['emoji'] }}</span>
                                <span>{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('mood')<span class="wb-field-error">{{ $message }}</span>@enderror
                </div>

                <div class="mb-4">
                    <label class="form-label d-block">Intensité</label>
                    <div class="wb-intensity">
                        @for($i = 1; $i <= 5; $i++)
                            <input type="radio" id="intensity-{{ $i }}" name="intensity" value="{{ $i }}"
                                   @checked((int) old('intensity', $mood->intensity) === $i) required>
                            <label for="intensity-{{ $i }}">{{ $i }}</label>
                        @endfor
                    </div>
                    <div class="wb-scale-hint">
                        <span>{{ config('moods.intensity_labels.1') }}</span>
                        <span>{{ config('moods.intensity_labels.5') }}</span>
                    </div>
                    @error('intensity')<span class="wb-field-error">{{ $message }}</span>@enderror
                </div>

                <div class="mb-4">
                    <label class="form-label" for="note">Note <span class="wb-label-hint">— optionnelle</span></label>
                    <textarea id="note" name="note" class="form-control" rows="4" maxlength="255">{{ old('note', $mood->note) }}</textarea>
                    @error('note')<span class="wb-field-error">{{ $message }}</span>@enderror
                </div>

                <div class="d-flex flex-wrap gap-2">
                    <button type="submit" class="btn btn-primary"><x-icon name="save" /> Mettre à jour</button>
                    <a href="{{ route('moods.index') }}" class="btn btn-ghost">Annuler</a>
                </div>
            </form>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="wb-card wb-reveal">
            <h5 class="wb-section-title"><x-icon name="info" /> Version actuelle</h5>
            <div class="d-flex align-items-center gap-2 flex-wrap mb-3">
                <x-mood-chip :mood="$mood->mood" size="lg" />
                <x-intensity-dots :value="$mood->intensity" :mood="$mood->mood" />
            </div>
            <p class="mb-0" style="font-size:.875rem">
                {{ $mood->note ?: 'Aucune note n\'accompagnait cet enregistrement.' }}
            </p>

            <hr class="wb-divider">

            <p class="mb-0" style="font-size:.82rem">
                Corriger une note après coup est normal : on comprend souvent mieux
                une journée une fois qu'elle est passée.
            </p>
        </div>
    </div>
</div>
@endsection
