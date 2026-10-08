@extends('layouts.app')

@section('title', 'Edit Tool')

@section('content')

<div class="max-w-xl mx-auto">
    <div class="mb-6">
        <h1 class="page-title">Edit Tool</h1>
        <p class="page-subtitle font-mono">{{ $tool->kode }} · {{ $tool->nama }}</p>
    </div>

    <form method="POST" action="{{ route('tools.update', $tool) }}" class="panel p-6 space-y-5">
        @csrf @method('PUT')

        <div>
            <label for="kode" class="field-label">Kode</label>
            <input type="text" name="kode" id="kode" value="{{ old('kode', $tool->kode) }}"
                   class="field font-mono" required>
            @error('kode') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="nama" class="field-label">Nama</label>
            <input type="text" name="nama" id="nama" value="{{ old('nama', $tool->nama) }}"
                   class="field" required>
            @error('nama') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-2 gap-5">
            <div>
                <label for="kategori" class="field-label">Kategori</label>
                <select name="kategori" id="kategori" class="field">
                    @foreach(['Tester', 'Handtool', 'Measurement', 'Cleaning', 'Lainnya'] as $kat)
                        <option value="{{ $kat }}" @selected(old('kategori', $tool->kategori) === $kat)>{{ $kat }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="status" class="field-label">Status</label>
                <select name="status" id="status" class="field">
                    @foreach(['tersedia', 'dipinjam', 'perbaikan', 'hilang'] as $s)
                        <option value="{{ $s }}" @selected(old('status', $tool->status) === $s)>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label for="catatan" class="field-label">Catatan</label>
            <textarea name="catatan" id="catatan" rows="3" class="field">{{ old('catatan', $tool->catatan) }}</textarea>
        </div>

        <div class="flex flex-wrap gap-3 pt-2">
            <button type="submit" class="btn-primary">Simpan Perubahan</button>
            <a href="{{ route('tools.index') }}" class="btn-quiet">Batal</a>
        </div>
    </form>
</div>

@endsection