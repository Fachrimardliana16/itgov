@extends('layouts.app')

@section('title', 'Buat SOP')

@section('content')

<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <h1 class="page-title">Buat SOP Baru</h1>
        <p class="page-subtitle">Tulis prosedur baru dan tetapkan versi awalnya.</p>
    </div>

    <form method="POST" action="{{ route('sops.store') }}" class="panel p-6 space-y-5">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label for="code" class="field-label">Code</label>
                <input type="text" name="code" id="code" value="{{ old('code', 'SOP-IT-') }}"
                       class="field font-mono @error('code') field-invalid @enderror" required>
                @error('code') <p class="field-error">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="version" class="field-label">Versi</label>
                <input type="text" name="version" id="version" value="{{ old('version', '1.0.0') }}"
                       class="field font-mono" required>
            </div>
        </div>

        <div>
            <label for="title" class="field-label">Judul</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}"
                   class="field @error('title') field-invalid @enderror" required>
            @error('title') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label for="category" class="field-label">Kategori</label>
                <select name="category" id="category" class="field" required>
                    @foreach(['Infrastructure', 'Security', 'Development', 'Helpdesk', 'General'] as $cat)
                        <option value="{{ $cat }}" @selected(old('category') === $cat)>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="status" class="field-label">Status</label>
                <select name="status" id="status" class="field">
                    @foreach(['draft', 'review', 'approved', 'archived'] as $s)
                        <option value="{{ $s }}" @selected(old('status', 'draft') === $s)>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label for="content" class="field-label">Isi SOP</label>
            <textarea name="content" id="content" rows="12"
                      class="field font-mono text-xs leading-relaxed @error('content') field-invalid @enderror"
                      required>{{ old('content') }}</textarea>
            @error('content') <p class="field-error">{{ $message }}</p> @enderror
            <p class="text-xs text-soil-400 mt-1.5">Mendukung penulisan HTML atau Markdown.</p>
        </div>

        <div class="flex flex-wrap gap-3 pt-2">
            <button type="submit" class="btn-primary">Simpan SOP</button>
            <a href="{{ route('sops.index') }}" class="btn-quiet">Batal</a>
        </div>
    </form>
</div>

@endsection