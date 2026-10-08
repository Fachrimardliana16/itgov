@props(['fy' => null])

@php
    $fy = $fy ?? now()->year;
    $totalPlanned = $totalPlanned ?? 0;
    $totalUsed = $totalUsed ?? 0;
    $remaining = $totalPlanned - $totalUsed;
    $realizedPct = $totalPlanned > 0 ? round($totalUsed / $totalPlanned * 100) : 0;
    $kategoriTotals = $kategoriTotals ?? [];
@endphp

<section class="panel p-5 sm:p-6 mb-6" aria-labelledby="rkap-overview-heading">
    <div class="flex flex-wrap items-end justify-between gap-3 mb-5">
        <div>
            <h2 id="rkap-overview-heading" class="font-display text-lg text-soil-800">Ringkasan RKAP {{ $fy }}</h2>
            <p class="text-sm text-soil-500 mt-1">Total alokasi, realisasi, dan komposisi per kategori belanja.</p>
        </div>
        @if ($totalPlanned > 0)
            <span class="badge {{ $remaining < 0 ? 'badge-red' : 'badge-green' }}">
                {{ $remaining < 0 ? 'Over budget' : 'Dalam pagu' }}
            </span>
        @endif
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
        <div class="stat bg-crop-50" style="--stat-accent: var(--color-crop-500)">
            <p class="stat-value text-crop-700">Rp {{ number_format($totalPlanned, 0, ',', '.') }}</p>
            <p class="stat-label">Total alokasi</p>
        </div>
        <div class="stat bg-honey-50" style="--stat-accent: var(--color-honey-400)">
            <p class="stat-value text-honey-600">Rp {{ number_format($totalUsed, 0, ',', '.') }}</p>
            <p class="stat-label">Total realisasi</p>
        </div>
        <div class="stat {{ $remaining < 0 ? 'bg-ember-50' : 'bg-crop-50' }}" style="--stat-accent: {{ $remaining < 0 ? 'var(--color-ember-400)' : 'var(--color-crop-500)' }}">
            <p class="stat-value {{ $remaining < 0 ? 'text-ember-600' : 'text-crop-700' }}">Rp {{ number_format($remaining, 0, ',', '.') }}</p>
            <p class="stat-label">Sisa anggaran</p>
        </div>
        <div class="stat bg-soil-50" style="--stat-accent: var(--color-soil-400)">
            <p class="stat-value">{{ $realizedPct }}%</p>
            <p class="stat-label">Realisasi</p>
        </div>
    </div>

    @if ($totalPlanned > 0)
        <div class="mt-6 pt-5 border-t border-soil-100 space-y-4">
            @foreach ($kategoriTotals as $kat => $total)
                <div>
                    <div class="flex items-baseline justify-between mb-1.5">
                        <span class="text-xs font-semibold uppercase tracking-wider text-soil-600">{{ $kat }}</span>
                        <span class="text-xs font-mono text-soil-500">
                            Rp {{ number_format($total, 0, ',', '.') }} · {{ $totalPlanned > 0 ? round($total / $totalPlanned * 100) : 0 }}%
                        </span>
                    </div>
                    <div class="rail"><div class="rail-fill bg-honey-400" style="width: {{ $totalPlanned > 0 ? round($total / $totalPlanned * 100) : 0 }}%"></div></div>
                </div>
            @endforeach
        </div>
    @else
        <p class="mt-6 pt-5 border-t border-soil-100 text-sm text-soil-500 text-center">
            Belum ada rencana RKAP untuk tahun {{ $fy }}.
        </p>
    @endif
</section>