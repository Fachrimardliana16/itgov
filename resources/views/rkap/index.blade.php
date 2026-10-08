@extends('layouts.app')

@section('title', 'RKAP Planner')

@php
    $prioStyle = [
        'kritis' => 'badge-red',
        'tinggi' => 'badge-red',
        'sedang'   => 'badge-amber',
        'rendah'      => 'badge-neutral',
    ];
    $statusStyle = [
        'selesai'   => 'badge-green',
        'disetujui' => 'badge-sky',
        'proses' => 'badge-amber',
        'ditolak'    => 'badge-red',
        'diajukan' => 'badge-green',
        'draft'    => 'badge-neutral',
    ];
@endphp

@section('content')

<div class="mb-6 flex flex-wrap items-end justify-between gap-4">
    <div>
        <h1 class="page-title">RKAP Planner</h1>
        <p class="page-subtitle">Rencana Kerja dan Anggaran — kegiatan & belanja per tahun anggaran.</p>
    </div>
    <div class="flex flex-wrap items-center gap-2">
        <form method="GET">
            <label for="fiscal_year" class="sr-only">Tahun anggaran</label>
            <select name="fiscal_year" id="fiscal_year" onchange="this.form.submit()"
                    class="field !py-2 !w-auto">
                @for ($y = now()->year; $y >= now()->year - 5; $y--)
                    <option value="{{ $y }}" @selected(($fy ?? now()->year) == $y)>{{ $y }}</option>
                @endfor
            </select>
        </form>
        <a href="{{ route('rkap.create') }}" class="btn-primary">+ Kegiatan Baru</a>
    </div>
</div>

@include('rkap.summary-card')

<div class="panel overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="table-head">
                <tr>
                    <th>Kode</th>
                    <th>Kegiatan</th>
                    <th>Kategori</th>
                    <th>Jenis Belanja</th>
                    <th class="!text-right">Alokasi</th>
                    <th class="!text-right">Realisasi</th>
                    <th class="!text-right">Sisa</th>
                    <th>Prioritas</th>
                    <th>Status</th>
                    <th class="!text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="table-body">
                @forelse ($plans as $plan)
                    @php $sisa = $plan->planned_amount - $plan->used_amount; @endphp
                    <tr>
                        <td class="font-mono text-xs text-soil-500 whitespace-nowrap">{{ $plan->kode }}</td>
                        <td class="font-medium text-soil-800">{{ $plan->kegiatan }}</td>
                        <td>{{ $plan->kategori }}</td>
                        <td>{{ $plan->belanja }}</td>
                        <td class="text-right font-mono text-xs tabular-nums">{{ number_format($plan->planned_amount, 0, ',', '.') }}</td>
                        <td class="text-right font-mono text-xs tabular-nums text-honey-600">{{ number_format($plan->used_amount, 0, ',', '.') }}</td>
                        <td class="text-right font-mono text-xs tabular-nums font-medium {{ $sisa < 0 ? 'text-ember-600' : 'text-crop-700' }}">
                            {{ number_format($sisa, 0, ',', '.') }}
                        </td>
                        <td><span class="{{ $prioStyle[$plan->prioritas] ?? 'badge-neutral' }}">{{ ucfirst($plan->prioritas) }}</span></td>
                        <td><span class="{{ $statusStyle[$plan->status] ?? 'badge-neutral' }}">{{ ucfirst(str_replace('_', ' ', $plan->status)) }}</span></td>
                        <td>
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('rkap.edit', $plan) }}" class="action-link">Edit</a>
                                <form method="POST" action="{{ route('rkap.destroy', $plan) }}"
                                      onsubmit="return confirm('Yakin menghapus rencana ini?')" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="action-link action-link-danger">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="px-4 py-16 text-center">
                            <p class="text-sm text-soil-500">Belum ada rencana RKAP untuk tahun {{ $fy ?? now()->year }}.</p>
                            <a href="{{ route('rkap.create') }}" class="action-link mt-1 inline-block">Susun rencana pertama</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if ($plans->hasPages())
    <div class="mt-6">{{ $plans->appends(['fiscal_year' => $fy ?? now()->year])->links() }}</div>
@endif

@endsection