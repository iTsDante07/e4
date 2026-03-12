@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-bold">Inventaris van {{ $user->name }}</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">{{ $user->email }} |
                        @if($user->role == 'admin')
                            <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded-full text-xs">Beheerder</span>
                        @else
                            <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">Speler</span>
                        @endif
                    </p>
                </div>
                <div>
                    <a href="{{ route('admin.users.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                        Terug naar Gebruikers
                    </a>
                    <a href="{{ route('admin.assign-item.form', ['user_id' => $user->id]) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Item Toekennen
                    </a>
                </div>
            </div>

            <!-- Statistieken -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-blue-100 dark:bg-blue-900 p-4 rounded-lg">
                    <h3 class="font-semibold text-lg">Totaal Items</h3>
                    <p class="text-3xl font-bold">{{ $totalItems }}</p>
                </div>

                <div class="bg-green-100 dark:bg-green-900 p-4 rounded-lg">
                    <h3 class="font-semibold text-lg">Unieke Items</h3>
                    <p class="text-3xl font-bold">{{ $uniqueItems }}</p>
                </div>

                <div class="bg-purple-100 dark:bg-purple-900 p-4 rounded-lg">
                    <h3 class="font-semibold text-lg">Totaal Waarde</h3>
                    <p class="text-3xl font-bold">{{ $inventory->sum(function($inv) {
                        return $inv->quantity * ($inv->item->power + $inv->item->magic);
                    }) }}</p>
                </div>
            </div>

            <!-- Items per type -->
            @foreach($groupedItems as $type => $items)
                <div class="mb-6">
                    <h2 class="text-xl font-semibold mb-3 capitalize">{{ $type }} ({{ $items->sum('quantity') }} items)</h2>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Item</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Zeldzaamheid</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aantal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stats</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acties</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200">
                                @foreach($items as $inv)
                                    <tr>
                                        <td class="px-6 py-4">
                                            <div class="font-medium">{{ $inv->item->name }}</div>
                                            <div class="text-sm text-gray-500">Level {{ $inv->item->required_level }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($inv->item->rarity == 'gewoon')
                                                <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs">Gewoon</span>
                                            @elseif($inv->item->rarity == 'zeldzaam')
                                                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">Zeldzaam</span>
                                            @elseif($inv->item->rarity == 'episch')
                                                <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded-full text-xs">Episch</span>
                                            @else
                                                <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">Legendarisch</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <form action="{{ route('admin.assign-item.update', $inv->id) }}" method="POST" class="flex items-center space-x-2">
                                                @csrf
                                                @method('PUT')
                                                <input type="number" name="quantity" value="{{ $inv->quantity }}" min="0" class="w-20 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                <button type="submit" class="text-green-600 hover:text-green-900 text-sm">Update</button>
                                            </form>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-xs space-y-1">
                                                <span class="block">Kracht: {{ $inv->item->power }}</span>
                                                <span class="block">Snelheid: {{ $inv->item->speed }}</span>
                                                <span class="block">Duurzaam: {{ $inv->item->durability }}</span>
                                                <span class="block">Magie: {{ $inv->item->magic }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <form action="{{ route('admin.assign-item.destroy', $inv->id) }}" method="POST" class="inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Weet je zeker dat je dit item wilt verwijderen?')">
                                                    Verwijder
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach

            @if($inventory->isEmpty())
                <div class="text-center py-8">
                    <p class="text-gray-500">Deze speler heeft nog geen items in zijn inventaris.</p>
                    <a href="{{ route('admin.assign-item.form', ['user_id' => $user->id]) }}" class="inline-block mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Item Toekennen
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
