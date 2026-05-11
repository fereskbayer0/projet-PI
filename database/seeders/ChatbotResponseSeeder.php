<?php

namespace Database\Seeders;

use App\Models\ChatbotResponse;
use Illuminate\Database\Seeder;

class ChatbotResponseSeeder extends Seeder
{
    public function run(): void
    {
        $responses = [
            ['keyword' => 'stress', 'response' => 'Essayez des exercices de respiration et prenez quelques minutes pour vous détendre.'],
            ['keyword' => 'trop stress', 'response' => 'Faites une courte pause et notez ce qui vous inquiète pour réduire la pression.'],
            ['keyword' => 'stressé', 'response' => 'Un moment calme et une respiration lente peuvent aider à retrouver de la clarté.'],
            ['keyword' => 'fatigue', 'response' => 'Le sommeil est important : essayez de vous coucher à heures régulières.'],
            ['keyword' => 'coup de barre', 'response' => 'Une petite marche ou un verre d’eau peuvent faire une grande différence.'],
            ['keyword' => 'flasque', 'response' => 'Respirez profondément et essayez de faire une courte sieste si vous le pouvez.'],
            ['keyword' => 'examen', 'response' => 'Organisez votre planning et accordez-vous des pauses pendant l’étude.'],
            ['keyword' => 'partiel', 'response' => 'Reposez-vous un peu entre les sessions pour mieux mémoriser.'],
            ['keyword' => 'anxieux', 'response' => 'Prenez une pause relaxante et concentrez-vous sur votre respiration.'],
            ['keyword' => 'angoissé', 'response' => 'Parlez à un ami ou écrivez vos pensées pour alléger votre esprit.'],
            ['keyword' => 'motivation', 'response' => 'Commencez par une petite action et célébrez chaque progrès.'],
            ['keyword' => 'pas motivé', 'response' => 'Fixez un objectif court et facile pour retrouver un bon rythme.'],
            ['keyword' => 'concentration', 'response' => 'Créez un espace calme et utilisez des sessions courtes pour mieux vous concentrer.'],
            ['keyword' => 'sommeil', 'response' => 'Établissez une routine de coucher et évitez les écrans avant de dormir.'],
            ['keyword' => 'alimentation', 'response' => 'Mangez équilibré et hydratez-vous pour soutenir votre énergie et votre moral.'],
            ['keyword' => 'mange pas', 'response' => 'Essayez une collation saine pour redonner de l’énergie sans vous surcharger.'],
            ['keyword' => 'sport', 'response' => 'Une petite séance de marche ou d’étirement peut aider à réduire le stress.'],
            ['keyword' => 'bouge pas', 'response' => 'Une activité légère comme une promenade peut améliorer votre humeur rapidement.'],
            ['keyword' => 'anxiété', 'response' => 'Respirez profondément et notez ce qui vous préoccupe pour le rendre plus clair.'],
            ['keyword' => 'bien-être', 'response' => 'Prenez du temps pour vous : une pause, un loisir ou une conversation amicale.'],
            ['keyword' => 'à plat', 'response' => 'Accordez-vous une pause et cherchez une activité qui vous détend.'],
            ['keyword' => 'galère', 'response' => 'Parfois, parler à quelqu’un peut aider à voir les choses plus simplement.'],
            ['keyword' => 'c\'est la merde', 'response' => 'C’est dur parfois, mais essayer de découper le problème en petites étapes peut aider.'],
            ['keyword' => 'j\'en peux plus', 'response' => 'Respirez un bon coup, prenez une pause et revenez avec une petite tâche simple.'],
            ['keyword' => 'c\'est chaud', 'response' => 'Respirez calmement et prenez les choses une par une pour alléger la situation.'],
            ['keyword' => 'foiré', 'response' => 'Tout le monde fait des erreurs : apprenez-en une chose, puis passez à autre chose.'],
            ['keyword' => 'à bout', 'response' => 'Faites une pause, parlez à quelqu’un de confiance et reprenez ensuite doucement.'],
            ['keyword' => 'pas le moral', 'response' => 'Faites un petit geste qui vous fait plaisir aujourd’hui, même simple.'],
            ['keyword' => 'deprime', 'response' => 'Accordez-vous de petites pauses, et pensez à faire quelque chose qui vous change les idées.'],
            ['keyword' => 'triste', 'response' => 'Autorisez-vous à ressentir vos émotions puis cherchez une activité réconfortante.'],
            ['keyword' => 'plein de devoirs', 'response' => 'Divisez votre travail en petites tâches et prenez des pauses régulières.'],
        ];

        foreach ($responses as $item) {
            ChatbotResponse::create($item);
        }
    }
}
