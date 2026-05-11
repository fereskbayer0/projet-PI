@extends('layouts.app')

@section('title', 'Suivi d\'humeur - Bien-être Étudiant')

@section('content')
<div class="row gy-4">
    <div class="col-12">
        <div class="card feature-card p-4">
            <h2>Suivi d’humeur</h2>
            <p class="text-muted">Enregistrez votre état du moment et suivez votre évolution.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="col-12">
            <div class="alert alert-success">{{ session('success') }}</div>
        </div>
    @endif

    <div class="col-lg-5">
        <div class="card feature-card p-4">
            <h5>Nouvel enregistrement</h5>
            <form method="POST" action="{{ route('moods.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Humeur</label>
                    <select name="mood" class="form-select" required>
                        <option value="Heureux">Heureux</option>
                        <option value="Stressé">Stressé</option>
                        <option value="Fatigué">Fatigué</option>
                        <option value="Motivé">Motivé</option>
                        <option value="Anxieux">Anxieux</option>
                    </select>
                    @error('mood')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Intensité</label>
                    <select name="intensity" class="form-select" required>
                        @for($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                    @error('intensity')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Note (optionnelle)</label>
                    <textarea name="note" class="form-control" rows="3"></textarea>
                    @error('note')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </form>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="card feature-card p-4">
            <h5>Historique des humeurs</h5>
            @if($moods->isEmpty())
                <p class="text-muted">Aucun enregistrement pour le moment.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-borderless align-middle">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Humeur</th>
                                <th>Intensité</th>
                                <th>Note</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($moods as $mood)
                                <tr>
                                    <td>{{ $mood->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ $mood->mood }}</td>
                                    <td>{{ $mood->intensity }}</td>
                                    <td>{{ $mood->note ?? '-' }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('moods.edit', $mood) }}" class="btn btn-sm btn-outline-primary">Modifier</a>
                                        <form action="{{ route('moods.destroy', $mood) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cette humeur ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Supprimer</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
