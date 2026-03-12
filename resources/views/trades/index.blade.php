@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">Handelsvoorstellen</h1>
                <a href="{{ route('trades.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500">
                    Nieuw voorstel
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <h2 class="text-xl font-semibold mb-3">Ontvangen voorstellen</h2>
            @forelse($receivedTrades as $trade)
                <div class="border rounded-lg p-4 mb-4 {{ $trade->status == 'pending' ? 'bg-yellow-50 dark:bg-yellow-900' : ($trade->status == 'accepted' ? 'bg-green-50 dark:bg-green-900' : 'bg-red-50 dark:bg-red-900') }}">
                    <div class="flex justify-between items-start">
                        <div>
                            <p><strong>Van:</strong> {{ $trade->sender->name ?? 'Onbekend' }}</p>
                            <p><strong>Status:</strong>
                                @if($trade->status == 'pending')
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">In afwachting</span>
                                @elseif($trade->status == 'accepted')
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Geaccepteerd</span>
                                @else
                                    <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">Geweigerd</span>
                                @endif
                            </p>
                            <p><strong>Verzonden op:</strong> {{ $trade->created_at->format('d-m-Y H:i') }}</p>
                        </div>

                        @if($trade->status == 'pending')
                            <div class="space-x-2">
                                <form action="{{ route('trades.accept', $trade) }}" method="POST" class="inline" onsubmit="return confirm('Weet je zeker dat je dit handelsvoorstel wilt accepteren?');">
                                    @csrf
                                    <button type="submit" class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600">
                                        Accepteren
                                    </button>
                                </form>
                                <form action="{{ route('trades.decline', $trade) }}" method="POST" class="inline" onsubmit="return confirm('Weet je zeker dat je dit handelsvoorstel wilt weigeren?');">
                                    @csrf
                                    <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                                        Weigeren
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>

                    <div class="mt-4 grid grid-cols-2 gap-4">
                        <div>
                            <h4 class="font-medium mb-2">Aangeboden door {{ $trade->sender->name }}:</h4>
                            <ul class="list-disc list-inside text-sm">
                                @forelse($trade->offeredItems as $off)
                                    <li>{{ $off->item->name }} (x{{ $off->quantity }})</li>
                                @empty
                                    <li>Geen items aangeboden</li>
                                @endforelse
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-medium mb-2">Gevraagd door {{ $trade->sender->name }}:</h4>
                            <ul class="list-disc list-inside text-sm">
                                @forelse($trade->requestedItems as $req)
                                    <li>{{ $req->item->name }} (x{{ $req->quantity }})</li>
                                @empty
                                    <li>Geen items gevraagd (gratis)</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>

                    <div class="mt-2 text-right">
                        <a href="{{ route('trades.show', $trade) }}" class="text-indigo-600 hover:text-indigo-900 text-sm">Bekijk details →</a>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 mb-6">Geen ontvangen voorstellen.</p>
            @endforelse

            <h2 class="text-xl font-semibold mt-8 mb-3">Verzonden voorstellen</h2>
            @forelse($sentTrades as $trade)
                <div class="border rounded-lg p-4 mb-4 {{ $trade->status == 'pending' ? 'bg-blue-50 dark:bg-blue-900' : ($trade->status == 'accepted' ? 'bg-green-50 dark:bg-green-900' : 'bg-red-50 dark:bg-red-900') }}">
                    <div class="flex justify-between">
                        <div>
                            <p><strong>Aan:</strong> {{ $trade->receiver->name ?? 'Onbekend' }}</p>
                            <p><strong>Status:</strong>
                                @if($trade->status == 'pending')
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">In afwachting</span>
                                @elseif($trade->status == 'accepted')
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Geaccepteerd</span>
                                @else
                                    <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">Geweigerd</span>
                                @endif
                            </p>
                            <p><strong>Verzonden op:</strong> {{ $trade->created_at->format('d-m-Y H:i') }}</p>
                        </div>
                    </div>

                    <div class="mt-4 grid grid-cols-2 gap-4">
                        <div>
                            <h4 class="font-medium mb-2">Jij biedt aan:</h4>
                            <ul class="list-disc list-inside text-sm">
                                @forelse($trade->offeredItems as $off)
                                    <li>{{ $off->item->name }} (x{{ $off->quantity }})</li>
                                @empty
                                    <li>Geen items aangeboden</li>
                                @endforelse
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-medium mb-2">Jij vraagt:</h4>
                            <ul class="list-disc list-inside text-sm">
                                @forelse($trade->requestedItems as $req)
                                    <li>{{ $req->item->name }} (x{{ $req->quantity }})</li>
                                @empty
                                    <li>Geen items gevraagd (gratis)</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>

                    <div class="mt-2 text-right">
                        <a href="{{ route('trades.show', $trade) }}" class="text-indigo-600 hover:text-indigo-900 text-sm">Bekijk details →</a>
                    </div>
                </div>
            @empty
                <p class="text-gray-500">Geen verzonden voorstellen.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
