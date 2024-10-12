<x-document :title="$item->meta->title" :og-image="$item->meta->image" :description="$item->meta->description">

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <article class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                <div class="w-full aspect-w-16 aspect-h-9">
                    <img src="{{ $item->thumbnail??'https://placehold.co/800x400' }}" alt="{{ $item->title }}"
                         class="object-cover w-full h-full">
                </div>

                <div class="p-8">
                    <h1 class="text-3xl font-bold mb-4 text-gray-900">{{ $item->title }}</h1>

                    <p class="text-gray-600 mb-6">
                        Pubblicato il {{ \Carbon\Carbon::parse($item->createdAt??null)->format('d F Y') }}
                    </p>

                    <div class="prose max-w-none">
                        {!! $item->html !!}
                    </div>

                </div>
            </article>

            <div class="mt-8 text-center">
                <a href="{{ _route('mwspace.posts') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Torna alla lista delle news
                </a>
            </div>
        </div>
    </div>

</x-document>
