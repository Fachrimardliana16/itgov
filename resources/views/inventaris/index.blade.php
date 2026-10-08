@extends('layouts.app')

@section('title', 'Inventaris IT')

@php
    $condStyle = [
        'Baik' => 'badge-green',
        'Rusak Ringan' => 'badge-amber',
        'Rusak Berat' => 'badge-red',
        'Dibuang' => 'badge-neutral',
    ];
    $kategoris = ['Hardware', 'Software', 'Network', 'Peripheral', 'Furniture', 'Lainnya'];
@endphp

@section('content')

<div class="mb-6 flex flex-wrap items-end justify-between gap-4">
    <div>
        <h1 class="page-title">Inventaris IT</h1>
        <p class="page-subtitle">Daftar aset IT dan pendukung — kode, kondisi, lokasi, nilai.</p>
    </div>
    <a href="{{ route('inventaris.create') }}" class="btn-primary">+ Item Baru</a>
</div>

<div class="mb-5 flex items-center gap-3">
    <form method="GET" class="flex items-center gap-2">
        <label for="kategori" class="sr-only">Filter kategori</label>
        <select name="kategori" id="kategori" onchange="this.form.submit()"
                class="field !py-2 !w-auto">
            <option value="">Semua Kategori</option>
            @foreach ($kategoris as $kat)
                <option value="{{ $kat }}" @selected(($kategori ?? '') === $kat)>{{ $kat }}</option>
            @endforeach
        </select>
    </form>
</div>

<div class="panel overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="table-head">
                <tr>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Spesifikasi</th>
                    <th>Kondisi</th>
                    <th>Lokasi</th>
                    <th class="!text-right">Nilai</th>
                    <th class="!text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="table-body">
                @forelse ($items as $item)
                    <tr>
                        <td class="font-mono text-xs text-soil-500 whitespace-nowrap">{{ $item->kode }}</td>
                        <td class="font-medium text-soil-800">{{ $item->nama }}</td>
                        <td>{{ $item->kategori }}</td>
                        <td class="text-soil-500 text-sm max-w-xs truncate">{{ $item->spesifikasi ?? '—' }}</td>
                        <td><span class="{{ $condStyle[$item->kondisi] ?? 'badge-neutral' }}">{{ $item->kondisi }}</span></td>
                        <td class="text-soil-500 text-sm">{{ $item->lokasi ?? '—' }}</td>
                        <td class="text-right font-mono text-xs tabular-nums">{{ number_format($item->nilai, 0, ',', '.') }}</td>
                        <td>
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('inventaris.edit', $item) }}" class="action-link">Edit</a>
                                <form method="POST" action="{{ route('inventaris.destroy', $item) }}"
                                      onsubmit="return confirm('Yakin menghapus item ini?')" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="action-link action-link-danger">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 py-16 text-center">
                            <p class="text-sm text-soil-500">Belum ada item inventaris.</p>
                            <a href="{{ route('inventaris.create') }}" class="action-link mt-1 inline-block">Tambah yang pertama</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if ($items->hasPages())
    <div class="mt-6">{{ $items->appends(['kategori' => $kategori ?? ''])->links() }}</div>
@endif

@endsection