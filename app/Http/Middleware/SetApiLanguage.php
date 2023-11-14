<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetApiLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Get the 'Accept-Language' header from the request
        $acceptLanguage = $request->header('Accept-Language');

        // Default language if header doesn't specify supported languages
        $defaultLanguage = 'en'; // Set English as the default language

        // Extract the language code from the header if it exists
        $language = $defaultLanguage; // Default to English if no header or unsupported language
        if ($acceptLanguage) {
            $supportedLanguages = config("app.supported_languages"); //  supported languages [ar,en]
            $requestedLanguage = substr($acceptLanguage, 0, 2); // Get the first two characters as language code

            // Check if the requested language is supported
            if (in_array($requestedLanguage, $supportedLanguages)) {
                $language = $requestedLanguage; // Set the requested language
            }
        }

        // Set the application's locale based on the extracted language
        app()->setLocale($language);

        // Proceed with the request
        return $next($request);
    }
}
