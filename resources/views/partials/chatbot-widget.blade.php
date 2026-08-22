@auth
    <div class="chatbot-widget" data-chatbot-widget>
        <section class="chatbot-panel" data-chatbot-panel aria-label="Assistant WellBot" aria-hidden="true">
            <div class="chatbot-panel-header">
                <div class="d-flex align-items-center gap-2">
                    <span class="chatbot-avatar"><x-icon name="heart-pulse" /></span>
                    <div>
                        <h2>WellBot</h2>
                        <span class="chatbot-status"><span></span> Ici pour vous écouter</span>
                    </div>
                </div>
                <button type="button" class="chatbot-close" data-chatbot-close aria-label="Fermer WellBot">
                    <x-icon name="x" />
                </button>
            </div>

            <div class="chatbot-messages" data-chatbot-messages>
                <div class="chatbot-bubble chatbot-bubble-bot">
                    Bonjour {{ Str::before(Auth::user()->name, ' ') }} 👋<br>
                    Comment vous sentez-vous aujourd'hui ?
                </div>

                @forelse($chatbotMessages as $message)
                    <div class="chatbot-bubble chatbot-bubble-user">{{ $message->message }}</div>
                    <div class="chatbot-bubble chatbot-bubble-bot">
                        {{ $message->response }}
                        <span class="chatbot-time">{{ $message->created_at->format('H:i') }}</span>
                    </div>
                @empty
                    <p class="chatbot-empty">Parlez-moi de ce qui vous préoccupe, même en quelques mots.</p>
                @endforelse
            </div>

            <div class="chatbot-prompts" aria-label="Suggestions">
                <button type="button" data-chatbot-prompt="Je me sens stressé">Je suis stressé</button>
                <button type="button" data-chatbot-prompt="J'ai besoin de motivation">Besoin de motivation</button>
                <button type="button" data-chatbot-prompt="Je n'arrive pas à dormir">Je dors mal</button>
                <button type="button" data-chatbot-prompt="Comment mieux gérer mes révisions ?">Mes révisions</button>
            </div>

            <form class="chatbot-form" method="POST" action="{{ route('chatbot.send') }}">
                @csrf
                <label class="visually-hidden" for="chatbot-message">Votre message</label>
                <textarea id="chatbot-message" name="message" rows="1" maxlength="500" required
                          placeholder="Écrivez votre message..." data-chatbot-input></textarea>
                <button type="submit" aria-label="Envoyer le message" title="Envoyer">
                    <x-icon name="send" />
                </button>
            </form>
            <a class="chatbot-history-link" href="{{ route('chatbot.index') }}">Voir toute la conversation</a>
        </section>

        <button type="button" class="chatbot-launcher" data-chatbot-open aria-label="Ouvrir WellBot" aria-expanded="false">
            <span class="chatbot-launcher-icon"><x-icon name="message" /></span>
            <span class="chatbot-launcher-label">Besoin de parler ?</span>
        </button>
    </div>
@endauth
