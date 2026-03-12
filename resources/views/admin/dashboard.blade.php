@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Welcome Card -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h1 class="text-2xl font-bold mb-2">Beheerders Dashboard</h1>
                <p class="text-gray-600 dark:text-gray-400">Welkom terug, {{ auth()->user()->name }}! Hier is een overzicht van het systeem.</p>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <!-- Total Users -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Totaal Gebruikers</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ $totalUsers }}</p>
                            <div class="text-sm text-gray-500">
                                <span class="text-green-500">{{ $totalPlayers }}</span> spelers,
                                <span class="text-purple-500">{{ $totalAdmins }}</span> admins
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Items -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Totaal Items</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ $totalItems }}</p>
                            <div class="text-sm text-gray-500">
                                In de catalogus
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Trades -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Handelsverzoeken</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ $totalTrades }}</p>
                            <div class="text-sm text-gray-500">
                                <span class="text-yellow-500">{{ $pendingTrades }}</span> in afwachting
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Items per Type -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Items per Type</p>
                            @foreach($itemsByType as $type)
                                <div class="text-xs text-gray-600 dark:text-gray-400">
                                    {{ ucfirst($type->type) }}: {{ $type->count }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recente Gebruikers -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Recente Gebruikers</h2>

                    @if($recentUsers->count() > 0)
                        <div class="space-y-3">
                            @foreach($recentUsers as $user)
                                <div class="flex items-center justify-between border-b border-gray-200 dark:border-gray-700 pb-2">
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-gray-100">{{ $user->name }}</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                                    </div>
                                    <div>
                                        @if($user->role === 'admin')
                                            <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded-full text-xs">Admin</span>
                                        @else
                                            <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">Speler</span>
                                        @endif
                                        <p class="text-xs text-gray-400 mt-1">{{ $user->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('admin.users.index') }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                                Alle gebruikers bekijken →
                            </a>
                        </div>
                    @else
                        <p class="text-gray-500">Geen gebruikers gevonden.</p>
                    @endif
                </div>
            </div>

            <!-- Populaire Items -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Meest Voorkomende Items</h2>

                    @if($popularItems->count() > 0)
                        <div class="space-y-3">
                            @foreach($popularItems as $item)
                                <div class="flex items-center justify-between border-b border-gray-200 dark:border-gray-700 pb-2">
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-gray-100">{{ $item->name }}</p>
                                        <div class="flex space-x-2 mt-1">
                                            <span class="px-2 py-0.5 bg-blue-100 text-blue-800 rounded-full text-xs">{{ ucfirst($item->type) }}</span>
                                            <span class="px-2 py-0.5 bg-yellow-100 text-yellow-800 rounded-full text-xs">{{ ucfirst($item->rarity) }}</span>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $item->inventories_count }}</p>
                                        <p class="text-xs text-gray-500">in omloop</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('admin.items.index') }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                                Alle items beheren →
                            </a>
                        </div>
                    @else
                        <p class="text-gray-500">Geen items gevonden.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Snelle Acties -->
        <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Snelle Acties</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <a href="{{ route('admin.users.index') }}" class="block p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                        <h3 class="font-medium text-gray-900 dark:text-gray-100">Gebruikersbeheer</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Bekijk en beheer alle gebruikers</p>
                    </a>

                    <a href="{{ route('admin.items.index') }}" class="block p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                        <h3 class="font-medium text-gray-900 dark:text-gray-100">Itembeheer</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Bekijk en beheer alle items</p>
                    </a>

                    <a href="{{ route('admin.assign-item.index') }}" class="block p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                        <h3 class="font-medium text-gray-900 dark:text-gray-100">Toegekende Items</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Overzicht van uitgedeelde items</p>
                    </a>

                    <a href="{{ route('admin.assign-item.form') }}" class="block p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                        <h3 class="font-medium text-gray-900 dark:text-gray-100">Item Toekennen</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Ken nieuwe items toe aan spelers</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
