@extends('layouts.app')

@section('title', 'Inscription - WellBot')

@section('content')
<div class="row justify-content-center">
    <div class="col-xl-10">
        <div class="wb-auth wb-reveal">
            {{-- ------------------------------------------------- Formulaire --}}
            <div class="wb-auth-form">
                <span class="wb-eyebrow"><x-icon name="sparkles" /> Bienvenue</span>
                <h2 class="mt-3 mb-2">Créer mon espace</h2>
                <p class="mb-4">Trois champs, trente secondes, et c'est à vous.</p>

                @if($errors->any())
                    <div class="alert alert-danger mb-4" role="alert">
                        <x-icon name="alert" />
                        <div>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('register.submit') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label" for="name">Nom complet</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                               class="form-control" placeholder="Aziz Ben Kbaier"
                               autocomplete="name" autofocus required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="email">Adresse e-mail</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                               class="form-control" placeholder="prenom.nom@exemple.tn"
                               autocomplete="email" required>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-sm-6">
                            <label class="form-label" for="password">Mot de passe</label>
                            <div class="wb-password">
                                <input type="password" id="password" name="password" class="form-control"
                                       placeholder="8 caractères minimum" autocomplete="new-password" required>
                                <button type="button" data-password-toggle aria-label="Afficher le mot de passe">
                                    <x-icon name="eye" class="wb-icon-eye" />
                                    <x-icon name="eye-off" class="wb-icon-eye-off" />
                                </button>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label class="form-label" for="password_confirmation">Confirmation</label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                   class="form-control" placeholder="Retapez le mot de passe"
                                   autocomplete="new-password" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 btn-lg">
                        <x-icon name="user-plus" /> Créer mon compte
                    </button>
                </form>

                <p class="mt-4 mb-0" style="font-size:.88rem">
                    Déjà inscrit ?
                    <a href="{{ route('login') }}" class="fw-bold">Se connecter</a>
                </p>
            </div>

            {{-- ------------------------------------------------------ Aside --}}
            <aside class="wb-auth-aside">
                <h3>Ce que vous y gagnez</h3>
                <p>Un espace calme, sans notification insistante ni score à battre.</p>

                <div class="wb-auth-perk"><x-icon name="smile" /> Noter une humeur en 30 secondes</div>
                <div class="wb-auth-perk"><x-icon name="book" /> Des ressources triées par thème</div>
                <div class="wb-auth-perk"><x-icon name="chart" /> Vos courbes, visibles par vous seul</div>
            </aside>
        </div>
    </div>
</div>
@endsection
