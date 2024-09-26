<?php

/**
 * @copyright 2024 | MwSpace llc, srl
 * @package mwspace/laravel
 * @author Aleksandr Ivanovitch
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 *
 * @license http://www.apache.org/licenses/LICENSE-2.0
 *
 */

if (!function_exists('composer')) {

    /**
     * @return object
     */
    function composer(): object
    {
        return (object)json_decode(
            file_get_contents(__DIR__ . '/../composer.json'), true
        );
    }
}

if (!function_exists('__locales_exists')) {

    /**
     * 3.8 | locale redirect mismatch
     * @param array $langs
     * @return bool
     */
    function __locales_exists(array $langs = []): bool
    {
        $config = (object)require config_path('app.php');
        foreach (\Illuminate\Support\Facades\File::directories(lang_path()) as $lang) $langs[] = basename($lang);
        return
            in_array(request()->segment(1), $langs)
            && request()->segment(1) !== $config->locale
            && request()->segment(1) !== 'api';
    }

}

if (!function_exists('__locales_prefix')) {

    /**
     * @return string|null
     */
    function __locales_prefix(): ?string
    {
        // isset locale at request
        if (!!request()->segment(1)) {
            if (__locales_exists()) {
                return '{lang}';
            }
        }

        return null;
    }
}
