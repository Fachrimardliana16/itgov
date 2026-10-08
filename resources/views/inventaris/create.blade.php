@extends('layouts.app')

@section('title', 'Tambah Item Inventaris')

@section('content')

<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <h1 class="page-title">Tambah Item Inventaris</h1>
        <p class="page-subtitle">Daftarkan aset IT atau pendukung baru.</p>
    </div>

    <form method="POST" action="{{ route('inventaris.store') }}" class="panel p-6 space-y-5">
        @csrf

        <div>
            <label for="kode" class="field-label">Kode</label>
            <input type="text" name="kode" id="kode" value="{{ old('kode', 'INV-') }}"
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
                    @foreach(['Hardware', 'Software', 'Network', 'Peripheral', 'Furniture', 'Lainnya'] as $kat)
                        <option value="{{ $kat }}" @selected(old('kategori') === $kat)>{{ $kat }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="kondisi" class="field-label">Kondisi</label>
                <select name="kondisi" id="kondisi" class="field" required>
                    @foreach(['Baik', 'Rusak Ringan', 'Rusak Berat', 'Dibuang'] as $k)
                        <option value="{{ $k }}" @selected(old('kondisi', 'Baik') === $k)>{{ $k }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-5">
            <div>
                <label for="lokasi" class="field-label">Lokasi</label>
                <input type="text" name="lokasi" id="lokasi" value="{{ old('lokasi') }}"
                       class="field" placeholder="Ruang Server, Gudang A, dll">
            </div>

            <div>
                <label for="tanggal_beli" class="field-label">Tanggal Beli</label>
                <input type="date" name="tanggal_beli" id="tanggal_beli"
                       value="{{ old('tanggal_beli') }}" class="field">
            </div>
        </div>

        <div>
            <label for="nilai" class="field-label">Nilai (Rp)</label>
            <input type="number" name="nilai" id="nilai" value="{{ old('nilai', 0) }}"
                   class="field font-mono" min="0" step="0.01" required>
            @error('nilai') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="spesifikasi" class="field-label">Spesifikasi</label>
            <textarea name="spesifikasi" id="spesifikasi" rows="3" class="field">{{ old('spesifikasi') }}</textarea>
        </div>

        <div>
            <label for="catatan" class="field-label">Catatan</label>
            <textarea name="catatan" id="catatan" rows="3" class="field">{{ old('catatan') }}</textarea>
        </div>

        <div class="flex flex-wrap gap-3 pt-2">
            <button type="submit" class="btn-primary">Simpan Item</button>
            <a href="{{ route('inventaris.index') }}" class="btn-quiet">Batal</a>
        </div>
    </form>
</div>

@endsection