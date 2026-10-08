@extends('layouts.app')

@section('title', 'Kembalikan Tool')

@section('content')

<div class="max-w-xl mx-auto">
    <div class="mb-6">
        <h1 class="page-title">Kembalikan Tool</h1>
        <p class="page-subtitle font-mono">{{ $loan->tool->kode }} · {{ $loan->tool->nama }}</p>
    </div>

    <div class="panel p-6 space-y-5">
        <div class="border-b border-soil-200 pb-4">
            <h3 class="font-medium text-soil-800 mb-3">Detail Pinjaman</h3>
            <dl class="grid grid-cols-2 gap-2 text-sm">
                <dt class="text-soil-500">Peminjam</dt>
                <dd class="font-medium">{{ $loan->user->name }}</dd>
                <dt class="text-soil-500">Tanggal Pinjam</dt>
                <dd>{{ $loan->tanggal_pinjam->format('d/m/Y') }}</dd>
                <dt class="text-soil-500">Rencana Kembali</dt>
                <dd>{{ $loan->tanggal_rencana_kembali->format('d/m/Y') }}</dd>
                <dt class="text-soil-500">Catatan Pinjam</dt>
                <dd class="col-span-2">{{ $loan->catatan_pinjam ?: '—' }}</dd>
            </dl>
        </div>

        <form method="POST" action="{{ route('tools.kembalikan.update', $loan) }}" class="space-y-5">
            @csrf @method('PUT')

            <div>
                <label for="tanggal_kembali_aktual" class="field-label">Tanggal Kembali Aktual</label>
                <input type="date" name="tanggal_kembali_aktual" id="tanggal_kembali_aktual"
                       value="{{ old('tanggal_kembali_aktual', now()->format('Y-m-d')) }}"
                       class="field" required>
                @error('tanggal_kembali_aktual') <p class="field-error">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="catatan_kembali" class="field-label">Catatan Kembali</label>
                <textarea name="catatan_kembali" id="catatan_kembali" rows="3" class="field"
                          placeholder="Kondisi tool saat dikembalikan, kerusakan, dll"></textarea>
                @error('catatan_kembali') <p class="field-error">{{ $message }}</p> @enderror
            </div>

            <div class="flex flex-wrap gap-3 pt-2">
                <button type="submit" class="btn-ember">Konfirmasi Kembali</button>
                <a href="{{ route('tools.show', $loan->tool) }}" class="btn-quiet">Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection