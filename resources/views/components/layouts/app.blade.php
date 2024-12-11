<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title.' - '.config('app.name') : config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen font-sans antialiased bg-base-200/50 dark:bg-base-200">

{{-- NAVBAR mobile only --}}
<x-nav sticky class="lg:hidden">
    <x-slot:brand>
        <x-app-brand/>
    </x-slot:brand>
    <x-slot:actions>
        <label for="main-drawer" class="lg:hidden me-3">
            <x-icon name="o-bars-3" class="cursor-pointer"/>
        </label>
    </x-slot:actions>
</x-nav>

{{-- MAIN --}}
<x-main full-width>
    {{-- SIDEBAR --}}
    <x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-100 lg:bg-inherit">

        {{-- BRAND --}}
        <x-app-brand class="p-5 pt-3"/>

        {{-- MENU --}}
        <x-menu>
            {{-- User --}}
            @if($user = auth()->user())
                <x-menu-separator/>

                <x-list-item :item="$user" value="name" sub-value="nickname" no-separator no-hover
                             class="-mx-2 !-my-2 rounded">

                    <x-slot:actions>
                        <x-button icon="o-power" class="btn-circle btn-ghost btn-xs" tooltip-left="logoff"
                                  no-wire-navigate link="/logout"/>
                    </x-slot:actions>
                </x-list-item>

                <x-menu-separator/>
            @endif

            <div class="opacity-90">
                <x-menu-sub title="Campaigns" icon="fas.paper-plane">
                    <x-menu-item title="Campaigns" icon="fas.paper-plane" link="/campaigns"/>
                    <x-menu-item title="Stats" icon="fas.chart-simple" link="/campaigns/stats"/>
                </x-menu-sub>


                <x-menu-item title="Lists" icon="fas.address-book" link="/lists"/>
                <x-menu-item title="Templates" icon="fas.paint-roller" link="/templates"/>
                <x-menu-item title="Blacklists" icon="fas.ghost" link="/blacklists"/>
                <x-menu-item title="Profiles" icon="fas.screwdriver-wrench" link="/profiles"/>
                <x-menu-sub title="Users" icon="fas.paper-plane">
                     <x-menu-item title="Users" icon="fas.users" link="/users"/>
                    <x-menu-item title="Greeting" icon="fas.hand-sparkles" link="/greeting/{{auth()->id()}}"/>
                </x-menu-sub>
                <x-menu-item title="Plans" icon="fas.money-check" link="/plans"/>
            </div>

        </x-menu>
    </x-slot:sidebar>

    {{-- The `$slot` goes here --}}
    <x-slot:content>
        {{ $slot }}
    </x-slot:content>
</x-main>

{{--  TOAST area --}}
<x-toast/>
</body>
</html>
