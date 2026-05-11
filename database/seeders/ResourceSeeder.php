<?php

namespace Database\Seeders;

use App\Models\Resource;
use Illuminate\Database\Seeder;

class ResourceSeeder extends Seeder
{
    public function run(): void
    {
        $resources = [
            [
                'title' => 'Gestion du stress',
                'description' => 'Découvrez des techniques simples pour rester calme avant les examens : respiration, méditation, pauses régulières.',
                'category' => 'Stress',
                'url' => 'https://www.santepubliquefrance.fr',
            ],
            [
                'title' => 'Préparation aux examens',
                'description' => 'Organisez votre planning de révision pour avancer sereinement et éviter le surmenage de dernière minute.',
                'category' => 'Études',
                'url' => null,
            ],
            [
                'title' => 'Conseils pour le sommeil',
                'description' => 'Un bon sommeil aide à mieux étudier et à garder de l’énergie. Couchez-vous à heures régulières et limitez les écrans.',
                'category' => 'Sommeil',
                'url' => null,
            ],
            [
                'title' => 'Motivation quotidienne',
                'description' => 'Petits objectifs, grandes victoires : restez motivé chaque jour en célébrant vos progrès.',
                'category' => 'Motivation',
                'url' => null,
            ],
            [
                'title' => 'Numéros d’écoute psychologique',
                'description' => 'En cas de mal-être important, contactez Fil Santé Jeunes (0 800 235 236) ou Nightline pour parler à un écoutant.',
                'category' => 'Urgence',
                'url' => 'https://www.filsantejeunes.com',
            ],
            [
                'title' => 'Activité physique et bien-être',
                'description' => 'Une activité régulière, même légère (marche, étirements), améliore l’humeur et réduit l’anxiété.',
                'category' => 'Santé',
                'url' => null,
            ],
        ];

        foreach ($resources as $item) {
            Resource::updateOrCreate(['title' => $item['title']], $item);
        }
    }
}
