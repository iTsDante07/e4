@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">Item Beheer</h1>
                <a href="{{ route('admin.items.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Nieuw Item
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Naam</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Zeldzaamheid</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Level</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stats</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acties</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                        <tr>
                            <td class="px-6 py-4">{{ $item->name }}</td>
                            <td class="px-6 py-4">{{ ucfirst($item->type) }}</td>
                            <td class="px-6 py-4">
                                @if($item->rarity == 'gewoon')
                                    <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs">Gewoon</span>
                                @elseif($item->rarity == 'zeldzaam')
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">Zeldzaam</span>
                                @elseif($item->rarity == 'episch')
                                    <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded-full text-xs">Episch</span>
                                @else
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">Legendarisch</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">{{ $item->required_level }}</td>
                            <td class="px-6 py-4">
                                <div class="text-xs">
                                    <span>Kracht: {{ $item->power }}</span><br>
                                    <span>Snelheid: {{ $item->speed }}</span><br>
                                    <span>Duurzaam: {{ $item->durability }}</span><br>
                                    <span>Magie: {{ $item->magic }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.items.edit', $item) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">Bewerk</a>
                                <form action="{{ route('admin.items.destroy', $item) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Weet je zeker dat je dit item wilt verwijderen?')">Verwijder</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $items->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
