@extends('layouts.app')

@section('title', 'Gestion des utilisateurs')

@section('content')
<div class="row gy-4">
    <div class="col-12">
        <div class="card feature-card p-4">
            <h2>Gestion des utilisateurs</h2>
            <p class="text-muted">Liste de tous les comptes inscrits.</p>
            <a href="{{ route('admin.index') }}" class="btn btn-outline-secondary btn-sm">&larr; Retour</a>
        </div>
    </div>

    @if(session('success'))
        <div class="col-12"><div class="alert alert-success">{{ session('success') }}</div></div>
    @endif
    @if(session('error'))
        <div class="col-12"><div class="alert alert-danger">{{ session('error') }}</div></div>
    @endif

    <div class="col-12">
        <div class="card feature-card p-4">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Inscrit le</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($utilisateurs as $u)
                    <tr>
                        <td>{{ $u->name }}</td>
                        <td>{{ $u->email }}</td>
                        <td>
                            @if($u->is_admin)
                                <span class="badge bg-primary">Administrateur</span>
                            @else
                                <span class="badge bg-secondary">Etudiant</span>
                            @endif
                        </td>
                        <td>{{ $u->created_at ? $u->created_at->format('d/m/Y') : '-' }}</td>
                        <td>
                            @if(!$u->is_admin)
                                <form method="POST" action="{{ route('admin.users.promote', $u) }}" class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm btn-outline-primary">Promouvoir</button>
                                </form>
                            @endif
                            @if($u->id != Auth::id())
                                <form method="POST" action="{{ route('admin.users.destroy', $u) }}" class="d-inline" onsubmit="return confirm('Supprimer cet utilisateur ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">Supprimer</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
