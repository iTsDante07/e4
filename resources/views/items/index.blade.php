@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h1 class="text-2xl font-bold mb-6">Itemcatalogus</h1>

            <!-- Filterformulier -->
            <form method="GET" action="{{ route('items.index') }}" class="mb-8 grid grid-cols-1 md:grid-cols-5 gap-4">
                <div>
                    <label for="type" class="block text-sm font-medium">Type</label>
                    <select name="type" id="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Alle</option>
                        @foreach($types as $type)
                            <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="rarity" class="block text-sm font-medium">Zeldzaamheid</label>
                    <select name="rarity" id="rarity" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Alle</option>
                        @foreach($rarities as $rarity)
                            <option value="{{ $rarity }}" {{ request('rarity') == $rarity ? 'selected' : '' }}>{{ ucfirst($rarity) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="min_level" class="block text-sm font-medium">Min. level</label>
                    <input type="number" name="min_level" id="min_level" value="{{ request('min_level') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <div>
                    <label for="max_level" class="block text-sm font-medium">Max. level</label>
                    <input type="number" name="max_level" id="max_level" value="{{ request('max_level') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Filteren
                    </button>
                </div>
            </form>

            <!-- Itemlijst -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($items as $item)
                    <div class="border rounded-lg p-4 hover:shadow-lg transition">
                        <h3 class="font-bold text-lg">{{ $item->name }}</h3>
                        <p class="text-sm text-gray-600">{{ Str::limit($item->description, 80) }}</p>
                        <div class="mt-2 text-xs">
                            <span class="inline-block px-2 py-1 bg-blue-100 text-blue-800 rounded-full">{{ ucfirst($item->type) }}</span>
                            <span class="inline-block px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full">{{ ucfirst($item->rarity) }}</span>
                        </div>
                        <div class="mt-2 grid grid-cols-2 gap-1 text-sm">
                            <div>Kracht: {{ $item->power }}</div>
                            <div>Snelheid: {{ $item->speed }}</div>
                            <div>Duurzaamheid: {{ $item->durability }}</div>
                            <div>Magie: {{ $item->magic }}</div>
                        </div>
                        <a href="{{ route('items.show', $item) }}" class="mt-3 inline-block text-indigo-600 hover:text-indigo-900">Bekijk details →</a>
                    </div>
                @empty
                    <p class="col-span-full text-center text-gray-500">Geen items gevonden.</p>
                @endforelse
            </div>

            <!-- Paginatie -->
            <div class="mt-6">
                {{ $items->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
