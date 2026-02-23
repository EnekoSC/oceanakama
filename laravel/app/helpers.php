<?php

if (! function_exists('lroute')) {
    /**
     * Generate a localized route URL.
     * Prepends the current (or given) locale to the route name.
     */
    function lroute(string $name, mixed $parameters = [], bool $absolute = true, ?string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();

        return route("{$locale}.{$name}", $parameters, $absolute);
    }
}

if (! function_exists('switchLocaleUrl')) {
    /**
     * Generate the URL for the current page in another locale.
     */
    function switchLocaleUrl(string $targetLocale): string
    {
        $route = request()->route();

        if (! $route || ! $route->getName()) {
            return "/{$targetLocale}";
        }

        $currentName = $route->getName();
        $targetName = preg_replace('/^(es|en|fr)\./', "{$targetLocale}.", $currentName);

        try {
            return route($targetName, $route->parameters());
        } catch (\Throwable) {
            return "/{$targetLocale}";
        }
    }
}
