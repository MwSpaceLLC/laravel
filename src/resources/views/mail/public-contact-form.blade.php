<x-mail::message>
# Copia del messaggio dal form di contatto

Gentile {{ $data['nome'] ?? 'Utente' }},

Grazie per averci contattato tramite il form sul sito web <b>{{ request()->getHost() }}</b>. Abbiamo ricevuto il tuo messaggio e ti risponderemo il prima possibile.

## Riepilogo del tuo messaggio

<x-mail::panel>
@foreach($data as $key => $value)
@if($key != 'email')
**{{ ucfirst($key) }}:** {{ $value }}<br>
@endif
@endforeach
</x-mail::panel>

Ti preghiamo di conservare questa email come riferimento per la tua richiesta.

<x-mail::button :url="config('app.url')">
Visita il nostro sito
</x-mail::button>

Se hai ulteriori domande o necessiti di assistenza immediata, non esitare a contattarci direttamente.

Cordiali saluti,<br>
Il team di {{ request()->getHost() }}

<x-mail::subcopy>
Questa è una conferma automatica del tuo messaggio. Per favore, non rispondere a questa email.
Se desideri inviarci ulteriori informazioni, utilizza nuovamente il form di contatto sul nostro sito web.
Se non sei stato tu ad inviare il messaggio, contatta lo sviluppatore del sito web: <a href="https://www.mwspace.com/it" target="_blank">MwSpace llc</a>
</x-mail::subcopy>
</x-mail::message>
