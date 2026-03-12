@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h1 class="text-2xl font-bold mb-6">Mijn inventaris</h1>

            <!-- Sorteerformulier -->
            <form method="GET" class="mb-4 flex items-center space-x-2">
                <label for="sort" class="text-sm">Sorteren op:</label>
                <select name="sort" id="sort" onchange="this.form.submit()" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Standaard</option>
                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Naam</option>
                    <option value="type" {{ request('sort') == 'type' ? 'selected' : '' }}>Type</option>
                    <option value="rarity" {{ request('sort') == 'rarity' ? 'selected' : '' }}>Zeldzaamheid</option>
                    <option value="quantity" {{ request('sort') == 'quantity' ? 'selected' : '' }}>Hoeveelheid</option>
                </select>
                <noscript><button type="submit" class="btn">Sorteren</button></noscript>
            </form>

            <!-- Lijst -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Zeldzaamheid</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hoeveelheid</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acties</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($inventory as $entry)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('items.show', $entry->item) }}" class="text-indigo-600 hover:text-indigo-900">{{ $entry->item->name }}</a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($entry->item->type) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($entry->item->rarity) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $entry->quantity }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('trades.create', ['item_id' => $entry->item_id]) }}" class="text-indigo-600 hover:text-indigo-900">Verhandelen</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">Je hebt nog geen items in je inventaris.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $inventory->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
