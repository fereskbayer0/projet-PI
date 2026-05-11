@extends('layouts.app')

@section('title', 'Chatbot - Bien-être Étudiant')

@section('content')
<div class="row gy-4">
    <div class="col-12">
        <div class="card feature-card p-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <h2 class="mb-1">Chatbot de soutien</h2>
                    <p class="text-muted mb-0">Assistant conversationnel à base de règles : posez une question sur votre humeur et recevez une réponse adaptée.</p>
                </div>
                @if(!$messages->isEmpty())
                    <form method="POST" action="{{ route('chatbot.clear') }}" onsubmit="return confirm('Effacer tout l\'historique ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm">Effacer l'historique</button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="col-12">
            <div class="alert alert-success">{{ session('success') }}</div>
        </div>
    @endif

    <div class="col-md-5">
        <div class="card feature-card p-4">
            <h5>Envoyer un message</h5>
            <form method="POST" action="{{ route('chatbot.send') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Votre message</label>
                    <textarea name="message" class="form-control" rows="4" required>{{ old('message') }}</textarea>
                    @error('message')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
                <button type="submit" class="btn btn-primary">Envoyer</button>
            </form>
        </div>
    </div>

    <div class="col-md-7">
        <div class="card feature-card p-4">
            <h5>Historique du chatbot</h5>
            @if($messages->isEmpty())
                <p class="text-muted">Aucune conversation pour le moment.</p>
            @else
                <div class="list-group">
                    @foreach($messages as $message)
                        <div class="list-group-item mb-2 rounded-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <strong>Vous :</strong> {{ $message->message }}<br>
                                    <strong>Bot :</strong> {{ $message->response }}
                                    <div class="text-muted mt-2 small">{{ $message->created_at->format('d/m/Y H:i') }}</div>
                                </div>
                                <form method="POST" action="{{ route('chatbot.destroy', $message) }}" class="ms-2" onsubmit="return confirm('Supprimer ce message ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">✕</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
