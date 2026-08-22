@extends('layouts.app')

@section('title', ($resource->exists ? 'Modifier' : 'Ajouter') . ' une ressource - WellBot')

@section('content')
<div class="wb-pagehead wb-reveal">
    <a href="{{ route('resources.index') }}" class="btn btn-ghost btn-sm mb-3">
        <x-icon name="arrow-left" /> Retour aux ressources
    </a>
    <h1 style="font-size: clamp(1.7rem, 1.3rem + 1.4vw, 2.3rem)">
        {{ $resource->exists ? 'Modifier la ressource' : 'Ajouter une ressource' }}
    </h1>
    <p>Une bonne ressource est courte, concrète et directement utilisable par un étudiant pressé.</p>
</div>

<div class="row g-4">
    <div class="col-lg-7">
        <div class="wb-card wb-card-accent wb-reveal">
            <form method="POST" action="{{ $resource->exists ? route('resources.update', $resource) : route('resources.store') }}">
                @csrf
                @if($resource->exists)
                    @method('PUT')
                @endif

                <div class="mb-3">
                    <label class="form-label" for="title">Titre</label>
                    <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror"
                           value="{{ old('title', $resource->title) }}" placeholder="Ex. Cinq minutes pour retrouver le sommeil" required>
                    @error('title')<span class="wb-field-error">{{ $message }}</span>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="description">Description</label>
                    <textarea id="description" name="description" rows="5" required
                              class="form-control @error('description') is-invalid @enderror"
                              placeholder="Expliquez en deux ou trois phrases ce que la ressource apporte.">{{ old('description', $resource->description) }}</textarea>
                    @error('description')<span class="wb-field-error">{{ $message }}</span>@enderror
                </div>

                <div class="row g-3">
                    <div class="col-sm-6">
                        <label class="form-label" for="category">Catégorie <span class="wb-label-hint">— optionnelle</span></label>
                        <input type="text" id="category" name="category" list="wb-categories"
                               class="form-control @error('category') is-invalid @enderror"
                               value="{{ old('category', $resource->category) }}" placeholder="Sommeil, Stress, Révisions…">
                        <datalist id="wb-categories">
                            <option value="Sommeil"></option>
                            <option value="Stress"></option>
                            <option value="Révisions"></option>
                            <option value="Concentration"></option>
                            <option value="Alimentation"></option>
                            <option value="Activité physique"></option>
                        </datalist>
                        @error('category')<span class="wb-field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="col-sm-6">
                        <label class="form-label" for="url">Lien <span class="wb-label-hint">— optionnel</span></label>
                        <input type="url" id="url" name="url" class="form-control @error('url') is-invalid @enderror"
                               value="{{ old('url', $resource->url) }}" placeholder="https://…">
                        @error('url')<span class="wb-field-error">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="d-flex flex-wrap gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">
                        <x-icon name="save" /> {{ $resource->exists ? 'Mettre à jour' : 'Créer la ressource' }}
                    </button>
                    <a href="{{ route('resources.index') }}" class="btn btn-ghost">Annuler</a>
                </div>
            </form>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="wb-card wb-reveal">
            <h5 class="wb-section-title"><x-icon name="sparkles" /> Trois repères</h5>
            @php
                $tips = [
                    'Un titre qui promet un bénéfice, pas un thème vague.',
                    'Une description qui tient en trois phrases maximum.',
                    'Un lien vers une source fiable, quand il en existe une.',
                ];
            @endphp
            @foreach($tips as $index => $tip)
                <div class="wb-step {{ $index ? 'mt-3' : '' }}">
                    <span class="wb-step-num">{{ $index + 1 }}</span>
                    <p class="mt-1 mb-0" style="font-size:.875rem">{{ $tip }}</p>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
