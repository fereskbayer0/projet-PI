@extends('errors.layout')

@section('title', 'Page introuvable')
@section('code', '404')
@section('icon', 'compass')
@section('heading', 'Cette page n\'existe pas')

@section('message')
    Le lien est peut-être erroné, ou la page a été déplacée.
    Revenons sur un chemin connu.
@endsection

@section('actions')
    <a href="{{ url('/') }}" class="btn btn-primary">Retour à l'accueil</a>
    @auth
        <a href="{{ route('dashboard') }}" class="btn btn-ghost">Mon tableau de bord</a>
    @endauth
@endsection
