<x-mwspace::html :title="$title" :description="$description">

    <x-slot:head>
        <link rel="preconnect" href="https://cdn.tailwindcss.com">
        <script src="https://cdn.tailwindcss.com/3.4.5"></script>
    </x-slot:head>

    <x-slot:body>
        {{$slot}}
    </x-slot:body>

</x-mwspace::html>
