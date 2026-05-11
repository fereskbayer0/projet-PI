<?php

namespace App\Http\Controllers;

use App\Models\Mood;
use App\Models\Resource;
use App\Models\User;
use App\Models\ChatbotMessage;
use App\Models\ChatbotResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // verifie si l'utilisateur connecte est admin, sinon renvoie une erreur
    private function verifierAdmin()
    {
        if (!Auth::user() || !Auth::user()->estAdmin()) {
            abort(403, "Acces refuse : reserve aux administrateurs.");
        }
    }

    // page d'accueil de l'espace admin avec quelques chiffres
    public function index()
    {
        $this->verifierAdmin();

        $nbUtilisateurs = User::count();
        $nbHumeurs = Mood::count();
        $nbRessources = Resource::count();
        $nbMessagesChatbot = ChatbotMessage::count();

        // Calcul de la tendance globale de l'humeur sur les 7 derniers jours
        $recentMoods = Mood::where('created_at', '>=', now()->subDays(7))->get();
        $grouped = $recentMoods->groupBy(fn($m) => $m->created_at->format('d/m'));
        $chartLabels = $grouped->keys()->toArray();
        $chartScores = $grouped->map(fn($group) => round($group->avg('intensity'), 1))->values()->toArray();

        return view('admin.index', [
            'nbUtilisateurs' => $nbUtilisateurs,
            'nbHumeurs' => $nbHumeurs,
            'nbRessources' => $nbRessources,
            'nbMessagesChatbot' => $nbMessagesChatbot,
            'chartLabels' => $chartLabels,
            'chartScores' => $chartScores,
        ]);
    }

    // liste de tous les utilisateurs
    public function users()
    {
        $this->verifierAdmin();

        $utilisateurs = User::orderBy('name')->get();

        return view('admin.users', [
            'utilisateurs' => $utilisateurs,
        ]);
    }

    // supprimer un utilisateur (sauf soi-meme)
    public function destroyUser(User $user)
    {
        $this->verifierAdmin();

        if ($user->id == Auth::id()) {
            return back()->with('error', "Vous ne pouvez pas vous supprimer vous-meme.");
        }

        $user->delete();

        return back()->with('success', "Utilisateur supprime.");
    }

    // promouvoir un utilisateur en administrateur
    public function promote(User $user)
    {
        $this->verifierAdmin();

        $user->is_admin = true;
        $user->save();

        return back()->with('success', "L'utilisateur est maintenant administrateur.");
    }

    // --- Gestion des mots-clés du chatbot ---

    public function keywords()
    {
        $this->verifierAdmin();

        $keywords = ChatbotResponse::orderBy('keyword')->get();

        return view('admin.keywords', [
            'keywords' => $keywords,
        ]);
    }

    public function storeKeyword(Request $request)
    {
        $this->verifierAdmin();

        $request->validate([
            'keyword' => ['required', 'string', 'max:50', 'unique:chatbot_responses,keyword'],
            'response' => ['required', 'string', 'max:500'],
        ]);

        ChatbotResponse::create([
            'keyword' => mb_strtolower($request->keyword),
            'response' => $request->response,
        ]);

        return back()->with('success', "Mot-clé ajouté avec succès.");
    }

    public function destroyKeyword(ChatbotResponse $keyword)
    {
        $this->verifierAdmin();

        $keyword->delete();

        return back()->with('success', "Mot-clé supprimé.");
    }
}
