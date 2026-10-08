@extends('layouts.app')

@section('title', 'Detail Tool')

@section('content')

<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <h1 class="page-title">Detail Tool</h1>
        <p class="page-subtitle font-mono">{{ $tool->kode }} · {{ $tool->nama }}</p>
    </div>

    <div class="panel p-6 space-y-6">
        <dl class="grid grid-cols-2 gap-4 text-sm">
            <dt class="text-soil-500">Kode</dt>
            <dd class="font-mono font-medium">{{ $tool->kode }}</dd>
            <dt class="text-soil-500">Nama</dt>
            <dd class="font-medium">{{ $tool->nama }}</dd>
            <dt class="text-soil-500">Kategori</dt>
            <dd>{{ $tool->kategori }}</dd>
            <dt class="text-soil-500">Status</dt>
            <dd>
                <span class="badge-{{ ['tersedia' => 'green', 'dipinjam' => 'amber', 'perbaikan' => 'neutral'][$tool->status] ?? 'red' }}">
                    {{ ucfirst($tool->status) }}
                </span>
            </dd>
            <dt class="text-soil-500">Catatan</dt>
            <dd class="col-span-2">{{ $tool->catatan ?: '—' }}</dd>
            <dt class="text-soil-500">Dibuat</dt>
            <dd>{{ $tool->created_at->format('d/m/Y H:i') }}</dd>
            <dt class="text-soil-500">Diperbarui</dt>
            <dd>{{ $tool->updated_at->format('d/m/Y H:i') }}</dd>
        </dl>

        <div class="border-t border-soil-200 pt-4">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-medium text-soil-800">Riwayat Pinjaman</h3>
                @if ($tool->status === 'tersedia')
                    <a href="{{ route('tools.pinjam', $tool) }}" class="btn-primary text-sm">+ Pinjam</a>
                @endif
            </div>

            @if ($loans->isEmpty())
                <p class="text-sm text-soil-500 text-center py-8">Belum ada riwayat pinjaman.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="table-head">
                            <tr>
                                <th>Peminjam</th>
                                <th>Tgl Pinjam</th>
                                <th>Rencana Kembali</th>
                                <th>Tgl Kembali Aktual</th>
                                <th>Status</th>
                                <th class="!text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="table-body">
                            @foreach ($loans as $loan)
                                <tr>
                                    <td class="font-medium text-soil-800">{{ $loan->user->name }}</td>
                                    <td>{{ $loan->tanggal_pinjam->format('d/m/Y') }}</td>
                                    <td>{{ $loan->tanggal_rencana_kembali->format('d/m/Y') }}</td>
                                    <td>{{ $loan->tanggal_kembali_aktual?->format('d/m/Y') ?? '—' }}</td>
                                    <td>
                                        <span class="badge-{{ ['dipinjam' => 'amber', 'dikembalikan' => 'green', 'terlambat' => 'red'][$loan->status] ?? 'neutral' }}">{{ ucfirst($loan->status) }}</span>
                                    </td>
                                    <td>
                                        <div class="flex items-center justify-end gap-3">
                                            @if ($loan->status === 'dipinjam')
                                                <a href="{{ route('tools.kembalikan', $loan) }}" class="btn-ember text-xs">Kembalikan</a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($loans->hasPages())
                    <div class="mt-6">{{ $loans->links() }}</div>
                @endif
            @endif
        </div>
    </div>

    <div class="mt-4 flex gap-3">
        <a href="{{ route('tools.edit', $tool) }}" class="btn-quiet">Edit Tool</a>
        <form method="POST" action="{{ route('tools.destroy', $tool) }}"
              onsubmit="return confirm('Yakin menghapus tool ini?')" class="inline">
            @csrf @method('DELETE')
            <button type="submit" class="btn-quiet text-red-600 hover:text-red-700">Hapus</button>
        </form>
    </div>
</div>

@endsection