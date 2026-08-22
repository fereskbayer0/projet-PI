@extends('errors.layout')

@section('title', 'Maintenance en cours')
@section('code', '503')
@section('icon', 'wind')
@section('heading', 'WellBot reprend son souffle')

@section('message')
    La plateforme est en maintenance pour quelques minutes.
    Respirez un coup, puis rechargez la page.
@endsection

@section('actions')
    <a href="{{ url('/') }}" class="btn btn-primary">Réessayer</a>
@endsection
