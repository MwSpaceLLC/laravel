<script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "LocalBusiness",
      "name": "{{config('app.name')}}",
      "url": "{{request()->url()}}",
      "image": "{{$attributes->get('card')??asset('favicon.ico')}}",
      "description": "{!! $attributes->get('description') !!}"
    }
</script>
