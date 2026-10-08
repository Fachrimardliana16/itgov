<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — {{ config('app.name', 'IT Governance Center') }}</title>
    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="bg-soil-50 text-ink font-sans antialiased min-h-screen">

@auth
    {{-- Desktop sidebar --}}
    <aside class="hidden lg:flex fixed inset-y-0 left-0 w-64 flex-col bg-soil-900 text-soil-100 z-30">
        <div class="px-6 py-6 border-b border-soil-800">
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <span class="w-9 h-9 grid place-items-center rounded-lg bg-crop-600 text-white font-display text-lg shadow-inner shrink-0">✦</span>
                <span class="leading-tight">
                    <span class="block font-display text-sm tracking-tight text-parchment">IT GOVERNANCE</span>
                    <span class="block text-[0.6875rem] uppercase tracking-widest text-soil-400">Center</span>
                </span>
            </a>
        </div>

        <nav class="flex-1 px-3 py-5 space-y-1 overflow-y-auto">
            @php
                $nav = [
                    ['route' => 'home',       'label' => 'Dashboard', 'glyph' => '⌂'],
                    ['route' => 'sops.index', 'label' => 'SOP',       'glyph' => '▤'],
                    ['route' => 'vault.index','label' => 'Vault',     'glyph' => '⚿'],
                    ['route' => 'rkap.index', 'label' => 'RKAP',      'glyph' => '▣'],
                    ['route' => 'inventaris.index', 'label' => 'Inventaris', 'glyph' => '▦'],
                    ['route' => 'tools.index', 'label' => 'Tools',    'glyph' => '⚒'],
                ];
            @endphp
            @foreach ($nav as $item)
                <a href="{{ route($item['route']) }}"
                   @if (request()->routeIs($item['route'])) aria-current="page" @endif
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-colors
                          {{ request()->routeIs($item['route'])
                                ? 'bg-crop-600 text-white font-medium shadow-sm'
                                : 'text-soil-300 hover:bg-soil-800 hover:text-parchment' }}">
                    <span class="w-4 text-center opacity-80" aria-hidden="true">{{ $item['glyph'] }}</span>
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>

        <div class="px-3 py-4 border-t border-soil-800">
            <div class="px-3 pb-3">
                <p class="text-sm text-parchment font-medium truncate">{{ auth()->user()->name }}</p>
                <p class="text-xs text-soil-400 truncate">{{ auth()->user()->email }}</p>
                <span class="mt-2 inline-flex badge {{ auth()->user()->isAdmin() ? 'bg-honey-300 text-soil-900' : 'bg-soil-700 text-soil-200' }}">
                    {{ auth()->user()->isAdmin() ? 'Administrator' : 'Staff' }}
                </span>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full btn-quiet !bg-soil-800 !border-soil-700 !text-soil-200 hover:!bg-soil-700">
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    {{-- Mobile top bar --}}
    <header class="lg:hidden sticky top-0 z-30 bg-soil-900 text-soil-100">
        <div class="flex items-center justify-between px-4 h-14">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <span class="w-7 h-7 grid place-items-center rounded-md bg-crop-600 text-white font-display">✦</span>
                <span class="font-display text-sm">IT GOVERNANCE</span>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-xs text-soil-300 hover:text-parchment">Keluar</button>
            </form>
        </div>
        <nav class="flex overflow-x-auto border-t border-soil-800 text-sm">
            @foreach ($nav as $item)
                <a href="{{ route($item['route']) }}"
                   class="shrink-0 grow whitespace-nowrap px-4 py-2.5 text-center transition-colors
                          {{ request()->routeIs($item['route'])
                                ? 'bg-crop-600 text-white font-medium'
                                : 'text-soil-300' }}">
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>
    </header>
@endauth

<main class="{{ auth()->check() ? 'lg:pl-64' : '' }}">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @include('layouts.flash')

        @yield('content')
    </div>
</main>

</body>
</html>