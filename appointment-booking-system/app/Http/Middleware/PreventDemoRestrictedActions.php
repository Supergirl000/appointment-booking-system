<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventDemoRestrictedActions
{
    private const MESSAGE = 'This action is disabled in demo mode.';

    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): Response  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()?->is_demo) {
            return $this->redirectBack($request);
        }

        return $next($request);
    }

    private function redirectBack(Request $request): RedirectResponse
    {
        return redirect()
            ->back(fallback: route('dashboard'))
            ->with('demo_restricted', __(self::MESSAGE));
    }
}