@extends('layouts.app')

@section('title', 'Manajemen Tools')

@php
    $statusStyle = [
        'tersedia' => 'badge-green',
        'dipinjam' => 'badge-amber',
        'perbaikan' => 'badge-neutral',
        'hilang' => 'badge-red',
    ];
    $kategoris = ['Tester', 'Handtool', 'Measurement', 'Cleaning', 'Lainnya'];
    $statuses = ['tersedia', 'dipinjam', 'perbaikan', 'hilang'];
@endphp

@section('content')

<div class="mb-6 flex flex-wrap items-end justify-between gap-4">
    <div>
        <h1 class="page-title">Manajemen Tools</h1>
        <p class="page-subtitle">Alat kerja IT — pinjam, kembalikan, lacak riwayat.</p>
    </div>
    <a href="{{ route('tools.create') }}" class="btn-primary">+ Tool Baru</a>
</div>

<div class="mb-5 flex flex-wrap items-center gap-3">
    <form method="GET" class="flex flex-wrap items-center gap-2">
        <label for="status" class="sr-only">Filter status</label>
        <select name="status" id="status" onchange="this.form.submit()"
                class="field !py-2 !w-auto">
            <option value="">Semua Status</option>
            @foreach ($statuses as $s)
                <option value="{{ $s }}" @selected(($status ?? '') === $s)>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
    </form>

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
                    <th>Status</th>
                    <th>Peminjam Saat Ini</th>
                    <th class="!text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="table-body">
                @forelse ($tools as $tool)
                    <tr>
                        <td class="font-mono text-xs text-soil-500 whitespace-nowrap">{{ $tool->kode }}</td>
                        <td class="font-medium text-soil-800">{{ $tool->nama }}</td>
                        <td>{{ $tool->kategori }}</td>
                        <td><span class="{{ $statusStyle[$tool->status] ?? 'badge-neutral' }}">{{ ucfirst($tool->status) }}</span></td>
                        <td class="text-soil-500 text-sm">
                            @if ($loan = $tool->currentLoan())
                                {{ $loan->user->name }} (s/d {{ $loan->tanggal_rencana_kembali->format('d/m/Y') }})
                            @else
                                —
                            @endif
                        </td>
                        <td>
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('tools.show', $tool) }}" class="action-link">Riwayat</a>
                                <a href="{{ route('tools.edit', $tool) }}" class="action-link">Edit</a>
                                @if ($tool->status === 'tersedia')
                                    <a href="{{ route('tools.pinjam', $tool) }}" class="btn-primary text-xs">Pinjam</a>
                                @endif
                                @if ($tool->status !== 'dipinjam')
                                    <form method="POST" action="{{ route('tools.destroy', $tool) }}"
                                          onsubmit="return confirm('Yakin menghapus tool ini?')" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="action-link action-link-danger">Hapus</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-16 text-center">
                            <p class="text-sm text-soil-500">Belum ada tool terdaftar.</p>
                            <a href="{{ route('tools.create') }}" class="action-link mt-1 inline-block">Tambah yang pertama</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if ($tools->hasPages())
    <div class="mt-6">{{ $tools->appends(['status' => $status ?? '', 'kategori' => $kategori ?? ''])->links() }}</div>
@endif

@endsection