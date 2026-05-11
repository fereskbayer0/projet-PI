@extends('layouts.app')

@section('title', 'Modifier l\'humeur - Bien-être Étudiant')

@section('content')
<div class="row gy-4">
    <div class="col-12">
        <div class="card feature-card p-4">
            <h2>Modifier votre humeur</h2>
            <p class="text-muted">Corrigez ou complétez votre enregistrement.</p>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card feature-card p-4">
            <form method="POST" action="{{ route('moods.update', $mood) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Humeur</label>
                    <select name="mood" class="form-select" required>
                        @foreach(['Heureux','Stressé','Fatigué','Motivé','Anxieux'] as $option)
                            <option value="{{ $option }}" @selected(old('mood', $mood->mood) === $option)>{{ $option }}</option>
                        @endforeach
                    </select>
                    @error('mood')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Intensité</label>
                    <select name="intensity" class="form-select" required>
                        @for($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}" @selected((int) old('intensity', $mood->intensity) === $i)>{{ $i }}</option>
                        @endfor
                    </select>
                    @error('intensity')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Note (optionnelle)</label>
                    <textarea name="note" class="form-control" rows="3">{{ old('note', $mood->note) }}</textarea>
                    @error('note')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                    <a href="{{ route('moods.index') }}" class="btn btn-outline-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
