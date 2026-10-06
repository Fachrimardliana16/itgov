@props(['fy' => null])

@php
$fy = $fy ?? now()->year;
$totalPlanned = $totalPlanned ?? 0;
$totalUsed = $totalUsed ?? 0;
$remaining = $totalPlanned - $totalUsed;
$capexPct = $totalPlanned > 0 ? round(($capexTotal ?? 0) / $totalPlanned * 100) : 0;
$opexPct  = $totalPlanned > 0 ? round(($opexTotal ?? 0) / $totalPlanned * 100) : 0;
@endphp

<div class="bg-white rounded-lg shadow p-6 mb-6">
    <h3 class="text-lg font-semibold mb-4">📊 Budget Overview {{ $fy }}</h3>

    <div class="grid grid-cols-4 gap-6 text-center mb-6">
        <div>
            <p class="text-2xl font-bold text-blue-600">Rp {{ number_format($totalPlanned, 0, ',', '.') }}</p>
            <p class="text-xs text-gray-500">Total Alokasi</p>
        </div>
        <div>
            <p class="text-2xl font-bold text-orange-600">Rp {{ number_format($totalUsed, 0, ',', '.') }}</p>
            <p class="text-xs text-gray-500">Total Terpakai</p>
        </div>
        <div>
            <p class="text-2xl font-bold {{ $remaining < 0 ? 'text-red-600' : 'text-green-600' }}">
                Rp {{ number_format($remaining, 0, ',', '.') }}
            </p>
            <p class="text-xs text-gray-500">Sisa</p>
        </div>
        <div>
            <p class="text-2xl font-bold text-gray-600">
                {{ $totalPlanned > 0 ? round(($totalUsed / $totalPlanned) * 100) : 0 }}%
            </p>
            <p class="text-xs text-gray-500">Realisasi</p>
        </div>
    </div>

    @if($totalPlanned > 0)
    <div class="space-y-3">
        <div class="flex items-center gap-3">
            <span class="text-xs font-mono w-12 text-gray-600">CAPEX</span>
            <div class="flex-1 bg-gray-200 rounded-full h-3">
                <div class="bg-blue-500 h-3 rounded-full transition-all" style="width: {{ $capexPct }}%"></div>
            </div>
            <span class="text-xs font-mono w-10 text-right">{{ $capexPct }}%</span>
            <span class="text-xs text-gray-500">Rp {{ number_format($capexTotal ?? 0, 0, ',', '.') }}</span>
        </div>
        <div class="flex items-center gap-3">
            <span class="text-xs font-mono w-12 text-gray-600">OPEX</span>
            <div class="flex-1 bg-gray-200 rounded-full h-3">
                <div class="bg-green-500 h-3 rounded-full transition-all" style="width: {{ $opexPct }}%"></div>
            </div>
            <span class="text-xs font-mono w-10 text-right">{{ $opexPct }}%</span>
            <span class="text-xs text-gray-500">Rp {{ number_format($opexTotal ?? 0, 0, ',', '.') }}</span>
        </div>
    </div>
    @endif
</div>