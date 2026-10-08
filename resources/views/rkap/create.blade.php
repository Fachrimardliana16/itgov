@extends('layouts.app')

@section('title', 'Tambah Rencana RKAP')

@section('content')

<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <h1 class="page-title">Tambah Rencana RKAP</h1>
        <p class="page-subtitle">Susun kegiatan dan alokasi belanja baru.</p>
    </div>

    <form method="POST" action="{{ route('rkap.store') }}" class="panel p-6 space-y-5">
        @csrf

        <div class="grid grid-cols-2 gap-5">
            <div>
                <label for="fiscal_year" class="field-label">Tahun anggaran</label>
                <input type="number" name="fiscal_year" id="fiscal_year"
                       value="{{ old('fiscal_year', now()->year) }}"
                       class="field font-mono" required>
                @error('fiscal_year') <p class="field-error">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="kode" class="field-label">Kode</label>
                <input type="text" name="kode" id="kode" value="{{ old('kode', 'RKAP-' . now()->year . '-') }}"
                       class="field font-mono" required>
                @error('kode') <p class="field-error">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label for="kegiatan" class="field-label">Kegiatan</label>
            <input type="text" name="kegiatan" id="kegiatan" value="{{ old('kegiatan') }}"
                   class="field" required>
            @error('kegiatan') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-3 gap-5">
            <div>
                <label for="kategori" class="field-label">Kategori</label>
                <select name="kategori" id="kategori" class="field" required>
                    @foreach(['Belanja Pegawai', 'Belanja Barang', 'Belanja Modal', 'Bantuan Sosial', 'Lainnya'] as $kat)
                        <option value="{{ $kat }}" @selected(old('kategori') === $kat)>{{ $kat }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="belanja" class="field-label">Jenis Belanja</label>
                <select name="belanja" id="belanja" class="field" required>
                    @foreach(['Langsung', 'Tidak Langsung', 'Lainnya'] as $b)
                        <option value="{{ $b }}" @selected(old('belanja') === $b)>{{ $b }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="prioritas" class="field-label">Prioritas</label>
                <select name="prioritas" id="prioritas" class="field" required>
                    @foreach(['rendah', 'sedang', 'tinggi', 'kritis'] as $p)
                        <option value="{{ $p }}" @selected(old('prioritas', 'sedang') === $p)>{{ ucfirst($p) }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-5">
            <div>
                <label for="planned_amount" class="field-label">Alokasi (Rp)</label>
                <input type="number" name="planned_amount" id="planned_amount" value="{{ old('planned_amount') }}"
                       class="field font-mono" min="0" step="0.01" required>
                @error('planned_amount') <p class="field-error">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="used_amount" class="field-label">Realisasi (Rp)</label>
                <input type="number" name="used_amount" id="used_amount" value="{{ old('used_amount', 0) }}"
                       class="field font-mono" min="0" step="0.01">
                @error('used_amount') <p class="field-error">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label for="status" class="field-label">Status</label>
            <select name="status" id="status" class="field !w-auto min-w-[12rem]">
                @foreach(['draft', 'diajukan', 'disetujui', 'ditolak', 'proses', 'selesai'] as $s)
                    <option value="{{ $s }}" @selected(old('status', 'draft') === $s)>{{ ucfirst(str_replace('_', ' ', $s)) }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="catatan" class="field-label">Catatan</label>
            <textarea name="catatan" id="catatan" rows="3" class="field">{{ old('catatan') }}</textarea>
        </div>

        <div class="flex flex-wrap gap-3 pt-2">
            <button type="submit" class="btn-primary">Simpan Rencana</button>
            <a href="{{ route('rkap.index') }}" class="btn-quiet">Batal</a>
        </div>
    </form>
</div>

@endsection