@if(!isset($ldJson))
    @if(request()->routeIs('mwspace.post'))
        <script type="application/ld+json">
            {
              "@context": "https://schema.org",
              "@type": "NewsArticle",
              "headline": "{!! $attributes->get('title') !!}",
              "image": [
                "{{$attributes->get('og-image')??asset('/opengraph-image.png')}}"
              ],
              "author": [{
                "@type": "Organization",
                "name": "{{config('app.name')}}",
                "url": "{{config('app.url')}}"
              }],
              "publisher": {
                "@type": "Organization",
                "name": "{{config('app.name')}}",
                "logo": {
                  "@type": "ImageObject",
                  "url": "{{$attributes->get('og-image')??asset('/opengraph-image.png')}}"
                }
              },
              "description": "{!! $attributes->get('description') !!}",
              "mainEntityOfPage": {
                "@type": "WebPage",
                "@id": "{{request()->url()}}"
              }
            }
        </script>
    @else
        <script type="application/ld+json">
            {
              "@context": "https://schema.org",
              "@type": "LocalBusiness",
              "name": "{{config('app.name')}}",
              "url": "{{request()->url()}}",
              "image": "{{$attributes->get('og-image')??asset('/opengraph-image.png')}}",
              "description": "{!! $attributes->get('description') !!}"
            }
        </script>
    @endif
@else
    {{$ldJson}}
@endif
