@extends('errors.layout')

@section('title', 'Erreur du serveur')
@section('code', '500')
@section('icon', 'alert')
@section('art-class', 'wb-error-art-stop')
@section('heading', 'Quelque chose s\'est mal passé')

@section('message')
    Le problème vient de notre côté, pas du vôtre. Réessayez dans un instant ;
    si cela persiste, signalez-le à un administrateur.
@endsection

@section('actions')
    <a href="{{ url('/') }}" class="btn btn-primary">Retour à l'accueil</a>
@endsection
