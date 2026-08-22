@extends('errors.layout')

@section('title', 'Accès refusé')
@section('code', '403')
@section('icon', 'lock')
@section('art-class', 'wb-error-art-warn')
@section('heading', 'Cet espace ne vous est pas ouvert')

@section('message')
    Vous n'avez pas les droits nécessaires pour voir cette page.
    Si vous pensez qu'il s'agit d'une erreur, contactez un administrateur.
@endsection

@section('actions')
    <a href="{{ url('/') }}" class="btn btn-primary">Retour à l'accueil</a>
    @auth
        <a href="{{ route('dashboard') }}" class="btn btn-ghost">Mon tableau de bord</a>
    @endauth
@endsection
