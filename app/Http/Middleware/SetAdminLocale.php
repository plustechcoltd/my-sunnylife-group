<?php

namespace App\Http\Middleware;

use App\Helpers\LocalizationHelper;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetAdminLocale
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
        
        $adminLocale = session('admin_locale', $defaultLocale);
        $lang = $request->get('lang');

        if ($adminLocale) {
            app()->setLocale($adminLocale);
        }

        if ($lang && array_key_exists($lang, $langs)) {
            session(['admin_locale' => $lang]);
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
