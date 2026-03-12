<!-- Navigation Links -->
<div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
    <x-nav-link :href="route('items.index')" :active="request()->routeIs('items.*')">
        {{ __('Catalogus') }}
    </x-nav-link>
    <x-nav-link :href="route('inventory.index')" :active="request()->routeIs('inventory.*')">
        {{ __('Mijn Inventaris') }}
    </x-nav-link>
    <x-nav-link :href="route('trades.index')" :active="request()->routeIs('trades.*')">
        {{ __('Handel') }}
    </x-nav-link>
    <x-nav-link :href="route('notifications.index')" :active="request()->routeIs('notifications.*')">
        {{ __('Notificaties') }}
        @if(auth()->user()->unreadNotifications->count())
            <span class="ml-1 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                {{ auth()->user()->unreadNotifications->count() }}
            </span>
        @endif
    </x-nav-link>
</div>

@if(auth()->user()->role === 'admin')
<div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
    <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.*')">
        {{ __('Beheer') }}
    </x-nav-link>
</div>
@endif
