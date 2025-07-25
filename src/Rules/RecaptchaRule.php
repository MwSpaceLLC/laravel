<?php namespace MwSpace\Laravel\Rules;

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

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RecaptchaRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString $fail
     * @throws ConnectionException
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        try {
            $response = Http::withOptions(['verify' => false])
                ->post('https://www.google.com/recaptcha/api/siteverify', [
                    'secret' => env('GOOGLE_RECAPTCHA_SECRET_KEY'),
                    'response' => $value,
                    'remoteip' => request()->ip()
                ]);

            if (env('APP_ENV') != 'production') {
                Log::info(json_encode($response->object(), JSON_PRETTY_PRINT));
            }

            if (!$response->object()->success) {
                $fail('La verifica reCAPTCHA non è riuscita. Per favore, riprova.');
            }

        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            $fail('La verifica reCAPTCHA non funziona al momento.');
        }

    }
}
