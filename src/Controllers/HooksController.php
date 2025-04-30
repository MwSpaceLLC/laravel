<?php namespace MwSpace\Laravel\Controllers;

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

use App\Http\Controllers\Controller;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use MwSpace\Laravel\Mail\ContactFormSendMail;
use MwSpace\Laravel\Rules\RecaptchaRule;
use MwSpace\Laravel\Rules\SpamMessageRule;

class HooksController extends Controller
{

    /**
     * @throws ConnectionException
     */
    public function contact(Request $request)
    {
        // Setta il locale per la query
        $locale = app()->getLocale();

        // Lista dei campi da escludere
        $excludeFields = ['_token', '_method', 'valid_from', 'submit', 'g-recaptcha-response'];

        // Crea un array di regole dinamiche
        $dynamicRules = [
            'name' => 'required|alpha_num:ascii|max:255',
            'email' => 'required|email|max:255',
            'g-recaptcha-response' => ['required', new RecaptchaRule],
            'message' => [
                'required',
                'min:5',
                'max:255',
                'regex:/^[\p{L}\p{N}\s.,!?()-]+$/u',
                'not_regex:/http[s]?:\/\//',
                new SpamMessageRule
            ],
        ];

        // Messaggi di errore personalizzati
        $messages = [
            'message.regex' => 'Il messaggio può contenere solo lettere, numeri, spazi e alcuni segni di punteggiatura.',
            'message.not_regex' => 'Il messaggio non può contenere URL.',
        ];

        // applica una regola di default per i campi sconosciuti
        foreach ($request->except($excludeFields) as $field => $value) {
            if (!array_key_exists($field, $dynamicRules)) {
                $dynamicRules[$field] = 'nullable|string|max:255';
            }
        }

        // Esegui la validazione con le regole dinamiche
        $validator = Validator::make($request->all(), $dynamicRules, $messages);

        // Ritorna la validazione errori
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Prepara i dati rimuovendo il token CSRF e i valori nulli
        $formData = array_filter(
            $request->except($excludeFields),
            function ($value) {
                return $value !== null && $value !== '';
            }
        );

        // invia la mail al proprietario del sito web
        Mail::to(explode(',', env('MAIL_CONTACT_INBOX')))->send(
            new ContactFormSendMail($formData)
        );

        // invia una copia del messaggio al mittente
        Mail::to($formData['email'])->send(
            new ContactFormSendMail($formData, mode: 'public')
        );

        $request->session()->regenerate();

        return redirect()->route('mwspace.contacts', ['locale' => $locale])->with('success', 'Il messaggio inviato con successo');

    }

}
