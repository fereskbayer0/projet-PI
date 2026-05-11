<?php

namespace App\Http\Controllers;

use App\Models\ChatbotMessage;
use App\Models\ChatbotResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    public function index()
    {
        $messages = ChatbotMessage::where('user_id', Auth::id())->latest()->get();

        return view('chatbot', [
            'messages' => $messages,
        ]);
    }

    public function send(Request $request)
    {
        $request->validate([
            'message' => ['required', 'string', 'max:500'],
        ]);

        $messageUtilisateur = $request->input('message');

        // On essaye d'abord d'utiliser l'IA Gemini si une cle API est configuree
        $reponse = $this->demanderAGemini($messageUtilisateur);

        // Si l'IA n'a pas marche, on utilise notre systeme de mots cles
        if ($reponse == null) {
            $reponse = $this->reponseParMotsCles($messageUtilisateur);
        }

        ChatbotMessage::create([
            'user_id' => Auth::id(),
            'message' => $messageUtilisateur,
            'response' => $reponse,
        ]);

        return back()->with('success', 'Message envoye.');
    }

    public function destroy(ChatbotMessage $chatbotMessage)
    {
        abort_if($chatbotMessage->user_id !== Auth::id(), 403);
        $chatbotMessage->delete();
        return back()->with('success', 'Message supprime.');
    }

    public function clear()
    {
        ChatbotMessage::where('user_id', Auth::id())->delete();
        return back()->with('success', 'Historique du chatbot efface.');
    }

    // Appel a l'API Gemini de Google (gratuit)
    // Pour activer : ajouter GEMINI_API_KEY=xxx dans le fichier .env
    // Cle gratuite a recuperer sur : https://aistudio.google.com/app/apikey
    private function demanderAGemini($message)
    {
        $cleApi = env('GEMINI_API_KEY');

        if (empty($cleApi)) {
            return null;
        }

        $instructionSysteme = "Tu es WellBot, un assistant bienveillant qui aide les etudiants tunisiens a gerer leur stress, leurs emotions et leur bien-etre mental. Reponds en francais, sois chaleureux, donne des conseils simples et pratiques. Ne donne jamais de diagnostic medical. Limite tes reponses a 3 ou 4 phrases.";

        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-latest:generateContent?key=" . $cleApi;

        try {
            $reponseHttp = Http::timeout(15)->post($url, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $instructionSysteme . "\n\nMessage de l'etudiant : " . $message]
                        ]
                    ]
                ]
            ]);

            if ($reponseHttp->successful()) {
                $donnees = $reponseHttp->json();
                if (isset($donnees['candidates'][0]['content']['parts'][0]['text'])) {
                    return trim($donnees['candidates'][0]['content']['parts'][0]['text']);
                }
            }
        } catch (\Exception $e) {
            Log::warning("Erreur appel Gemini : " . $e->getMessage());
        }

        return null;
    }

    // Systeme de reponse par mots cles (utilise si pas d'IA disponible)
    private function reponseParMotsCles($message)
    {
        $texte = mb_strtolower($message);

        $candidats = ChatbotResponse::all()->sortByDesc(function ($item) {
            return mb_strlen($item->keyword);
        });

        foreach ($candidats as $item) {
            if (str_contains($texte, mb_strtolower($item->keyword))) {
                return $item->response;
            }
        }

        return $this->reponseParDefaut($texte);
    }

    private function reponseParDefaut($texte)
    {
        if (str_contains($texte, '?')) {
            return "C'est une bonne question. Pouvez-vous preciser ce que vous ressentez ?";
        }

        if (mb_strlen($texte) < 15) {
            return "Je vous ecoute. N'hesitez pas a m'en dire davantage sur votre ressenti.";
        }

        $motsPositifs = ['bien', 'super', 'content', 'heureux', 'genial', 'top', 'cool'];
        foreach ($motsPositifs as $mot) {
            if (str_contains($texte, $mot)) {
                return "C'est super a entendre ! Continuez sur cette lancee et prenez soin de vous.";
            }
        }

        $motsNegatifs = ['mal', 'pas bien', 'difficile', 'dur', 'nul', 'horrible'];
        foreach ($motsNegatifs as $mot) {
            if (str_contains($texte, $mot)) {
                return "Je comprends que ce soit difficile. Essayez de respirer profondement et de decouper la journee en petites etapes.";
            }
        }

        return "Merci de partager cela. Si vous sentez que c'est lourd, parlez-en a quelqu'un de confiance ou consultez nos ressources.";
    }
}
