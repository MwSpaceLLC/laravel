<form {{ $attributes->merge([
    'action' => $action??_route('mwspace.hooks.contact'),
    'method' => $method??'post',
    'autocomplete' => 'off',
    'class' => 'mw-contact-form'
]) }} >

    @csrf

    @honeypot

    {{$slot}}

    <p style="margin-top: 10px;width: 100%">
        Inviando questo modulo, accetti i termini di
        <x-mwspace::privacy-policy/>
    </p>
</form>
