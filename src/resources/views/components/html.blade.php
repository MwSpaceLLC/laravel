<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ $attributes->get('class') }}">
<head>
    <meta charset="utf-8">
    <meta name="author" content="MwSpace llc"/>

    <meta name="lang" content="{{ str_replace('_', '-', app()->getLocale()) }}">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>

    <title>{!! $attributes->get('title') !!} | {{config('app.name')}}</title>

    <meta name="description" content="{!! $attributes->get('description') !!}">

    <meta name="theme-color" content="{{$attributes->get('color')??'#ffffff'}}">
    <meta name="msapplication-TileColor" content="{{$attributes->get('color')??'#ffffff'}}">

    <meta name="robots" content="{{app()->environment('local')?'noindex, nofollow':'index, follow'}}"/>
    <meta name="google-site-verification" content="{{env('GOOGLE_SITE_VERIFICATION')}}"/>

    <meta property="og:url" content="{{request()->url()}}"/>
    <meta property="og:title" content="{!! $attributes->get('title') !!}"/>
    <meta property="og:description" content="{!! $attributes->get('description') !!}"/>
    <meta property="og:image" content="{{$attributes->get('og-image')??asset('/opengraph-image.png')}}"/>

    <meta name="twitter:card" content="summary_large_image"/>
    <meta name="twitter:title" content="{!! $attributes->get('title') !!}"/>
    <meta name="twitter:description" content="{!! $attributes->get('description') !!}"/>
    <meta name="twitter:image" content="{{$attributes->get('og-image')??asset('/twitter-image.png')}}"/>

    <x-mwspace::layouts.json {{$attributes}}/>

    {{$head??null}}

    {{$styles??null}}

</head>

<body class="{{$body->attributes->get('class')}}">

{{$body??null}}

<x-mwspace::layouts.errors/>

<x-mwspace::layouts.scripts/>

{{$script??null}}

</body>
</html>
