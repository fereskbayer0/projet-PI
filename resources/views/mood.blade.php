@extends('layouts.app')

@section('title', 'Suivi d\'humeur - WellBot')

@section('content')
@php $moodList = config('moods.list'); @endphp

<div class="wb-pagehead wb-reveal">
    <span class="wb-eyebrow"><x-icon name="smile" /> Suivi quotidien</span>
    <h1 style="font-size: clamp(1.7rem, 1.3rem + 1.4vw, 2.3rem)">Comment vous sentez-vous ?</h1>
    <p>Une note honnête vaut mieux qu'une note parfaite. Personne d'autre que vous ne la lira.</p>
</div>

<div class="row g-4">
    {{-- ------------------------------------------------- Nouvelle entrée --}}
    <div class="col-lg-5">
        <div class="wb-card wb-card-accent wb-reveal" style="position: sticky; top: calc(var(--wb-nav-h) + 1.25rem)">
            <h5 class="wb-section-title"><x-icon name="plus" /> Nouvel enregistrement</h5>

            <form method="POST" action="{{ route('moods.store') }}">
                @csrf

                <div class="mb-4">
                    <label class="form-label d-block">Votre humeur</label>
                    <div class="wb-moodpicker">
                        @foreach($moodList as $label => $meta)
                            <input type="radio" id="mood-{{ $meta['token'] }}" name="mood" value="{{ $label }}"
                                   @checked(old('mood', 'Heureux') === $label) required>
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
                    <label class="form-label d-block">Intensité <span class="wb-label-hint">— à quel point ?</span></label>
                    <div class="wb-intensity">
                        @for($i = 1; $i <= 5; $i++)
                            <input type="radio" id="intensity-{{ $i }}" name="intensity" value="{{ $i }}"
                                   @checked((int) old('intensity', 3) === $i) required>
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
                    <textarea id="note" name="note" class="form-control" rows="3" maxlength="255"
                              placeholder="Un examen demain, une bonne nouvelle, une nuit courte…">{{ old('note') }}</textarea>
                    @error('note')<span class="wb-field-error">{{ $message }}</span>@enderror
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    <x-icon name="check" /> Enregistrer mon humeur
                </button>
            </form>
        </div>
    </div>

    {{-- ---------------------------------------------------------- Journal --}}
    <div class="col-lg-7">
        <div class="wb-card wb-reveal">
            <div class="d-flex align-items-center justify-content-between gap-2 mb-3">
                <h5 class="wb-section-title mb-0"><x-icon name="clock" /> Votre journal</h5>
                @if($moods->isNotEmpty())
                    <span class="wb-badge">{{ $moods->count() }} entrée{{ $moods->count() > 1 ? 's' : '' }}</span>
                @endif
            </div>

            @if($moods->isEmpty())
                <x-empty-state icon="inbox" title="Votre journal est encore vide">
                    Enregistrez votre première humeur avec le formulaire ci-contre.
                    En quelques jours, une tendance se dessinera.
                </x-empty-state>
            @else
                <div class="wb-log">
                    @foreach($moods as $entry)
                        <article class="wb-log-item">
                            <div class="wb-log-date">
                                <strong>{{ $entry->created_at->format('d') }}</strong>
                                {{ $entry->created_at->translatedFormat('M') }}<br>
                                {{ $entry->created_at->format('H:i') }}
                            </div>

                            <div>
                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                    <x-mood-chip :mood="$entry->mood" />
                                    <x-intensity-dots :value="$entry->intensity" :mood="$entry->mood" />
                                    <span class="text-muted" style="font-size:.76rem">{{ $entry->intensity }}/5</span>
                                </div>
                                @if($entry->note)
                                    <p class="wb-log-note">{{ $entry->note }}</p>
                                @endif
                            </div>

                            <div class="wb-log-actions">
                                <a href="{{ route('moods.edit', $entry) }}" class="wb-iconbtn"
                                   title="Modifier" aria-label="Modifier cette humeur">
                                    <x-icon name="pencil" />
                                </a>
                                <form action="{{ route('moods.destroy', $entry) }}" method="POST"
                                      onsubmit="return confirm('Supprimer cette humeur ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="wb-iconbtn wb-iconbtn-danger"
                                            title="Supprimer" aria-label="Supprimer cette humeur">
                                        <x-icon name="trash" />
                                    </button>
                                </form>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
