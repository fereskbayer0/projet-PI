<?php

/*
|--------------------------------------------------------------------------
| Palette des humeurs
|--------------------------------------------------------------------------
| Une seule source de verite pour l'emoji, la couleur et le libelle de
| chaque humeur. Les vues s'en servent pour le selecteur, les pastilles
| et les graphiques. Le "token" pointe vers une variable CSS
| (--wb-mood-xxx) afin que le mode sombre reste coherent.
*/

return [

    'list' => [
        'Heureux' => [
            'emoji' => '😊',
            'token' => 'heureux',
            'hint'  => 'Journee lumineuse',
        ],
        'Motivé' => [
            'emoji' => '💪',
            'token' => 'motive',
            'hint'  => 'Plein d\'elan',
        ],
        'Fatigué' => [
            'emoji' => '😴',
            'token' => 'fatigue',
            'hint'  => 'Besoin de repos',
        ],
        'Anxieux' => [
            'emoji' => '😟',
            'token' => 'anxieux',
            'hint'  => 'Esprit agite',
        ],
        'Stressé' => [
            'emoji' => '😣',
            'token' => 'stresse',
            'hint'  => 'Sous pression',
        ],
    ],

    // Repere affiche sous le selecteur d'intensite (1 -> 5)
    'intensity_labels' => [
        1 => 'A peine',
        5 => 'Tres fort',
    ],

];
