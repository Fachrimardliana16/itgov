@extends('layouts.app')

@section('title', 'Edit SOP')

@section('content')

<div class="max-w-3xl mx-auto">
    <div class="mb-6 flex flex-wrap items-end justify-between gap-4">
        <div>
            <h1 class="page-title">Edit SOP</h1>
            <p class="page-subtitle font-mono">{{ $sop->code }} · versi {{ $sop->version }}</p>
        </div>
        <a href="{{ route('sops.show', $sop) }}" class="action-link">Lihat dokumen →</a>
    </div>

    <form method="POST" action="{{ route('sops.update', $sop) }}" class="panel p-6 space-y-5">
        @csrf @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
            <div>
                <label for="code" class="field-label">Code</label>
                <input type="text" name="code" id="code" value="{{ old('code', $sop->code) }}"
                       class="field font-mono" required>
            </div>

            <div>
                <label for="category" class="field-label">Kategori</label>
                <select name="category" id="category" class="field">
                    @foreach(['Infrastructure', 'Security', 'Development', 'Helpdesk', 'General'] as $cat)
                        <option value="{{ $cat }}" @selected(old('category', $sop->category) === $cat)>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="version" class="field-label">Versi</label>
                <input type="text" name="version" id="version" value="{{ old('version', $sop->version) }}"
                       class="field font-mono" required>
            </div>
        </div>

        <div>
            <label for="title" class="field-label">Judul</label>
            <input type="text" name="title" id="title" value="{{ old('title', $sop->title) }}"
                   class="field" required>
        </div>

        <div>
            <label for="status" class="field-label">Status</label>
            <select name="status" id="status" class="field !w-auto min-w-[12rem]">
                @foreach(['draft', 'review', 'approved', 'archived'] as $s)
                    <option value="{{ $s }}" @selected(old('status', $sop->status) === $s)>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="content" class="field-label">Isi SOP</label>
            <textarea name="content" id="content" rows="12"
                      class="field font-mono text-xs leading-relaxed" required>{{ old('content', $sop->content) }}</textarea>
        </div>

        <div class="flex flex-wrap gap-3 pt-2">
            <button type="submit" class="btn-primary">Simpan Perubahan</button>
            <a href="{{ route('sops.index') }}" class="btn-quiet">Batal</a>
        </div>
    </form>
</div>

@endsection