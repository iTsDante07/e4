@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h1 class="text-2xl font-bold mb-6">Wachtwoord Wijzigen</h1>

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Huidig wachtwoord</label>
                        <input type="password" name="current_password" id="current_password" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        @error('current_password')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="new_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nieuw wachtwoord</label>
                        <input type="password" name="new_password" id="new_password" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        @error('new_password')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Bevestig nieuw wachtwoord</label>
                        <input type="password" name="new_password_confirmation" id="new_password_confirmation" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>

                    <div class="flex items-center space-x-4">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Wachtwoord wijzigen
                        </button>

                        <a href="{{ route('profile') }}" class="text-sm text-gray-600 hover:text-gray-900">Annuleren</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
