@extends('layouts.app')

@section('title', 'Edit Rencana RKAP')

@section('content')

<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <h1 class="page-title">Edit Rencana RKAP</h1>
        <p class="page-subtitle font-mono">{{ $rkap->kode }} · tahun {{ $rkap->fiscal_year }}</p>
    </div>

    <form method="POST" action="{{ route('rkap.update', $rkap) }}" class="panel p-6 space-y-5">
        @csrf @method('PUT')

        <div class="grid grid-cols-2 gap-5">
            <div>
                <label for="fiscal_year" class="field-label">Tahun anggaran</label>
                <input type="number" name="fiscal_year" id="fiscal_year"
                       value="{{ old('fiscal_year', $rkap->fiscal_year) }}"
                       class="field font-mono" required>
            </div>

            <div>
                <label for="kode" class="field-label">Kode</label>
                <input type="text" name="kode" id="kode" value="{{ old('kode', $rkap->kode) }}"
                       class="field font-mono" required>
                @error('kode') <p class="field-error">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label for="kegiatan" class="field-label">Kegiatan</label>
            <input type="text" name="kegiatan" id="kegiatan" value="{{ old('kegiatan', $rkap->kegiatan) }}"
                   class="field" required>
            @error('kegiatan') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-3 gap-5">
            <div>
                <label for="kategori" class="field-label">Kategori</label>
                <select name="kategori" id="kategori" class="field">
                    @foreach(['Belanja Pegawai', 'Belanja Barang', 'Belanja Modal', 'Bantuan Sosial', 'Lainnya'] as $kat)
                        <option value="{{ $kat }}" @selected(old('kategori', $rkap->kategori) === $kat)>{{ $kat }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="belanja" class="field-label">Jenis Belanja</label>
                <select name="belanja" id="belanja" class="field">
                    @foreach(['Langsung', 'Tidak Langsung', 'Lainnya'] as $b)
                        <option value="{{ $b }}" @selected(old('belanja', $rkap->belanja) === $b)>{{ $b }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="prioritas" class="field-label">Prioritas</label>
                <select name="prioritas" id="prioritas" class="field">
                    @foreach(['rendah', 'sedang', 'tinggi', 'kritis'] as $p)
                        <option value="{{ $p }}" @selected(old('prioritas', $rkap->prioritas) === $p)>{{ ucfirst($p) }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-5">
            <div>
                <label for="planned_amount" class="field-label">Alokasi (Rp)</label>
                <input type="number" name="planned_amount" id="planned_amount"
                       value="{{ old('planned_amount', $rkap->planned_amount) }}"
                       class="field font-mono" min="0" step="0.01" required>
                @error('planned_amount') <p class="field-error">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="used_amount" class="field-label">Realisasi (Rp)</label>
                <input type="number" name="used_amount" id="used_amount"
                       value="{{ old('used_amount', $rkap->used_amount) }}"
                       class="field font-mono" min="0" step="0.01">
                @error('used_amount') <p class="field-error">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label for="status" class="field-label">Status</label>
            <select name="status" id="status" class="field !w-auto min-w-[12rem]">
                @foreach(['draft', 'diajukan', 'disetujui', 'ditolak', 'proses', 'selesai'] as $s)
                    <option value="{{ $s }}" @selected(old('status', $rkap->status) === $s)>{{ ucfirst(str_replace('_', ' ', $s)) }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="catatan" class="field-label">Catatan</label>
            <textarea name="catatan" id="catatan" rows="3" class="field">{{ old('catatan', $rkap->catatan) }}</textarea>
        </div>

        <div class="flex flex-wrap gap-3 pt-2">
            <button type="submit" class="btn-primary">Simpan Perubahan</button>
            <a href="{{ route('rkap.index') }}" class="btn-quiet">Batal</a>
        </div>
    </form>
</div>

@endsection