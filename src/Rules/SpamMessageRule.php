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

class SpamMessageRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString $fail
     * @throws ConnectionException
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Rimuovi spazi e converti in minuscolo per l'analisi
        $cleanMessage = strtolower(preg_replace('/\s+/', '', $value));

        // Controlla la lunghezza minima
        if (strlen($cleanMessage) < 5) {
            $fail('Il messaggio è troppo corto, riprova.');
        }

        // Controlla la presenza di troppe consonanti consecutive
        if (preg_match('/[bcdfghjklmnpqrstvwxyz]{8,}/i', $cleanMessage)) {
            $fail('Troppe consonanti consecutive, riprova.');
        }

        // Controlla il rapporto tra caratteri unici e lunghezza totale
        // Ma solo per messaggi più corti di una certa lunghezza
        if (strlen($cleanMessage) < 50) {
            $uniqueChars = count(array_unique(str_split($cleanMessage)));
            if ($uniqueChars / strlen($cleanMessage) < 0.25) {
                $fail('Errore del rapporto tra caratteri, riprova.');
            }
        }

        // Controlla la presenza di ripetizioni eccessive
        if (preg_match('/(.)\1{5,}/', $cleanMessage)) {
            $fail('Ripetizioni eccessive, riprova.');
        }

        // Controlla il rapporto tra lettere e numeri/simboli
        $letterCount = preg_match_all('/[a-z]/i', $cleanMessage);
        if ($letterCount / strlen($cleanMessage) < 0.5) {
            $fail('Rapporto tra lettere e numeri/simboli, riprova.');
        }

    }
}
