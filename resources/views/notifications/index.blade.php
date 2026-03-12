@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h1 class="text-2xl font-bold mb-6">Notificaties</h1>

            @forelse($notifications as $notification)
                <div class="border rounded-lg p-4 mb-3 {{ $notification->read_at ? 'bg-gray-50 dark:bg-gray-700' : 'bg-blue-50 dark:bg-blue-900' }}">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <p class="font-medium">{{ $notification->data['message'] ?? 'Bericht' }}</p>

                            @if(isset($notification->data['type']))
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                    @switch($notification->data['type'])
                                        @case('trade_proposed')
                                            Van: {{ $notification->data['sender_name'] ?? 'Onbekend' }}
                                            @break
                                        @case('trade_accepted')
                                            Geaccepteerd door: {{ $notification->data['accepted_by'] ?? 'Onbekend' }}
                                            @break
                                        @case('trade_declined')
                                            Geweigerd door: {{ $notification->data['declined_by'] ?? 'Onbekend' }}
                                            @break
                                    @endswitch
                                </p>
                            @endif

                            <p class="text-xs text-gray-500 mt-2">{{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</p>
                        </div>

                        @if(!$notification->read_at)
                            <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-indigo-600 hover:text-indigo-900 text-sm ml-4">
                                    Markeer als gelezen
                                </button>
                            </form>
                        @endif
                    </div>

                    @if(isset($notification->data['trade_id']))
                        <div class="mt-2">
                            <a href="{{ route('trades.show', $notification->data['trade_id']) }}" class="text-indigo-600 hover:text-indigo-900 text-sm inline-flex items-center">
                                Bekijk handelsverzoek →
                            </a>
                        </div>
                    @endif
                </div>
            @empty
                <p class="text-gray-500">Geen notificaties.</p>
            @endforelse

            <div class="mt-4">
                {{ $notifications->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
