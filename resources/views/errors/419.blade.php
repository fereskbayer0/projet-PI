@extends('errors.layout')

@section('title', 'Session expirée')
@section('code', '419')
@section('icon', 'clock')
@section('art-class', 'wb-error-art-warn')
@section('heading', 'Votre session a expiré')

@section('message')
    La page est restée ouverte trop longtemps, ou le serveur a redémarré entre-temps.
    Rien n'est perdu : rouvrez le formulaire et réessayez, cela ne prend qu'un instant.
@endsection

@section('actions')
    <a href="{{ route('login') }}" class="btn btn-primary">Retourner à la connexion</a>
    <a href="{{ url()->previous() }}" class="btn btn-ghost">Revenir en arrière</a>
@endsection
