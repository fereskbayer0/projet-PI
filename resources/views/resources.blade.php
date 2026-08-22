@extends('layouts.app')

@section('title', 'Ressources de bien-être - WellBot')

@section('content')
@php
    $estAdmin = Auth::user() && Auth::user()->estAdmin();

    // Une teinte stable par catégorie : la même rubrique garde toujours sa couleur.
    $plates = ['', 'wb-plate-sun', 'wb-plate-lilac', 'wb-plate-sky', 'wb-plate-coral'];

    // L'icône suit le thème de la ressource quand on le reconnaît.
    $iconsParTheme = [
        'sommeil'     => 'moon',
        'stress'      => 'wind',
        'anxi'        => 'wind',
        'révision'    => 'book',
        'revision'    => 'book',
        'étude'       => 'book',
        'etude'       => 'book',
        'examen'      => 'book',
        'concentr'    => 'sparkles',
        'motivation'  => 'sparkles',
        'urgence'     => 'lifebuoy',
        'écoute'      => 'lifebuoy',
        'sport'       => 'heart-pulse',
        'physique'    => 'heart-pulse',
        'santé'       => 'heart-pulse',
        'sante'       => 'heart-pulse',
        'aliment'     => 'leaf',
    ];
@endphp

<div class="wb-pagehead wb-reveal">
    <div class="wb-pagehead-row">
        <div>
            <span class="wb-eyebrow"><x-icon name="book" /> Bibliothèque</span>
            <h1 style="font-size: clamp(1.7rem, 1.3rem + 1.4vw, 2.3rem)">Ressources de bien-être</h1>
            <p>Des conseils courts et des liens utiles pour traverser l'année sans y laisser votre énergie.</p>
        </div>
        @if($estAdmin)
            <a href="{{ route('resources.create') }}" class="btn btn-primary">
                <x-icon name="plus" /> Ajouter une ressource
            </a>
        @endif
    </div>
</div>

<div class="row g-4">
    @forelse($resources as $item)
        @php
            $cle   = (string) ($item->category ?: $item->title);
            $plate = $plates[abs(crc32($cle)) % count($plates)];

            $icone = 'leaf';
            foreach ($iconsParTheme as $motif => $nom) {
                if (Str::contains(Str::lower($cle . ' ' . $item->title), $motif)) {
                    $icone = $nom;
                    break;
                }
            }
        @endphp

        <div class="col-md-6 col-xl-4">
            <div class="wb-card wb-resource wb-card-hover wb-reveal">
                <div class="d-flex align-items-start justify-content-between gap-2">
                    <span class="wb-plate {{ $plate }}"><x-icon :name="$icone" /></span>
                    @if($item->category)
                        <span class="wb-badge wb-badge-brand">{{ $item->category }}</span>
                    @endif
                </div>

                <h5 class="mb-0">{{ $item->title }}</h5>
                <p>{{ $item->description }}</p>

                <div class="wb-resource-foot">
                    @if($item->url)
                        <a href="{{ $item->url }}" target="_blank" rel="noopener" class="wb-resource-link">
                            Consulter <x-icon name="external" />
                        </a>
                    @else
                        <span class="text-muted" style="font-size:.78rem">Conseil interne</span>
                    @endif

                    @if($estAdmin)
                        <div class="d-flex gap-1">
                            <a href="{{ route('resources.edit', $item) }}" class="wb-iconbtn"
                               title="Modifier" aria-label="Modifier {{ $item->title }}">
                                <x-icon name="pencil" />
                            </a>
                            <form action="{{ route('resources.destroy', $item) }}" method="POST"
                                  onsubmit="return confirm('Supprimer cette ressource ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="wb-iconbtn wb-iconbtn-danger"
                                        title="Supprimer" aria-label="Supprimer {{ $item->title }}">
                                    <x-icon name="trash" />
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="wb-card wb-reveal">
                <x-empty-state icon="book" title="La bibliothèque est vide">
                    @if($estAdmin)
                        Ajoutez une première ressource pour aider les étudiants à s'orienter.
                    @else
                        Les ressources arrivent bientôt. En attendant, WellBot reste disponible pour discuter.
                    @endif

                    <x-slot:action>
                        @if($estAdmin)
                            <a href="{{ route('resources.create') }}" class="btn btn-primary">
                                <x-icon name="plus" /> Ajouter une ressource
                            </a>
                        @else
                            <a href="#" data-chatbot-trigger class="btn btn-primary">
                                <x-icon name="message" /> Parler à WellBot
                            </a>
                        @endif
                    </x-slot:action>
                </x-empty-state>
            </div>
        </div>
    @endforelse
</div>
@endsection
