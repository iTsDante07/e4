@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h1 class="text-3xl font-bold mb-4">Welkom bij DreamScape Interactive</h1>
                <p class="mb-4">Beheer je virtuele items, handel met andere spelers en ontdek een wereld vol mogelijkheden.</p>

                @guest
                    <div class="mt-6">
                        <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Registreer nu
                        </a>
                        <a href="{{ route('login') }}" class="ml-4 inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 focus:bg-gray-500 active:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Inloggen
                        </a>
                    </div>
                @else
                    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="{{ route('items.index') }}" class="block p-4 bg-blue-100 rounded-lg hover:bg-blue-200">
                            <h2 class="font-semibold text-lg">Itemcatalogus</h2>
                            <p>Bekijk alle beschikbare items</p>
                        </a>
                        <a href="{{ route('inventory.index') }}" class="block p-4 bg-green-100 rounded-lg hover:bg-green-200">
                            <h2 class="font-semibold text-lg">Mijn inventaris</h2>
                            <p>Beheer je verzameling</p>
                        </a>
                        <a href="{{ route('trades.index') }}" class="block p-4 bg-purple-100 rounded-lg hover:bg-purple-200">
                            <h2 class="font-semibold text-lg">Handel</h2>
                            <p>Bekijk en verstuur handelsverzoeken</p>
                        </a>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</div>
@endsection
