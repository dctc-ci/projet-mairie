<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Symfony\Component\HttpFoundation\Response;

class EnsureSessionIsActive
{
    /**
     * Déconnecte un utilisateur après N minutes d'inactivité (voir
     * config/session.php > idle_timeout) et injecte dans les réponses HTML
     * le script qui redirige vers la connexion une fois le délai atteint.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() === null) {
            return $next($request);
        }

        if ($this->hasTimedOut($request)) {
            return $this->logOutTimedOutUser($request);
        }

        $request->session()->put('last_activity', now()->timestamp);

        $response = $next($request);

        if ($response instanceof HttpResponse) {
            $this->injectIdleTimerScript($response);
        }

        return $response;
    }

    private function hasTimedOut(Request $request): bool
    {
        $lastActivity = $request->session()->get('last_activity');

        return $lastActivity !== null
            && now()->timestamp - $lastActivity >= $this->timeoutInSeconds();
    }

    private function timeoutInSeconds(): int
    {
        return max(1, (int) config('session.idle_timeout', 5)) * 60;
    }

    /**
     * Déconnecte le garde de session, vide puis renouvelle la session. Les
     * gardes résolus sont ensuite purgés car le garde « sanctum » (actif via
     * auth:sanctum) met l'utilisateur en cache en mémoire pendant la requête.
     */
    private function logOutTimedOutUser(Request $request): Response
    {
        auth()->guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        auth()->forgetGuards();

        return redirect()
            ->route('login')
            ->with('status', sprintf(
                "Votre session a expiré après %d minutes d'inactivité.",
                max(1, (int) config('session.idle_timeout', 5)),
            ));
    }

    private function injectIdleTimerScript(HttpResponse $response): void
    {
        if ($response->isRedirection()
            || ! str_contains((string) $response->headers->get('Content-Type'), 'text/html')) {
            return;
        }

        $content = $response->getContent();

        if (! is_string($content) || $content === '') {
            return;
        }

        $timeoutMs = $this->timeoutInSeconds() * 1000;
        $loginUrl = route('login');

        $script = <<<HTML
<script data-idle-timeout>
    (function () {
        var timeoutMs = {$timeoutMs};
        var timer = null;

        function redirectToLogin() {
            window.location.href = '{$loginUrl}';
        }

        function resetTimer() {
            window.clearTimeout(timer);
            timer = window.setTimeout(redirectToLogin, timeoutMs);
        }

        ['mousemove', 'mousedown', 'keydown', 'touchstart', 'scroll'].forEach(function (eventName) {
            window.addEventListener(eventName, resetTimer, { passive: true });
        });

        resetTimer();
    })();
</script>
HTML;

        if (stripos($content, '</body>') !== false) {
            $content = preg_replace('/<\/body>/i', $script."\n".'</body>', $content, 1);
        } else {
            $content .= "\n".$script;
        }

        $response->setContent($content);
    }
}
