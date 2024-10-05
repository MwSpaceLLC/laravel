<x-document title="Scopri le nostre news!" description="Scopri le nostre news">

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold mb-8 text-center">Ultime Notizie</h1>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($items as $item)
                    <div
                            class="bg-white overflow-hidden shadow-sm sm:rounded-lg transition duration-300 ease-in-out transform hover:-translate-y-1 hover:shadow-lg">
                        <div class="aspect-w-16 aspect-h-9">
                            @if(isset($item->thumbnail) && $item->thumbnail)
                                <img style="height: 250px;width: 400px;object-fit: cover" src="{{ $item->thumbnail }}"
                                     alt="{{ $item->title }}" class="object-cover w-full h-full">
                            @else
                                <img style="height: 250px;width: 400px;object-fit: cover"
                                     src="https://placehold.co/800x400" alt="Placeholder"
                                     class="object-cover w-full h-full bg-gray-200">
                            @endif
                        </div>
                        <div class="p-6">
                            <h2 class="text-xl font-semibold mb-2 text-gray-800">{{ \Illuminate\Support\Str::upper($item->title) }}</h2>
                            <div class="text-gray-600 mb-4">
                                {!! \Illuminate\Support\Str::limit(strip_tags($item->html), 80) !!}
                            </div>
                            <div class="flex justify-between items-center">

                                @if(isset($item->createdAt))
                                    <span
                                            class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($item->createdAt)->format('d M Y') }}</span>
                                @else
                                    <span class="text-sm text-gray-500">Data non disponibile</span>
                                @endif

                                <a href="{{$item->href}}"
                                   class="text-blue-600 hover:text-blue-800 transition duration-300 ease-in-out">
                                    Leggi di più
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-500 text-lg">Nessuna notizia disponibile al momento.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

</x-document>
