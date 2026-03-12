@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h1 class="text-2xl font-bold mb-4">Speler Dashboard</h1>
                <p class="mb-4">Welkom terug, {{ auth()->user()->name }}!</p>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                    <!-- Statistieken cards -->
                    <div class="bg-blue-100 dark:bg-blue-900 p-4 rounded-lg">
                        <h3 class="font-semibold text-lg">Items in inventaris</h3>
                        <p class="text-3xl font-bold">{{ auth()->user()->inventories()->count() }}</p>
                    </div>

                    <div class="bg-green-100 dark:bg-green-900 p-4 rounded-lg">
                        <h3 class="font-semibold text-lg">Handelsverzoeken</h3>
                        <p class="text-3xl font-bold">{{ auth()->user()->receivedTrades()->where('status', 'pending')->count() }}</p>
                    </div>

                    <div class="bg-purple-100 dark:bg-purple-900 p-4 rounded-lg">
                        <h3 class="font-semibold text-lg">Notificaties</h3>
                        <p class="text-3xl font-bold">{{ auth()->user()->unreadNotifications->count() }}</p>
                    </div>
                </div>

                <!-- Snelle links -->
                <div class="mt-8">
                    <h2 class="text-xl font-semibold mb-3">Snelle acties</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <a href="{{ route('items.index') }}" class="block p-4 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                            <h3 class="font-medium">Bekijk catalogus</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Zoek naar nieuwe items</p>
                        </a>

                        <a href="{{ route('inventory.index') }}" class="block p-4 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                            <h3 class="font-medium">Mijn inventaris</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Bekijk je verzameling</p>
                        </a>

                        <a href="{{ route('trades.create') }}" class="block p-4 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                            <h3 class="font-medium">Nieuw handelsvoorstel</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Ruil items met anderen</p>
                        </a>

                        <a href="{{ route('notifications.index') }}" class="block p-4 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                            <h3 class="font-medium">Notificaties</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Bekijk je meldingen</p>
                        </a>
                    </div>
                </div>

                <!-- Recente activiteit -->
                <div class="mt-8">
                    <h2 class="text-xl font-semibold mb-3">Recente handelsverzoeken</h2>
                    @php
                        $recentTrades = auth()->user()->receivedTrades()->latest()->take(5)->get();
                    @endphp

                    @if($recentTrades->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Van</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Datum</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actie</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($recentTrades as $trade)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $trade->sender->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($trade->status == 'pending')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">In afwachting</span>
                                                @elseif($trade->status == 'accepted')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Geaccepteerd</span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Geweigerd</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $trade->created_at->format('d-m-Y H:i') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <a href="{{ route('trades.show', $trade) }}" class="text-indigo-600 hover:text-indigo-900">Bekijken</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500">Je hebt nog geen handelsverzoeken ontvangen.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
