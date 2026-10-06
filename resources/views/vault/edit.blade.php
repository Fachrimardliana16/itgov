@extends('layouts.app')

@section('title', 'Edit Kredensial: ' . $credential->title)

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">Edit Kredensial</h1>

    <form method="POST" action="{{ route('vault.update', $credential) }}" class="bg-white rounded-lg shadow p-6 space-y-4">
        @csrf @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Title *</label>
            <input type="text" name="title" value="{{ old('title', $credential->title) }}"
                class="w-full px-3 py-2 border rounded-md" required>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                <select name="category" class="w-full px-3 py-2 border rounded-md">
                    @foreach(['Server', 'Database', 'Network', 'SaaS', 'ServiceAccount'] as $cat)
                    <option value="{{ $cat }}" @if(old('category', $credential->category) === $cat) selected @endif>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Host / URL</label>
                <input type="text" name="host_or_url" value="{{ old('host_or_url', $credential->host_or_url) }}"
                    class="w-full px-3 py-2 border rounded-md">
            </div>
        </div>

        <div class="bg-blue-50 border border-blue-200 rounded p-3 text-xs text-blue-700">
            ℹ️ Biarkan kosong untuk mempertahankan nilai enkripsi yang sudah ada.
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Username (baru, optional)</label>
            <input type="text" name="username_encrypted" class="w-full px-3 py-2 border rounded-md"
                placeholder="Isi untuk ganti username">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Password (baru, optional)</label>
            <input type="text" name="password_encrypted" class="w-full px-3 py-2 border rounded-md"
                placeholder="Isi untuk ganti password">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">API Key / Additional Secret</label>
            <input type="text" name="additional_secret_encrypted" class="w-full px-3 py-2 border rounded-md">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
            <textarea name="notes_encrypted" rows="3" class="w-full px-3 py-2 border rounded-md"></textarea>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Update</button>
            <a href="{{ route('vault.index') }}" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md">Batal</a>
        </div>
    </form>
</div>
@stop