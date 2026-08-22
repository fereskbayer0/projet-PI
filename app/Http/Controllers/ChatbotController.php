<?php

namespace App\Http\Controllers;

use App\Models\ChatbotMessage;
use App\Services\WellBotResponder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Conversation avec WellBot.
 *
 * Le controleur ne fait que recevoir, enregistrer et afficher : c'est
 * App\Services\WellBotResponder qui decide du contenu de la reponse.
 */
class ChatbotController extends Controller
{
    public function __construct(private WellBotResponder $responder)
    {
    }

    /** Conversation complete, du plus ancien au plus recent dans la vue. */
    public function index()
    {
        return view('chatbot', [
            'messages' => ChatbotMessage::where('user_id', Auth::id())->latest()->get(),
        ]);
    }

    public function send(Request $request)
    {
        $attributes = $request->validate([
            'message' => ['required', 'string', 'max:500'],
        ]);

        ChatbotMessage::create([
            'user_id' => Auth::id(),
            'message' => $attributes['message'],
            'response' => $this->responder->repondre($attributes['message']),
        ]);

        return back();
    }

    public function destroy(ChatbotMessage $chatbotMessage)
    {
        abort_if($chatbotMessage->user_id !== Auth::id(), 403);

        $chatbotMessage->delete();

        return back()->with('success', 'Message supprimé.');
    }

    public function clear()
    {
        ChatbotMessage::where('user_id', Auth::id())->delete();

        return back()->with('success', 'Historique du chatbot effacé.');
    }
}
