@extends('layouts.app')

@section('title', 'Gestion des mots-clés Chatbot - Admin')

@section('content')
<div class="row gy-4">
    <div class="col-12">
        <div class="card feature-card p-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <h2 class="mb-1">Mots-clés Chatbot</h2>
                    <p class="text-muted mb-0">Gérez les réponses pré-programmées du chatbot en cas d'absence de l'IA.</p>
                </div>
                <a href="{{ route('admin.index') }}" class="btn btn-outline-secondary btn-sm">Retour à l'accueil admin</a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="col-12"><div class="alert alert-success">{{ session('success') }}</div></div>
    @endif
    @if($errors->any())
        <div class="col-12">
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="col-md-4">
        <div class="card feature-card p-4">
            <h5>Ajouter un mot-clé</h5>
            <form action="{{ route('admin.keywords.store') }}" method="POST" class="mt-3">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Mot-clé (ex: stress)</label>
                    <input type="text" name="keyword" class="form-control" required maxlength="50">
                </div>
                <div class="mb-3">
                    <label class="form-label">Réponse du bot</label>
                    <textarea name="response" class="form-control" rows="4" required maxlength="500" placeholder="Conseil bienveillant à envoyer..."></textarea>
                </div>
                <button type="submit" class="btn btn-primary w-100">Ajouter</button>
            </form>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card feature-card p-4">
            <h5>Liste des mots-clés ({{ $keywords->count() }})</h5>
            <div class="table-responsive mt-3">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Mot-clé</th>
                            <th>Réponse</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($keywords as $k)
                            <tr>
                                <td><span class="badge bg-secondary">{{ $k->keyword }}</span></td>
                                <td><small>{{ Str::limit($k->response, 80) }}</small></td>
                                <td class="text-end">
                                    <form action="{{ route('admin.keywords.destroy', $k) }}" method="POST" onsubmit="return confirm('Supprimer ce mot-clé ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-4">Aucun mot-clé défini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
