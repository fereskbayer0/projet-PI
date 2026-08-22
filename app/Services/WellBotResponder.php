<?php

namespace App\Services;

use App\Models\ChatbotResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Fabrique la reponse de WellBot a un message d'etudiant.
 *
 * Trois niveaux, essayes dans cet ordre :
 *
 *   1. Google Gemini      -- si GEMINI_API_KEY est renseignee dans .env
 *   2. Mots-cles          -- table chatbot_responses, geree depuis l'espace admin
 *   3. Reponses par defaut-- filet de securite, toujours disponible
 *
 * Le niveau 1 peut echouer (pas de cle, pas de reseau, quota depasse) sans
 * jamais casser la conversation : on redescend simplement d'un cran.
 */
class WellBotResponder
{
    /** Cadre le ton de l'IA : bienveillant, bref, et jamais medical. */
    private const INSTRUCTION_SYSTEME =
        "Tu es WellBot, un assistant bienveillant qui aide les etudiants tunisiens a gerer "
        . "leur stress, leurs emotions et leur bien-etre mental. Reponds en francais, sois "
        . "chaleureux, donne des conseils simples et pratiques. Ne donne jamais de diagnostic "
        . "medical. Limite tes reponses a 3 ou 4 phrases.";

    private const MODELE_GEMINI = 'gemini-1.5-flash-latest';

    public function repondre(string $message): string
    {
        return $this->viaGemini($message)
            ?? $this->viaMotsCles($message);
    }

    /**
     * Niveau 1 : l'IA. Renvoie null des que quelque chose manque ou echoue,
     * ce qui fait automatiquement basculer sur les mots-cles.
     */
    private function viaGemini(string $message): ?string
    {
        $cleApi = config('services.gemini.key');

        if (empty($cleApi)) {
            return null;
        }

        $url = 'https://generativelanguage.googleapis.com/v1beta/models/'
            . self::MODELE_GEMINI . ':generateContent?key=' . $cleApi;

        try {
            $reponse = Http::timeout(15)->post($url, [
                'contents' => [
                    ['parts' => [
                        ['text' => self::INSTRUCTION_SYSTEME . "\n\nMessage de l'etudiant : " . $message],
                    ]],
                ],
            ]);

            if ($reponse->successful()) {
                $texte = $reponse->json('candidates.0.content.parts.0.text');

                if (is_string($texte) && trim($texte) !== '') {
                    return trim($texte);
                }
            }

            Log::warning('Gemini a repondu sans texte exploitable.', ['statut' => $reponse->status()]);
        } catch (\Throwable $e) {
            Log::warning('Appel a Gemini impossible : ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Niveau 2 : les mots-cles enregistres par un administrateur.
     * Le mot-cle le plus long gagne, pour que "pas bien" l'emporte sur "bien".
     */
    private function viaMotsCles(string $message): string
    {
        $texte = mb_strtolower($message);

        $candidats = ChatbotResponse::all()
            ->sortByDesc(fn (ChatbotResponse $item) => mb_strlen($item->keyword));

        foreach ($candidats as $item) {
            if (str_contains($texte, mb_strtolower($item->keyword))) {
                return $item->response;
            }
        }

        return $this->reponseParDefaut($texte);
    }

    /** Niveau 3 : aucune correspondance, on repond quand meme quelque chose d'utile. */
    private function reponseParDefaut(string $texte): string
    {
        if (str_contains($texte, '?')) {
            return "C'est une bonne question. Pouvez-vous preciser ce que vous ressentez ?";
        }

        if (mb_strlen($texte) < 15) {
            return "Je vous ecoute. N'hesitez pas a m'en dire davantage sur votre ressenti.";
        }

        foreach (['bien', 'super', 'content', 'heureux', 'genial', 'top', 'cool'] as $mot) {
            if (str_contains($texte, $mot)) {
                return "C'est super a entendre ! Continuez sur cette lancee et prenez soin de vous.";
            }
        }

        foreach (['mal', 'pas bien', 'difficile', 'dur', 'nul', 'horrible'] as $mot) {
            if (str_contains($texte, $mot)) {
                return "Je comprends que ce soit difficile. Essayez de respirer profondement "
                    . "et de decouper la journee en petites etapes.";
            }
        }

        return "Merci de partager cela. Si vous sentez que c'est lourd, parlez-en a quelqu'un "
            . "de confiance ou consultez nos ressources.";
    }
}
