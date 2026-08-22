@extends('layouts.app')

@section('title', 'WellBot - Votre assistant bien-être')

@section('content')
@php $thread = $messages->reverse(); @endphp

<div class="wb-pagehead wb-reveal">
    <div class="wb-pagehead-row">
        <div>
            <span class="wb-eyebrow"><x-icon name="message" /> Assistant</span>
            <h1 style="font-size: clamp(1.7rem, 1.3rem + 1.4vw, 2.3rem)">Parlons de votre journée</h1>
            <p>WellBot écoute, reformule et propose des pistes simples. Il ne pose aucun diagnostic.</p>
        </div>
        @if($messages->isNotEmpty())
            <form method="POST" action="{{ route('chatbot.clear') }}"
                  onsubmit="return confirm('Effacer tout l\'historique de conversation ?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger btn-sm">
                    <x-icon name="trash" /> Effacer l'historique
                </button>
            </form>
        @endif
    </div>
</div>

<div class="row g-4">
    {{-- ----------------------------------------------------- Conversation --}}
    <div class="col-lg-8">
        <div class="wb-card wb-reveal">
            <div class="wb-thread">
                {{-- Message d'accueil, toujours en tête de fil --}}
                <div class="wb-thread-row">
                    <span class="chatbot-avatar" style="background: linear-gradient(140deg, var(--wb-brand-500), var(--wb-brand-700))">
                        <x-icon name="heart-pulse" />
                    </span>
                    <div class="wb-thread-bubble">
                        Bonjour {{ Str::before(Auth::user()->name, ' ') }} 👋 Je suis WellBot.
                        Racontez-moi ce qui vous préoccupe — même en quelques mots, même mal formulé.
                    </div>
                </div>

                @foreach($thread as $message)
                    <div class="wb-thread-row is-user">
                        <span class="wb-avatar">{{ Str::upper(Str::substr(Auth::user()->name, 0, 1)) }}</span>
                        <div class="wb-thread-bubble">
                            {{ $message->message }}
                            <span class="wb-thread-meta">{{ $message->created_at->format('d/m à H:i') }}</span>
                        </div>
                    </div>

                    <div class="wb-thread-row">
                        <span class="chatbot-avatar" style="background: linear-gradient(140deg, var(--wb-brand-500), var(--wb-brand-700))">
                            <x-icon name="heart-pulse" />
                        </span>
                        <div class="wb-thread-bubble">
                            {{ $message->response }}
                            <form method="POST" action="{{ route('chatbot.destroy', $message) }}" class="mt-2"
                                  onsubmit="return confirm('Supprimer cet échange ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="wb-iconbtn wb-iconbtn-danger"
                                        title="Supprimer cet échange" aria-label="Supprimer cet échange">
                                    <x-icon name="trash" />
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <hr class="wb-divider">

            {{-- --------------------------------------------------- Composer --}}
            <form method="POST" action="{{ route('chatbot.send') }}">
                @csrf
                <label class="form-label" for="page-message">Votre message</label>
                <textarea id="page-message" name="message" rows="3" maxlength="500" required
                          class="form-control @error('message') is-invalid @enderror"
                          placeholder="Aujourd'hui j'ai du mal à me concentrer…">{{ old('message') }}</textarea>
                @error('message')<span class="wb-field-error">{{ $message }}</span>@enderror

                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mt-3">
                    <span class="text-muted" style="font-size:.78rem">500 caractères maximum.</span>
                    <button type="submit" class="btn btn-primary">
                        <x-icon name="send" /> Envoyer
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ----------------------------------------------------------- Aside --}}
    <div class="col-lg-4">
        <div class="wb-card wb-reveal mb-4">
            <h5 class="wb-section-title"><x-icon name="sparkles" /> Par où commencer ?</h5>
            <p class="mb-3" style="font-size:.86rem">Cliquez sur une phrase pour l'insérer dans le champ.</p>

            @php
                $suggestions = [
                    'Je me sens stressé par mes examens.',
                    'Je n\'arrive pas à dormir correctement.',
                    'J\'ai perdu toute motivation ces derniers jours.',
                    'Je me sens seul depuis la rentrée.',
                    'Comment organiser mes révisions sans paniquer ?',
                ];
            @endphp

            <div class="d-flex flex-column gap-2">
                @foreach($suggestions as $suggestion)
                    <button type="button" class="btn btn-soft btn-sm text-start" data-suggestion="{{ $suggestion }}"
                            style="justify-content: flex-start">
                        {{ $suggestion }}
                    </button>
                @endforeach
            </div>
        </div>

        <div class="wb-card wb-reveal">
            <h5 class="wb-section-title"><x-icon name="lifebuoy" /> Bon à savoir</h5>
            <p class="mb-2" style="font-size:.86rem">
                WellBot est un soutien du quotidien, pas un professionnel de santé.
                Il ne remplace ni un médecin, ni un psychologue.
            </p>
            <p class="mb-0" style="font-size:.86rem">
                Si ce que vous traversez devient trop lourd, parlez-en au service de santé
                de votre université ou à une personne de confiance.
            </p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    (function () {
        var field = document.getElementById('page-message');
        if (!field) return;

        document.querySelectorAll('[data-suggestion]').forEach(function (button) {
            button.addEventListener('click', function () {
                field.value = button.dataset.suggestion;
                field.focus();
                field.setSelectionRange(field.value.length, field.value.length);
                field.scrollIntoView({ behavior: 'smooth', block: 'center' });
            });
        });
    })();
</script>
@endpush
