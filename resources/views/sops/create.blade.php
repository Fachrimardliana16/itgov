@extends('layouts.app')

@section('title', 'Buat SOP')

@section('content')
<div class="max-w-3xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">📋 Buat SOP Baru</h1>

    <form method="POST" action="{{ route('sops.store') }}" class="bg-white rounded-lg shadow p-6 space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Code</label>
            <input type="text" name="code" value="{{ old('code', 'SOP-IT-') }}"
                class="w-full px-3 py-2 border rounded-md @error('code') border-red-500 @enderror" required>
            @error('code') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
            <input type="text" name="title" value="{{ old('title') }}"
                class="w-full px-3 py-2 border rounded-md @error('title') border-red-500 @enderror" required>
            @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                <select name="category" class="w-full px-3 py-2 border rounded-md" required>
                    @foreach(['Infrastructure', 'Security', 'Development', 'Helpdesk', 'General'] as $cat)
                    <option value="{{ $cat }}" @if(old('category') === $cat) selected @endif>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="w-full px-3 py-2 border rounded-md">
                    @foreach(['draft', 'review', 'approved', 'archived'] as $s)
                    <option value="{{ $s }}" @if(old('status') === $s) selected @endif>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Version</label>
            <input type="text" name="version" value="{{ old('version', '1.0.0') }}" class="w-full px-3 py-2 border rounded-md" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Content (HTML/Markdown)</label>
            <textarea name="content" rows="10"
                class="w-full px-3 py-2 border rounded-md font-mono text-sm @error('content') border-red-500 @enderror"
                required>{{ old('content') }}</textarea>
            @error('content') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Simpan</button>
            <a href="{{ route('sops.index') }}" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-300">Batal</a>
        </div>
    </form>
</div>
@stop