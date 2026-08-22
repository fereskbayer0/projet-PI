@extends('layouts.app')

@section('title', 'Gestion des utilisateurs - WellBot')

@section('content')
<div class="wb-pagehead wb-reveal">
    <a href="{{ route('admin.index') }}" class="btn btn-ghost btn-sm mb-3">
        <x-icon name="arrow-left" /> Retour à l'administration
    </a>
    <div class="wb-pagehead-row">
        <div>
            <span class="wb-eyebrow"><x-icon name="users" /> Comptes</span>
            <h1 style="font-size: clamp(1.7rem, 1.3rem + 1.4vw, 2.3rem)">Gestion des utilisateurs</h1>
            <p>{{ $utilisateurs->count() }} compte{{ $utilisateurs->count() > 1 ? 's' : '' }} inscrit{{ $utilisateurs->count() > 1 ? 's' : '' }} sur la plateforme.</p>
        </div>
    </div>
</div>

<div class="wb-card wb-reveal" style="padding: .75rem">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Étudiant</th>
                    <th>Rôle</th>
                    <th>Inscrit le</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($utilisateurs as $u)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <span class="wb-avatar">{{ Str::upper(Str::substr($u->name, 0, 1)) }}</span>
                                <div>
                                    <div class="fw-bold" style="font-size:.9rem">
                                        {{ $u->name }}
                                        @if($u->id === Auth::id())
                                            <span class="text-muted fw-normal" style="font-size:.76rem">(vous)</span>
                                        @endif
                                    </div>
                                    <div class="text-muted" style="font-size:.78rem">{{ $u->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($u->estAdmin())
                                <span class="wb-badge wb-badge-sun"><x-icon name="shield" style="width:13px;height:13px" /> Administrateur</span>
                            @else
                                <span class="wb-badge">Étudiant</span>
                            @endif
                        </td>
                        <td class="text-muted wb-nums" style="font-size:.83rem">
                            {{ $u->created_at ? $u->created_at->translatedFormat('j M Y') : '—' }}
                        </td>
                        <td>
                            <div class="d-flex justify-content-end gap-1">
                                @if(!$u->estAdmin())
                                    <form method="POST" action="{{ route('admin.users.promote', $u) }}"
                                          onsubmit="return confirm('Promouvoir {{ $u->name }} au rang d\'administrateur ?');">
                                        @csrf
                                        <button class="wb-iconbtn" type="submit"
                                                title="Promouvoir administrateur" aria-label="Promouvoir {{ $u->name }}">
                                            <x-icon name="star" />
                                        </button>
                                    </form>
                                @endif

                                @if($u->id !== Auth::id())
                                    <form method="POST" action="{{ route('admin.users.destroy', $u) }}"
                                          onsubmit="return confirm('Supprimer définitivement le compte de {{ $u->name }} ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="wb-iconbtn wb-iconbtn-danger" type="submit"
                                                title="Supprimer le compte" aria-label="Supprimer {{ $u->name }}">
                                            <x-icon name="trash" />
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
