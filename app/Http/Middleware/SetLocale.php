<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Session'dan locale'i al, yoksa varsayılan dil kodunu kullan
        $locale = session('locale');
        
        // Eğer session'da locale yoksa, varsayılan dil kodunu kullan
        if (!$locale) {
            if (function_exists('default_language_code')) {
                $locale = default_language_code();
            } else {
                $locale = config('app.locale');
            }
        }
        
        // Aktif dilleri veritabanından kontrol et
        if (function_exists('available_language_codes')) {
            $availableLocales = available_language_codes();
        } else {
            $availableLocales = ['tr', 'en'];
        }
        
        // Locale'i aktif diller arasında kontrol et
        if (in_array($locale, $availableLocales)) {
            App::setLocale($locale);
        } else {
            // Geçersiz locale ise varsayılan locale'e dön
            if (function_exists('default_language_code')) {
                App::setLocale(default_language_code());
            } else {
                App::setLocale(config('app.locale'));
            }
        }

        return $next($request);
    }
}
