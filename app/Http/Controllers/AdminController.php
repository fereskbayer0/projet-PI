<?php

namespace App\Http\Controllers;

use App\Models\ChatbotMessage;
use App\Models\ChatbotResponse;
use App\Models\Mood;
use App\Models\Resource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Espace administrateur : chiffres de la plateforme, comptes et mots-cles.
 *
 * L'acces est filtre en amont par le middleware "admin" declare dans
 * routes/web.php ; aucune verification de role n'est donc necessaire ici.
 */
class AdminController extends Controller
{
    /** Vue d'ensemble : compteurs + tendance de l'humeur sur 7 jours. */
    public function index()
    {
        // Une moyenne par jour, tous etudiants confondus
        $tendance = Mood::where('created_at', '>=', now()->subDays(7))
            ->get()
            ->groupBy(fn (Mood $mood) => $mood->created_at->format('d/m'));

        return view('admin.index', [
            'nbUtilisateurs' => User::count(),
            'nbHumeurs' => Mood::count(),
            'nbRessources' => Resource::count(),
            'nbMessagesChatbot' => ChatbotMessage::count(),
            'chartLabels' => $tendance->keys()->toArray(),
            'chartScores' => $tendance->map(fn ($jour) => round($jour->avg('intensity'), 1))
                ->values()
                ->toArray(),
        ]);
    }

    // --- Comptes utilisateurs ------------------------------------------------

    public function users()
    {
        return view('admin.users', [
            'utilisateurs' => User::orderBy('name')->get(),
        ]);
    }

    public function destroyUser(User $user)
    {
        // Garde-fou : un administrateur ne peut pas supprimer son propre compte
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        $user->delete();

        return back()->with('success', 'Utilisateur supprimé.');
    }

    public function promote(User $user)
    {
        $user->update(['is_admin' => true]);

        return back()->with('success', "{$user->name} est maintenant administrateur.");
    }

    // --- Mots-cles du chatbot ------------------------------------------------

    public function keywords()
    {
        return view('admin.keywords', [
            'keywords' => ChatbotResponse::orderBy('keyword')->get(),
        ]);
    }

    public function storeKeyword(Request $request)
    {
        $attributes = $request->validate([
            'keyword' => ['required', 'string', 'max:50', 'unique:chatbot_responses,keyword'],
            'response' => ['required', 'string', 'max:500'],
        ]);

        ChatbotResponse::create([
            // Toujours stocke en minuscules : la comparaison se fait sans casse
            'keyword' => mb_strtolower($attributes['keyword']),
            'response' => $attributes['response'],
        ]);

        return back()->with('success', 'Mot-clé ajouté.');
    }

    public function destroyKeyword(ChatbotResponse $keyword)
    {
        $keyword->delete();

        return back()->with('success', 'Mot-clé supprimé.');
    }
}
