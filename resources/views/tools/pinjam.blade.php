@extends('layouts.app')

@section('title', 'Pinjam Tool')

@section('content')

<div class="max-w-xl mx-auto">
    <div class="mb-6">
        <h1 class="page-title">Pinjam Tool</h1>
        <p class="page-subtitle font-mono">{{ $tool->kode }} · {{ $tool->nama }}</p>
    </div>

    <form method="POST" action="{{ route('tools.pinjam.store', $tool) }}" class="panel p-6 space-y-5">
        @csrf

        <div>
            <label for="user_id" class="field-label">Peminjam</label>
            <select name="user_id" id="user_id" class="field" required>
                <option value="">Pilih pengguna</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" @selected(old('user_id') == $user->id)>{{ $user->name }}</option>
                @endforeach
            </select>
            @error('user_id') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-2 gap-5">
            <div>
                <label for="tanggal_pinjam" class="field-label">Tanggal Pinjam</label>
                <input type="date" name="tanggal_pinjam" id="tanggal_pinjam"
                       value="{{ old('tanggal_pinjam', now()->format('Y-m-d')) }}"
                       class="field" required>
                @error('tanggal_pinjam') <p class="field-error">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="tanggal_rencana_kembali" class="field-label">Tanggal Rencana Kembali</label>
                <input type="date" name="tanggal_rencana_kembali" id="tanggal_rencana_kembali"
                       value="{{ old('tanggal_rencana_kembali', now()->addDays(7)->format('Y-m-d')) }}"
                       class="field" required>
                @error('tanggal_rencana_kembali') <p class="field-error">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label for="catatan_pinjam" class="field-label">Catatan Pinjam</label>
            <textarea name="catatan_pinjam" id="catatan_pinjam" rows="3" class="field"
                      placeholder="Keperluan pinjam, lokasi penggunaan, dll"></textarea>
            @error('catatan_pinjam') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <div class="flex flex-wrap gap-3 pt-2">
            <button type="submit" class="btn-primary">Konfirmasi Pinjam</button>
            <a href="{{ route('tools.show', $tool) }}" class="btn-quiet">Batal</a>
        </div>
    </form>
</div>

@endsection