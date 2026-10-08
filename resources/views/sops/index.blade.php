@extends('layouts.app')

@section('title', 'Dokumentasi SOP')

@section('content')

<div class="mb-6 flex flex-wrap items-end justify-between gap-4">
    <div>
        <h1 class="page-title">Dokumentasi SOP</h1>
        <p class="page-subtitle">Perpustakaan prosedur operasi IT, tertata per versi dan status.</p>
    </div>
    <a href="{{ route('sops.create') }}" class="btn-primary">+ SOP Baru</a>
</div>

<div class="panel overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="table-head">
                <tr>
                    <th>Code</th>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Status</th>
                    <th>Versi</th>
                    <th>Penulis</th>
                    <th class="!text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="table-body">
                @forelse ($sops as $sop)
                    <tr>
                        <td class="font-mono text-xs text-soil-500 whitespace-nowrap">{{ $sop->code }}</td>
                        <td class="font-medium text-soil-800">{{ $sop->title }}</td>
                        <td class="text-soil-500">{{ $sop->category }}</td>
                        <td>
                            <span @class([
                                'badge-green'   => $sop->status === 'approved',
                                'badge-amber'    => $sop->status === 'review',
                                'badge-neutral'  => in_array($sop->status, ['draft', 'archived'], true),
                            ])>{{ ucfirst($sop->status) }}</span>
                        </td>
                        <td class="font-mono text-xs text-soil-500">v{{ $sop->version }}</td>
                        <td class="text-soil-500">{{ $sop->author?->name ?? '—' }}</td>
                        <td>
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('sops.show', $sop) }}" class="action-link">Lihat</a>
                                <a href="{{ route('sops.edit', $sop) }}" class="action-link">Edit</a>
                                <form method="POST" action="{{ route('sops.destroy', $sop) }}"
                                      onsubmit="return confirm('Yakin menghapus SOP ini?')" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="action-link action-link-danger">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-16 text-center">
                            <p class="text-sm text-soil-500">Belum ada SOP.</p>
                            <a href="{{ route('sops.create') }}" class="action-link mt-1 inline-block">Tulis yang pertama</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if ($sops->hasPages())
    <div class="mt-6">{{ $sops->links() }}</div>
@endif

@endsection