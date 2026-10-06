@extends('layouts.app')
@section('title', 'Tambah Kredensial')
@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">🔐 Tambah Kredensial Baru</h1>
    <form method="POST" action="{{ route('vault.store') }}" class="bg-white rounded-lg shadow p-6 space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Title *</label>
            <input type="text" name="title" value="{{ old('title') }}"
                class="w-full px-3 py-2 border rounded-md" required>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Category *</label>
                <select name="category" class="w-full px-3 py-2 border rounded-md" required>
                    @foreach(['Server', 'Database', 'Network', 'SaaS', 'ServiceAccount'] as $cat)
                    <option value="{{ $cat }}">{{ $cat }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Host / URL</label>
                <input type="text" name="host_or_url" value="{{ old('host_or_url') }}"
                    class="w-full px-3 py-2 border rounded-md" placeholder="https://...">
            </div>
        </div>

        <div class="bg-yellow-50 border border-yellow-200 rounded p-3 text-xs text-yellow-700">
            ⚠️ Username & Password akan dienkripsi AES-256-GCM sebelum disimpan.
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Username *</label>
            <input type="text" name="username_encrypted" value="{{ old('username_encrypted') }}"
                class="w-full px-3 py-2 border rounded-md" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Password *</label>
            <input type="text" name="password_encrypted" value="{{ old('password_encrypted') }}"
                class="w-full px-3 py-2 border rounded-md" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">API Key / Additional Secret</label>
            <input type="text" name="additional_secret_encrypted" value="{{ old('additional_secret_encrypted') }}"
                class="w-full px-3 py-2 border rounded-md">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Notes (rahasia)</label>
            <textarea name="notes_encrypted" rows="3" class="w-full px-3 py-2 border rounded-md">{{ old('notes_encrypted') }}</textarea>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">Simpan</button>
            <a href="{{ route('vault.index') }}" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md">Batal</a>
        </div>
    </form>
</div>
@stop