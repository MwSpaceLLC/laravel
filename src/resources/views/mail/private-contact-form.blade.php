<x-mail::message>
# Nuovo messaggio dal form di contatto

Gentile amministratore,

È stato ricevuto un nuovo messaggio dal form di contatto sul sito web <b>{{ request()->getHost() }}</b>.

## Dettagli del messaggio

<x-mail::panel>
@foreach($data as $key => $value)
**{{ ucfirst($key) }}:** {{ $value }} <br>
@endforeach
</x-mail::panel>

<x-mail::button url="mailto:{{$data['email']}}">
Rispondi a <b>{{$data['email']}}</b>
</x-mail::button>

Se hai ulteriori domande o necessiti di assistenza immediata, non esitare a contattarci tramite <a href="https://helpdesk.mwspace.com" target="_blank">helpdesk</a>

<x-mail::subcopy>
Questo è un messaggio automatico. Si prega di non rispondere direttamente a questa email.
</x-mail::subcopy>

</x-mail::message>
