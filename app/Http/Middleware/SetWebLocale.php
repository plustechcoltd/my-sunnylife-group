<?php

namespace App\Http\Middleware;

use App\Helpers\LocalizationHelper;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetWebLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $langs = LocalizationHelper::getLang();
        $defaultLocale = collect($langs)->where('default_yn', 'y')->keys()->first()
            ?? config('app.locale', 'en');

        $userLocale = session('user_locale', $request->user()->language ?? $defaultLocale);
        $lang = $request->get('lang');

        if ($userLocale) {
            app()->setLocale($userLocale);
        }
        
        if ($lang && array_key_exists($lang, $langs)) {
            session(['user_locale' => $lang]);
            app()->setLocale($lang);

            // Remove lang parameter and redirect
            $queries = $request->query();
            unset($queries['lang']);
            
            $newUrl = $request->url();
            if (!empty($queries)) {
                $newUrl .= '?' . http_build_query($queries);
            }

            return redirect($newUrl);
        }

        return $next($request);
    }
}
