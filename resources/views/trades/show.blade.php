@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
            <a href="{{ route('trades.index') }}" class="text-indigo-600 hover:text-indigo-900 mb-4 inline-block">
                &larr; Terug naar overzicht
            </a>

            <div class="flex justify-between items-start mb-6">
                <h1 class="text-2xl font-bold">Handelsvoorstel #{{ $trade->id }}</h1>

                <div>
                    @if($trade->status == 'pending')
                        <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm">In afwachting</span>
                    @elseif($trade->status == 'accepted')
                        <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm">Geaccepteerd</span>
                    @else
                        <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm">Geweigerd</span>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="border rounded-lg p-4">
                    <h2 class="font-semibold text-lg mb-3">Van: {{ $trade->sender->name }}</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Email: {{ $trade->sender->email }}</p>

                    <h3 class="font-medium mt-4 mb-2">Aangeboden items:</h3>
                    @if($trade->offeredItems->count() > 0)
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($trade->offeredItems as $item)
                                <li class="text-sm">
                                    {{ $item->item->name }}
                                    <span class="text-gray-500">(x{{ $item->quantity }})</span>
                                    @if($item->item->rarity == 'legendarisch')
                                        <span class="ml-2 px-2 py-0.5 bg-yellow-100 text-yellow-800 rounded-full text-xs">Legendarisch</span>
                                    @elseif($item->item->rarity == 'episch')
                                        <span class="ml-2 px-2 py-0.5 bg-purple-100 text-purple-800 rounded-full text-xs">Episch</span>
                                    @elseif($item->item->rarity == 'zeldzaam')
                                        <span class="ml-2 px-2 py-0.5 bg-blue-100 text-blue-800 rounded-full text-xs">Zeldzaam</span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-sm text-gray-500">Geen items aangeboden</p>
                    @endif
                </div>

                <div class="border rounded-lg p-4">
                    <h2 class="font-semibold text-lg mb-3">Aan: {{ $trade->receiver->name }}</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Email: {{ $trade->receiver->email }}</p>

                    <h3 class="font-medium mt-4 mb-2">Gevraagde items:</h3>
                    @if($trade->requestedItems->count() > 0)
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($trade->requestedItems as $item)
                                <li class="text-sm">
                                    {{ $item->item->name }}
                                    <span class="text-gray-500">(x{{ $item->quantity }})</span>
                                    @if($item->item->rarity == 'legendarisch')
                                        <span class="ml-2 px-2 py-0.5 bg-yellow-100 text-yellow-800 rounded-full text-xs">Legendarisch</span>
                                    @elseif($item->item->rarity == 'episch')
                                        <span class="ml-2 px-2 py-0.5 bg-purple-100 text-purple-800 rounded-full text-xs">Episch</span>
                                    @elseif($item->item->rarity == 'zeldzaam')
                                        <span class="ml-2 px-2 py-0.5 bg-blue-100 text-blue-800 rounded-full text-xs">Zeldzaam</span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-sm text-gray-500">Geen items gevraagd (gratis)</p>
                    @endif
                </div>
            </div>

            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg mb-6">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Verzonden op:</p>
                        <p class="font-medium">{{ $trade->created_at->format('d-m-Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Laatst bijgewerkt:</p>
                        <p class="font-medium">{{ $trade->updated_at->format('d-m-Y H:i') }}</p>
                    </div>
                </div>
            </div>

            @if($trade->status == 'pending' && $trade->receiver_id == auth()->id())
                <div class="flex space-x-4">
                    <form action="{{ route('trades.accept', $trade) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg" onclick="return confirm('Weet je zeker dat je dit voorstel wilt accepteren?')">
                            Accepteren
                        </button>
                    </form>

                    <form action="{{ route('trades.decline', $trade) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-6 rounded-lg" onclick="return confirm('Weet je zeker dat je dit voorstel wilt weigeren?')">
                            Weigeren
                        </button>
                    </form>
                </div>
            @endif

            @if($trade->status == 'accepted')
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    ✅ Dit handelsvoorstel is geaccepteerd. De items zijn geruild!
                </div>
            @endif

            @if($trade->status == 'declined')
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    ❌ Dit handelsvoorstel is geweigerd.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
