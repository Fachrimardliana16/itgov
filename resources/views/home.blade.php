@extends('layouts.app')

@section('title', 'Dashboard')

@php
    $fy = now()->year;
    $total = \App\Models\RkapPlan::where('fiscal_year', $fy)->sum('planned_amount');
    $used  = \App\Models\RkapPlan::where('fiscal_year', $fy)->sum('used_amount');
    $capex = \App\Models\RkapPlan::where('fiscal_year', $fy)->where('kategori', 'Belanja Modal')->sum('planned_amount');
    $opex  = $total - $capex;
    $sopCount   = \App\Models\Sop::count();
    $credCount  = \App\Models\Credential::count();
    $realized   = $total > 0 ? round($used / $total * 100) : 0;
    $greeting   = auth()->check()
        ? 'Halo, ' . auth()->user()->name
        : 'Selamat datang, Peternak';
    $tagline    = auth()->check()
        ? 'Desa governance Anda tertata. Seluruh modul menunggu tanda tangan Anda.'
        : 'Masuk untuk membuka perpustakaan SOP, gudang kredensial, dan lumbung anggaran.';
@endphp

@section('content')

{{-- ============================ Header ============================ --}}
<div class="mb-7 flex flex-wrap items-end justify-between gap-4">
    <div>
        <p class="text-xs uppercase tracking-widest text-soil-400 mb-1">Tahun fiskal {{ $fy }}</p>
        <h1 class="page-title text-3xl">{{ $greeting }}</h1>
        <p class="page-subtitle">{{ $tagline }}</p>
    </div>
    @auth
        <a href="{{ route('sops.create') }}" class="btn-primary">+ Tulis SOP Baru</a>
    @else
        <a href="{{ route('login') }}" class="btn-primary">Masuk</a>
    @endauth
</div>

{{-- ============================ The village ============================ --}}
<section class="relative overflow-hidden rounded-2xl village-sky border border-soil-200 shadow-[0_18px_40px_-24px_rgba(58,44,34,0.45)]"
         aria-labelledby="village-heading">
    <h2 id="village-heading" class="sr-only">Peta desa — tiga bangunan modul</h2>

    {{-- Sun (pure CSS radial gradient, defined in app.css) --}}
    <span class="pointer-events-none absolute top-6 right-10 w-20 h-20 rounded-full"
          style="background: radial-gradient(circle, #ffe9a8 0 45%, rgba(255,233,168,0.5) 45% 70%, transparent 70%)"
          aria-hidden="true"></span>

    {{-- Clouds --}}
    <span class="pointer-events-none absolute top-10 left-[12%] flex gap-2 opacity-80 village-drift" aria-hidden="true">
        <span class="block h-3 w-10 bg-white/85 rounded-sm"></span>
        <span class="block h-5 w-14 bg-white/85 rounded-sm"></span>
    </span>
    <span class="pointer-events-none absolute top-24 left-[58%] flex gap-2 opacity-60 village-drift" style="animation-delay:-4s" aria-hidden="true">
        <span class="block h-3 w-8 bg-white/70 rounded-sm"></span>
        <span class="block h-4 w-12 bg-white/70 rounded-sm"></span>
    </span>

    {{-- Far treeline --}}
    <span class="pointer-events-none absolute inset-x-0 bottom-24 h-8 opacity-30"
          style="background: repeating-linear-gradient(90deg, #2f4f1f 0 18px, transparent 18px 40px);
                 clip-path: polygon(0 100%, 6% 20%, 12% 100%, 22% 30%, 30% 100%, 44% 15%, 52% 100%, 64% 25%, 72% 100%, 84% 18%, 92% 100%, 100% 100%)"
          aria-hidden="true"></span>

    {{-- Buildings: the three modules --}}
    <div class="relative px-4 sm:px-8 pt-14 pb-0">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 sm:gap-7">

            {{-- Perpustakaan — SOP --}}
            <a href="{{ route('sops.index') }}" class="building village-sway block px-5 py-4 min-h-[9.5rem]"
               style="background: linear-gradient(180deg, #c6e3a1, #a7d46a); --shade: #517c24;">
                <span class="absolute inset-x-3 top-0 h-3 rounded-sm bg-soil-700/85" aria-hidden="true"></span>
                <span class="absolute top-6 left-5 w-5 h-5 rounded-sm bg-soil-900/70"
                      style="box-shadow: 26px 0 0 -2px rgba(38,28,22,0.55), 0 0 0 2px rgba(253,248,239,0.55)" aria-hidden="true"></span>
                <span class="absolute top-6 right-5 w-7 h-7 rounded-sm bg-sky-100 border-2 border-soil-800/70" style="background-image: linear-gradient(var(--color-soil-800) 0 0), linear-gradient(var(--color-soil-800) 0 0); background-size: 2px 100%, 100% 2px; background-position: center; background-repeat: no-repeat;" aria-hidden="true"></span>
                <div class="relative mt-2">
                    <p class="font-display text-xs uppercase tracking-widest text-crop-900/70">Perpustakaan</p>
                    <h3 class="font-display text-lg text-soil-900 mt-1">Dokumentasi SOP</h3>
                    <p class="text-sm text-crop-900/80 mt-1.5 leading-snug">
                        {{ $sopCount }} prosedur tertata, siap ditatauri auditor.
                    </p>
                </div>
            </a>

            {{-- Gudang — Vault --}}
            <a href="{{ route('vault.index') }}" class="building block px-5 py-4 min-h-[9.5rem]"
               style="background: linear-gradient(180deg, #fadedb, #e07a5f); --shade: #a33529;">
                <span class="absolute inset-x-3 top-0 h-3 rounded-sm bg-soil-700/85" aria-hidden="true"></span>
                <span class="absolute top-6 left-5 w-5 h-5 rounded-sm bg-soil-900/70"
                      style="box-shadow: 26px 0 0 -2px rgba(38,28,22,0.55), 0 0 0 2px rgba(253,248,239,0.55)" aria-hidden="true"></span>
                <span class="absolute top-6 right-5 w-7 h-7 rounded-sm bg-sky-100 border-2 border-soil-800/70" style="background-image: linear-gradient(var(--color-soil-800) 0 0), linear-gradient(var(--color-soil-800) 0 0); background-size: 2px 100%, 100% 2px; background-position: center; background-repeat: no-repeat;" aria-hidden="true"></span>
                <div class="relative mt-2">
                    <p class="font-display text-xs uppercase tracking-widest text-ember-700/70">Gudang Tertua</p>
                    <h3 class="font-display text-lg text-soil-900 mt-1">Credential Vault</h3>
                    <p class="text-sm text-ember-700/85 mt-1.5 leading-snug">
                        {{ $credCount }} peti kunci terenkripsi AES-256-GCM.
                    </p>
                </div>
            </a>

            {{-- Lumbung — RKAP --}}
            <a href="{{ route('rkap.index') }}" class="building block px-5 py-4 min-h-[9.5rem]"
               style="background: linear-gradient(180deg, #ffe9a8, #f2c14e); --shade: #b8861f;">
                <span class="absolute inset-x-3 top-0 h-3 rounded-sm bg-soil-700/85" aria-hidden="true"></span>
                <span class="absolute top-6 left-5 w-5 h-5 rounded-sm bg-soil-900/70"
                      style="box-shadow: 26px 0 0 -2px rgba(38,28,22,0.55), 0 0 0 2px rgba(253,248,239,0.55)" aria-hidden="true"></span>
                <span class="absolute top-6 right-5 w-7 h-7 rounded-sm bg-sky-100 border-2 border-soil-800/70" style="background-image: linear-gradient(var(--color-soil-800) 0 0), linear-gradient(var(--color-soil-800) 0 0); background-size: 2px 100%, 100% 2px; background-position: center; background-repeat: no-repeat;" aria-hidden="true"></span>
                <div class="relative mt-2">
                    <p class="font-display text-xs uppercase tracking-widest text-honey-700">Lumbung Panen</p>
                    <h3 class="font-display text-lg text-soil-900 mt-1">RKAP Planner</h3>
                    <p class="text-sm text-honey-700 mt-1.5 leading-snug">
                        Rp {{ number_format($total, 0, ',', '.') }} dialokasikan tahun ini.
                    </p>
                </div>
            </a>

        </div>
    </div>

    {{-- Terrain --}}
    <div class="relative mt-6 village-ground px-4 sm:px-8 py-5 border-t-4 border-crop-800/30">
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-center">
            <div>
                <p class="font-display text-sm text-soil-900">Langit cerah</p>
                <p class="text-[0.6875rem] uppercase tracking-wider text-crop-900/70 mt-0.5">Cuaca governance</p>
            </div>
            <div>
                <p class="font-display text-sm text-soil-900">{{ $sopCount }} tanaman</p>
                <p class="text-[0.6875rem] uppercase tracking-wider text-crop-900/70 mt-0.5">SOP tumbuh</p>
            </div>
            <div>
                <p class="font-display text-sm text-soil-900">{{ $credCount }} peti</p>
                <p class="text-[0.6875rem] uppercase tracking-wider text-crop-900/70 mt-0.5">Kredensial aman</p>
            </div>
            <div>
                <p class="font-display text-sm text-soil-900">{{ $realized }}% terealisasi</p>
                <p class="text-[0.6875rem] uppercase tracking-wider text-crop-900/70 mt-0.5">Realisasi RKAP</p>
            </div>
        </div>
    </div>
</section>

{{-- ============================ Harvest progress ============================ --}}
<section class="panel mt-6 p-5 sm:p-6" aria-labelledby="harvest-heading">
    <div class="flex flex-wrap items-end justify-between gap-3 mb-5">
        <div>
            <h2 id="harvest-heading" class="font-display text-lg text-soil-800">Panen Tahun {{ $fy }}</h2>
            <p class="text-sm text-soil-500 mt-1">Rincian alokasi belanja modal dan operasional beserta realisasinya.</p>
        </div>
        <a href="{{ route('rkap.index') }}" class="action-link">Lihat semua rencana →</a>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="stat bg-crop-50" style="--stat-accent: var(--color-crop-500)">
            <p class="stat-value text-crop-700">Rp {{ number_format($total, 0, ',', '.') }}</p>
            <p class="stat-label">Total alokasi</p>
        </div>
        <div class="stat bg-honey-50" style="--stat-accent: var(--color-honey-400)">
            <p class="stat-value text-honey-600">Rp {{ number_format($used, 0, ',', '.') }}</p>
            <p class="stat-label">Terpakai</p>
        </div>
        <div class="stat {{ ($total - $used) < 0 ? 'bg-ember-50' : 'bg-crop-50' }}" style="--stat-accent: {{ ($total - $used) < 0 ? 'var(--color-ember-400)' : 'var(--color-crop-500)' }}">
            <p class="stat-value {{ ($total - $used) < 0 ? 'text-ember-600' : 'text-crop-700' }}">
                Rp {{ number_format($total - $used, 0, ',', '.') }}
            </p>
            <p class="stat-label">Sisa</p>
        </div>
        <div class="stat bg-soil-50" style="--stat-accent: var(--color-soil-400)">
            <p class="stat-value">{{ $realized }}%</p>
            <p class="stat-label">Realisasi</p>
        </div>
    </div>

    @if ($total > 0)
        <div class="space-y-4">
            <div>
                <div class="flex items-baseline justify-between mb-1.5">
                    <span class="text-xs font-semibold uppercase tracking-wider text-soil-600">Belanja Modal</span>
                    <span class="text-xs font-mono text-soil-500">
                        Rp {{ number_format($capex, 0, ',', '.') }} · {{ round($capex / $total * 100) }}%
                    </span>
                </div>
                <div class="rail"><div class="rail-fill bg-crop-500" style="width: {{ $capex / $total * 100 }}%"></div></div>
            </div>
            <div>
                <div class="flex items-baseline justify-between mb-1.5">
                    <span class="text-xs font-semibold uppercase tracking-wider text-soil-600">Operasional</span>
                    <span class="text-xs font-mono text-soil-500">
                        Rp {{ number_format($opex, 0, ',', '.') }} · {{ round($opex / $total * 100) }}%
                    </span>
                </div>
                <div class="rail"><div class="rail-fill bg-honey-400" style="width: {{ $opex / $total * 100 }}%"></div></div>
            </div>
        </div>
    @else
        <p class="text-sm text-soil-500 py-4 text-center">
            Belum ada rencana RKAP tahun {{ $fy }}. Mulai dari
            <a href="{{ route('rkap.create') }}" class="text-crop-700 font-medium hover:underline">rencana pertama</a>.
        </p>
    @endif
</section>

@endsection