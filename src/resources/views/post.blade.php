<x-document :title="$item->title" description="Scopri le nostre news">
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <article class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                @if(isset($item->thumbnail) && $item->thumbnail)
                    <div class="w-full aspect-w-16 aspect-h-9">
                        <img src="{{ $item->thumbnail }}" alt="{{ $item->title }}" class="object-cover w-full h-full">
                    </div>
                @endif

                <div class="p-8">
                    <h1 class="text-3xl font-bold mb-4 text-gray-900">{{ $item->title }}</h1>

                    @if(isset($item->createdAt))
                        <p class="text-gray-600 mb-6">
                            Pubblicato il {{ \Carbon\Carbon::parse($item->createdAt)->format('d F Y') }}
                        </p>
                    @endif

                    <div class="prose max-w-none">
                        {!! $item->html !!}
                    </div>

                    @if(isset($item->author))
                        <div class="mt-8 pt-8 border-t border-gray-200">
                            <p class="text-gray-600">Autore: {{ $item->author }}</p>
                        </div>
                    @endif

                    @if(isset($item->tags) && count($item->tags) > 0)
                        <div class="mt-6">
                            <h2 class="text-xl font-semibold mb-2">Tags:</h2>
                            <div class="flex flex-wrap gap-2">
                                @foreach($item->tags as $tag)
                                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-sm">{{ $tag }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </article>

            <div class="mt-8 text-center">
                <a href="{{ _route('mwspace.posts') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Torna alla lista delle news
                </a>
            </div>
        </div>
    </div>
</x-document>
