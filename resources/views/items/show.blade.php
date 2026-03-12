@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <a href="{{ route('items.index') }}" class="text-indigo-600 hover:text-indigo-900 mb-4 inline-block">&larr; Terug naar catalogus</a>
            <h1 class="text-3xl font-bold mb-2">{{ $item->name }}</h1>
            <div class="flex space-x-2 mb-4">
                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full">{{ ucfirst($item->type) }}</span>
                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full">{{ ucfirst($item->rarity) }}</span>
                <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full">Level {{ $item->required_level }}</span>
            </div>
            <p class="text-lg mb-6">{{ $item->description }}</p>

            <h2 class="text-xl font-semibold mb-3">Statistieken</h2>
            <div class="grid grid-cols-2 gap-4 max-w-md">
                <div class="flex justify-between">
                    <span>Kracht:</span>
                    <span class="font-mono">{{ $item->power }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Snelheid:</span>
                    <span class="font-mono">{{ $item->speed }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Duurzaamheid:</span>
                    <span class="font-mono">{{ $item->durability }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Magie:</span>
                    <span class="font-mono">{{ $item->magic }}</span>
                </div>
            </div>

            @auth
                <div class="mt-8">
                    <p class="mb-2">Dit item in je inventaris:
                        @php $inv = auth()->user()->inventories()->where('item_id', $item->id)->first(); @endphp
                        {{ $inv ? $inv->quantity : 0 }} stuks
                    </p>
                </div>
            @endauth
        </div>
    </div>
</div>
@endsection
