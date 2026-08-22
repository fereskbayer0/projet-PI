@extends('layouts.app')

@section('title', 'Connexion - WellBot')

@section('content')
<div class="row justify-content-center">
    <div class="col-xl-10">
        <div class="wb-auth wb-reveal">
            {{-- ------------------------------------------------- Formulaire --}}
            <div class="wb-auth-form">
                <span class="wb-eyebrow"><x-icon name="login" /> Content de vous revoir</span>
                <h2 class="mt-3 mb-2">Connexion</h2>
                <p class="mb-4">Reprenez là où vous vous étiez arrêté.</p>

                @if($errors->any())
                    <div class="alert alert-danger mb-4" role="alert">
                        <x-icon name="alert" />
                        <div>{{ $errors->first() }}</div>
                    </div>
                @endif

                <form method="POST" action="{{ route('login.submit') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label" for="email">Adresse e-mail</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                               class="form-control" placeholder="prenom.nom@exemple.tn"
                               autocomplete="email" autofocus required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label" for="password">Mot de passe</label>
                        <div class="wb-password">
                            <input type="password" id="password" name="password" class="form-control"
                                   placeholder="••••••••" autocomplete="current-password" required>
                            <button type="button" data-password-toggle aria-label="Afficher le mot de passe">
                                <x-icon name="eye" class="wb-icon-eye" />
                                <x-icon name="eye-off" class="wb-icon-eye-off" />
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 btn-lg">
                        <x-icon name="login" /> Se connecter
                    </button>
                </form>

                <p class="mt-4 mb-0" style="font-size:.88rem">
                    Pas encore de compte ?
                    <a href="{{ route('register') }}" class="fw-bold">Créer mon espace</a>
                </p>

                <div class="wb-demo-hint">
                    <x-icon name="info" style="width:14px;height:14px;vertical-align:-2px" />
                    Compte de démonstration : <code>admin@bienetre.tn</code> / <code>admin123</code>
                </div>
            </div>

            {{-- ------------------------------------------------------ Aside --}}
            <aside class="wb-auth-aside">
                <h3>Votre espace vous attend</h3>
                <p>Vos humeurs, vos conversations et vos courbes n'appartiennent qu'à vous.</p>

                <div class="wb-auth-perk"><x-icon name="lock" /> Mot de passe chiffré</div>
                <div class="wb-auth-perk"><x-icon name="message" /> WellBot disponible 24/7</div>
                <div class="wb-auth-perk"><x-icon name="trending" /> Vos tendances en un coup d'œil</div>
            </aside>
        </div>
    </div>
</div>
@endsection
