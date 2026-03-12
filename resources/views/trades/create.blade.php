@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h1 class="text-2xl font-bold mb-6">Nieuw handelsvoorstel</h1>

            <form method="POST" action="{{ route('trades.store') }}">
                @csrf

                <div class="mb-4">
                    <label for="receiver_id" class="block text-sm font-medium">Ontvanger</label>
                    <select name="receiver_id" id="receiver_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Kies een speler</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('receiver_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                    @error('receiver_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <h2 class="text-lg font-semibold mb-2">Jouw aangeboden items</h2>
                <div id="offered-items" class="space-y-2 mb-4">
                    <div class="flex items-center space-x-2">
                        <select name="offered_items[0][item_id]" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Kies item</option>
                            @foreach($myItems as $inv)
                                <option value="{{ $inv->item_id }}">{{ $inv->item->name }} ({{ $inv->quantity }} beschikbaar)</option>
                            @endforeach
                        </select>
                        <input type="number" name="offered_items[0][quantity]" placeholder="Aantal" min="1" class="w-24 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <button type="button" onclick="this.parentElement.remove()" class="text-red-600">Verwijder</button>
                    </div>
                </div>
                <button type="button" onclick="addOfferedItem()" class="text-indigo-600 text-sm mb-6">+ Nog een item toevoegen</button>

                <h2 class="text-lg font-semibold mb-2">Gevraagde items (optioneel)</h2>
                <div id="requested-items" class="space-y-2 mb-4">
                    <div class="flex items-center space-x-2">
                        <select name="requested_items[0][item_id]" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Kies item</option>
                            @foreach($allItems as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        <input type="number" name="requested_items[0][quantity]" placeholder="Aantal" min="1" class="w-24 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <button type="button" onclick="this.parentElement.remove()" class="text-red-600">Verwijder</button>
                    </div>
                </div>
                <button type="button" onclick="addRequestedItem()" class="text-indigo-600 text-sm mb-6">+ Nog een item toevoegen</button>

                <div class="flex justify-end">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500">
                        Verstuur voorstel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let offeredIndex = 1;
let requestedIndex = 1;

function addOfferedItem() {
    const container = document.getElementById('offered-items');
    const div = document.createElement('div');
    div.className = 'flex items-center space-x-2';
    div.innerHTML = `
        <select name="offered_items[${offeredIndex}][item_id]" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            <option value="">Kies item</option>
            @foreach($myItems as $inv)
                <option value="{{ $inv->item_id }}">{{ $inv->item->name }} ({{ $inv->quantity }} beschikbaar)</option>
            @endforeach
        </select>
        <input type="number" name="offered_items[${offeredIndex}][quantity]" placeholder="Aantal" min="1" class="w-24 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        <button type="button" onclick="this.parentElement.remove()" class="text-red-600">Verwijder</button>
    `;
    container.appendChild(div);
    offeredIndex++;
}

function addRequestedItem() {
    const container = document.getElementById('requested-items');
    const div = document.createElement('div');
    div.className = 'flex items-center space-x-2';
    div.innerHTML = `
        <select name="requested_items[${requestedIndex}][item_id]" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            <option value="">Kies item</option>
            @foreach($allItems as $item)
                <option value="{{ $item->id }}">{{ $item->name }}</option>
            @endforeach
        </select>
        <input type="number" name="requested_items[${requestedIndex}][quantity]" placeholder="Aantal" min="1" class="w-24 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        <button type="button" onclick="this.parentElement.remove()" class="text-red-600">Verwijder</button>
    `;
    container.appendChild(div);
    requestedIndex++;
}
</script>
@endsection
