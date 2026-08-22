<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Laisse passer uniquement les comptes administrateurs.
 *
 * Enregistre sous l'alias "admin" dans App\Http\Kernel, ce middleware permet
 * de lire les permissions directement dans routes/web.php plutot que de
 * repeter la meme verification dans chaque controleur.
 */
class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || ! $request->user()->estAdmin()) {
            abort(403, "Acces refuse : cette page est reservee aux administrateurs.");
        }

        return $next($request);
    }
}
