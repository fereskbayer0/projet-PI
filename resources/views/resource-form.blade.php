@extends('layouts.app')

@section('title', ($resource->exists ? 'Modifier' : 'Ajouter') . ' une ressource - Bien-être Étudiant')

@section('content')
<div class="row gy-4">
    <div class="col-12">
        <div class="card feature-card p-4">
            <h2>{{ $resource->exists ? 'Modifier la ressource' : 'Ajouter une ressource' }}</h2>
            <p class="text-muted">Renseignez les informations ci-dessous.</p>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="card feature-card p-4">
            <form method="POST" action="{{ $resource->exists ? route('resources.update', $resource) : route('resources.store') }}">
                @csrf
                @if($resource->exists)
                    @method('PUT')
                @endif

                <div class="mb-3">
                    <label class="form-label">Titre</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $resource->title) }}" required>
                    @error('title')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="4" required>{{ old('description', $resource->description) }}</textarea>
                    @error('description')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Catégorie</label>
                    <input type="text" name="category" class="form-control" value="{{ old('category', $resource->category) }}">
                    @error('category')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Lien (optionnel)</label>
                    <input type="url" name="url" class="form-control" value="{{ old('url', $resource->url) }}" placeholder="https://...">
                    @error('url')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">{{ $resource->exists ? 'Mettre à jour' : 'Créer' }}</button>
                    <a href="{{ route('resources.index') }}" class="btn btn-outline-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
