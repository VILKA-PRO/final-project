<x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
    {{ __('Панель управления') }}
</x-nav-link>