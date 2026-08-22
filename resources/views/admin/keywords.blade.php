@extends('layouts.app')

@section('title', 'Mots-clés du chatbot - WellBot')

@section('content')
<div class="wb-pagehead wb-reveal">
    <a href="{{ route('admin.index') }}" class="btn btn-ghost btn-sm mb-3">
        <x-icon name="arrow-left" /> Retour à l'administration
    </a>
    <span class="wb-eyebrow"><x-icon name="key" /> Réponses de secours</span>
    <h1 style="font-size: clamp(1.7rem, 1.3rem + 1.4vw, 2.3rem)">Mots-clés du chatbot</h1>
    <p>
        Quand l'IA Gemini n'est pas disponible, WellBot cherche ces mots-clés dans le
        message de l'étudiant et renvoie la réponse associée. Le mot-clé le plus long
        l'emporte en cas de correspondance multiple.
    </p>
</div>

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

<div class="row g-4">
    {{-- --------------------------------------------------------- Ajouter --}}
    <div class="col-lg-4">
        <div class="wb-card wb-card-accent wb-reveal" style="position: sticky; top: calc(var(--wb-nav-h) + 1.25rem)">
            <h5 class="wb-section-title"><x-icon name="plus" /> Ajouter un mot-clé</h5>

            <form action="{{ route('admin.keywords.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label" for="keyword">Mot-clé</label>
                    <input type="text" id="keyword" name="keyword" class="form-control"
                           placeholder="stress" maxlength="50" required>
                    <span class="wb-label-hint" style="font-size:.76rem">Un seul mot ou une courte expression, en minuscules.</span>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="response">Réponse de WellBot</label>
                    <textarea id="response" name="response" class="form-control" rows="5" maxlength="500" required
                              placeholder="Conseil bienveillant, concret, en deux ou trois phrases…"></textarea>
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    <x-icon name="check" /> Ajouter
                </button>
            </form>
        </div>
    </div>

    {{-- ----------------------------------------------------------- Liste --}}
    <div class="col-lg-8">
        <div class="wb-card wb-reveal" style="padding: 1.25rem">
            <div class="d-flex align-items-center justify-content-between gap-2 mb-3">
                <h5 class="wb-section-title mb-0"><x-icon name="book" /> Mots-clés enregistrés</h5>
                <span class="wb-badge">{{ $keywords->count() }}</span>
            </div>

            @if($keywords->isEmpty())
                <x-empty-state icon="key" title="Aucun mot-clé défini">
                    Sans mot-clé et sans IA, WellBot se rabat sur quelques réponses génériques.
                    Ajoutez-en pour couvrir les situations les plus fréquentes.
                </x-empty-state>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Mot-clé</th>
                                <th>Réponse</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($keywords as $k)
                                <tr>
                                    <td><span class="wb-badge wb-badge-brand">{{ $k->keyword }}</span></td>
                                    <td style="font-size:.85rem; min-width: 260px">{{ $k->response }}</td>
                                    <td class="text-end">
                                        <form action="{{ route('admin.keywords.destroy', $k) }}" method="POST"
                                              onsubmit="return confirm('Supprimer le mot-clé « {{ $k->keyword }} » ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="wb-iconbtn wb-iconbtn-danger"
                                                    title="Supprimer" aria-label="Supprimer le mot-clé {{ $k->keyword }}">
                                                <x-icon name="trash" />
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
