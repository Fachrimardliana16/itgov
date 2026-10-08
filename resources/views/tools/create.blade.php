@extends('layouts.app')

@section('title', 'Tambah Tool')

@section('content')

<div class="max-w-xl mx-auto">
    <div class="mb-6">
        <h1 class="page-title">Tambah Tool</h1>
        <p class="page-subtitle">Daftarkan alat kerja baru ke manajemen tools.</p>
    </div>

    <form method="POST" action="{{ route('tools.store') }}" class="panel p-6 space-y-5">
        @csrf

        <div>
            <label for="kode" class="field-label">Kode</label>
            <input type="text" name="kode" id="kode" value="{{ old('kode', 'TL-') }}"
                   class="field font-mono" required>
            @error('kode') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="nama" class="field-label">Nama</label>
            <input type="text" name="nama" id="nama" value="{{ old('nama') }}"
                   class="field" required>
            @error('nama') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-2 gap-5">
            <div>
                <label for="kategori" class="field-label">Kategori</label>
                <select name="kategori" id="kategori" class="field" required>
                    @foreach(['Tester', 'Handtool', 'Measurement', 'Cleaning', 'Lainnya'] as $kat)
                        <option value="{{ $kat }}" @selected(old('kategori') === $kat)>{{ $kat }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="status" class="field-label">Status Awal</label>
                <select name="status" id="status" class="field">
                    @foreach(['tersedia', 'dipinjam', 'perbaikan', 'hilang'] as $s)
                        <option value="{{ $s }}" @selected(old('status', 'tersedia') === $s)>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label for="catatan" class="field-label">Catatan</label>
            <textarea name="catatan" id="catatan" rows="3" class="field">{{ old('catatan') }}</textarea>
        </div>

        <div class="flex flex-wrap gap-3 pt-2">
            <button type="submit" class="btn-primary">Simpan Tool</button>
            <a href="{{ route('tools.index') }}" class="btn-quiet">Batal</a>
        </div>
    </form>
</div>

@endsection