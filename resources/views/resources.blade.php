@extends('layouts.app')

@section('title', 'Ressources - Bien-être Étudiant')

@section('content')
<div class="row gy-4">
    <div class="col-12">
        <div class="card feature-card p-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <h2 class="mb-1">Ressources de bien-être</h2>
                    <p class="text-muted mb-0">Des conseils et liens utiles pour mieux vivre votre vie étudiante.</p>
                </div>
                @if(Auth::user() && Auth::user()->estAdmin())
                    <a href="{{ route('resources.create') }}" class="btn btn-primary btn-sm">+ Ajouter une ressource</a>
                @endif
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="col-12">
            <div class="alert alert-success">{{ session('success') }}</div>
        </div>
    @endif

    @forelse($resources as $item)
        <div class="col-md-6">
            <div class="card feature-card p-4 h-100">
                <div class="d-flex justify-content-between align-items-start">
                    <h5 class="mb-2">{{ $item->title }}</h5>
                    @if($item->category)
                        <span class="badge bg-primary-subtle text-primary">{{ $item->category }}</span>
                    @endif
                </div>
                <p class="text-muted">{{ $item->description }}</p>
                <div class="mt-auto d-flex justify-content-between align-items-center">
                    @if($item->url)
                        <a href="{{ $item->url }}" target="_blank" rel="noopener" class="small">En savoir plus →</a>
                    @else
                        <span></span>
                    @endif
                    @if(Auth::user() && Auth::user()->estAdmin())
                        <div class="d-flex gap-1">
                            <a href="{{ route('resources.edit', $item) }}" class="btn btn-sm btn-outline-primary">Modifier</a>
                            <form action="{{ route('resources.destroy', $item) }}" method="POST" onsubmit="return confirm('Supprimer cette ressource ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Supprimer</button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card feature-card p-4 text-center text-muted">
                Aucune ressource pour le moment. Cliquez sur "Ajouter une ressource" pour commencer.
            </div>
        </div>
    @endforelse
</div>
@endsection
