@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h1 class="text-2xl font-bold mb-6">Mijn Profiel</h1>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Profiel informatie -->
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <h2 class="text-lg font-semibold mb-4">Profielgegevens</h2>

                        <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Naam</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $user->name }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $user->email }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Rol</label>
                            <p class="mt-1">
                                @if($user->role === 'admin')
                                    <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded-full text-xs">Beheerder</span>
                                @else
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">Speler</span>
                                @endif
                            </p>
                        </div>

                        <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Lid sinds</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $user->created_at->format('d-m-Y') }}</p>
                        </div>
                    </div>

                    <!-- Statistieken -->
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <h2 class="text-lg font-semibold mb-4">Spelstatistieken</h2>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="text-center p-3 bg-white dark:bg-gray-600 rounded-lg">
                                <div class="text-2xl font-bold text-blue-600">{{ $totalItems }}</div>
                                <div class="text-xs text-gray-600 dark:text-gray-300">Totaal items</div>
                            </div>

                            <div class="text-center p-3 bg-white dark:bg-gray-600 rounded-lg">
                                <div class="text-2xl font-bold text-green-600">{{ $uniqueItems }}</div>
                                <div class="text-xs text-gray-600 dark:text-gray-300">Unieke items</div>
                            </div>

                            <div class="text-center p-3 bg-white dark:bg-gray-600 rounded-lg">
                                <div class="text-2xl font-bold text-purple-600">{{ $sentTrades }}</div>
                                <div class="text-xs text-gray-600 dark:text-gray-300">Verzonden handel</div>
                            </div>

                            <div class="text-center p-3 bg-white dark:bg-gray-600 rounded-lg">
                                <div class="text-2xl font-bold text-yellow-600">{{ $receivedTrades }}</div>
                                <div class="text-xs text-gray-600 dark:text-gray-300">Ontvangen handel</div>
                            </div>
                        </div>

                        @if($pendingTrades > 0)
                            <div class="mt-4 p-3 bg-yellow-100 text-yellow-800 rounded-lg">
                                <span class="font-semibold">{{ $pendingTrades }}</span> handelsverzoek(en) in afwachting
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Acties -->
                <div class="mt-6 flex space-x-4">
                    <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Profiel bewerken
                    </a>

                    <a href="{{ route('password.change') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Wachtwoord wijzigen
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
