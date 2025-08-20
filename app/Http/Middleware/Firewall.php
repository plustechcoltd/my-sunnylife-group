<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\IpUtils;

class Firewall
{
    /**
     * @throws AuthorizationException
     */
    public function handle(Request $request, Closure $next)
    {
        if ('local' === config('app.env') || !$this->isAuthRoute($request) || $this->isAllowedIp($request)) {
            return $next($request);
        }

        throw new AuthorizationException('Unauthorized IP address');
    }

    private function isAuthRoute(Request $request): bool
    {
        $middleware = $request->route()->middleware();

        return count(array_intersect($middleware, ['auth:admin', 'auth:user'])) > 0;
    }

    private function isAllowedIp(Request $request): bool
    {
        $user = $request->user();
        $allowedIps = $user?->allowed_ips ?? [];

        return empty($allowedIps) || IpUtils::checkIp($request->ip(), $allowedIps);
    }
}
