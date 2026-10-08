@extends('layouts.app')

@section('title', 'Edit Kredensial')

@section('content')

<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <h1 class="page-title">Edit Kredensial</h1>
        <p class="page-subtitle">{{ $credential->title }} · {{ $credential->category }}</p>
    </div>

    <form method="POST" action="{{ route('vault.update', $credential) }}" class="panel p-6 space-y-5">
        @csrf @method('PUT')

        <div>
            <label for="title" class="field-label">Judul</label>
            <input type="text" name="title" id="title" value="{{ old('title', $credential->title) }}"
                   class="field" required>
            @error('title') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label for="category" class="field-label">Kategori</label>
                <select name="category" id="category" class="field">
                    @foreach(['Server', 'Database', 'Network', 'SaaS', 'ServiceAccount'] as $cat)
                        <option value="{{ $cat }}" @selected(old('category', $credential->category) === $cat)>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="host_or_url" class="field-label">Host / URL</label>
                <input type="text" name="host_or_url" id="host_or_url"
                       value="{{ old('host_or_url', $credential->host_or_url) }}"
                       class="field font-mono text-xs" placeholder="https://…">
            </div>
        </div>

        <div class="pt-4 border-t border-soil-100">
            <div class="flex items-start gap-3 px-4 py-3 rounded-xl bg-crop-50 border border-crop-200">
                <span class="mt-0.5 shrink-0 text-crop-600" aria-hidden="true">ℹ</span>
                <p class="text-sm text-crop-800">
                    Tiga field berikut disimpan terenkripsi. <strong>Biarkan kosong</strong> untuk mempertahankan
                    nilai lama — isi hanya bila Anda ingin menggantinya.
                </p>
            </div>
        </div>

        <div>
            <label for="username_encrypted" class="field-label">Username baru</label>
            <input type="text" name="username_encrypted" id="username_encrypted"
                   class="field font-mono text-sm" placeholder="Kosongkan untuk mempertahankan nilai lama">
        </div>

        <div>
            <label for="password_encrypted" class="field-label">Password baru</label>
            <input type="text" name="password_encrypted" id="password_encrypted"
                   class="field font-mono text-sm" placeholder="Kosongkan untuk mempertahankan nilai lama">
        </div>

        <div>
            <label for="additional_secret_encrypted" class="field-label">API Key / Secret tambahan</label>
            <input type="text" name="additional_secret_encrypted" id="additional_secret_encrypted"
                   class="field font-mono text-sm" placeholder="Kosongkan untuk mempertahankan nilai lama">
        </div>

        <div>
            <label for="notes_encrypted" class="field-label">Catatan</label>
            <textarea name="notes_encrypted" id="notes_encrypted" rows="3"
                      class="field">{{ old('notes_encrypted') }}</textarea>
        </div>

        <div class="flex flex-wrap gap-3 pt-2">
            <button type="submit" class="btn-ember">Simpan Perubahan</button>
            <a href="{{ route('vault.index') }}" class="btn-quiet">Batal</a>
        </div>
    </form>
</div>

@endsection