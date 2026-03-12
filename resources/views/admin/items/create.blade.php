@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h1 class="text-2xl font-bold mb-6">Nieuw Item Aanmaken</h1>

            <form method="POST" action="{{ route('admin.items.store') }}">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Linker kolom -->
                    <div>
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium">Naam</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="type" class="block text-sm font-medium">Type</label>
                            <select name="type" id="type" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="wapen">Wapen</option>
                                <option value="pantser">Pantser</option>
                                <option value="accessoire">Accessoire</option>
                                <option value="overig">Overig</option>
                            </select>
                            @error('type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="rarity" class="block text-sm font-medium">Zeldzaamheid</label>
                            <select name="rarity" id="rarity" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="gewoon">Gewoon</option>
                                <option value="zeldzaam">Zeldzaam</option>
                                <option value="episch">Episch</option>
                                <option value="legendarisch">Legendarisch</option>
                            </select>
                            @error('rarity') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="required_level" class="block text-sm font-medium">Vereist Level (1-100)</label>
                            <input type="number" name="required_level" id="required_level" value="{{ old('required_level', 1) }}" min="1" max="100" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('required_level') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Rechter kolom - Statistieken -->
                    <div>
                        <div class="mb-4">
                            <label for="power" class="block text-sm font-medium">Kracht (0-100)</label>
                            <input type="number" name="power" id="power" value="{{ old('power', 0) }}" min="0" max="100" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('power') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="speed" class="block text-sm font-medium">Snelheid (0-100)</label>
                            <input type="number" name="speed" id="speed" value="{{ old('speed', 0) }}" min="0" max="100" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('speed') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="durability" class="block text-sm font-medium">Duurzaamheid (0-100)</label>
                            <input type="number" name="durability" id="durability" value="{{ old('durability', 0) }}" min="0" max="100" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('durability') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="magic" class="block text-sm font-medium">Magie (0-100)</label>
                            <input type="number" name="magic" id="magic" value="{{ old('magic', 0) }}" min="0" max="100" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('magic') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium">Beschrijving</label>
                    <textarea name="description" id="description" rows="4" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
                    @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-end space-x-2">
                    <a href="{{ route('admin.items.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                        Annuleren
                    </a>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Item Aanmaken
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
