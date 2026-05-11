@extends('layouts.app')

@section('title', 'Connexion - Bien-être Étudiant')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card feature-card p-4">
            <h3 class="mb-4">Connexion</h3>

            @if($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('login.submit') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">E-mail</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Mot de passe</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Se connecter</button>
            </form>
            <p class="mt-3 text-muted">Pas encore membre ? <a href="{{ route('register') }}">S’inscrire</a></p>
        </div>
    </div>
</div>
@endsection
