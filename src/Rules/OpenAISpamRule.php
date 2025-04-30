<?php namespace MwSpace\Laravel\Rules;

/**
 * @copyright 2025 | MwSpace llc, srl
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

class OpenAISpamRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString $fail
     * @throws ConnectionException
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //todo
    }
}
