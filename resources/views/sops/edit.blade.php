@extends('layouts.app')

@section('title', 'Edit SOP: ' . $sop->code)

@section('content')
<div class="max-w-3xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">Edit SOP</h1>

    <form method="POST" action="{{ route('sops.update', $sop) }}" class="bg-white rounded-lg shadow p-6 space-y-4">
        @csrf @method('PUT')
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Code</label>
            <input type="text" name="code" value="{{ old('code', $sop->code) }}"
                class="w-full px-3 py-2 border rounded-md" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
            <input type="text" name="title" value="{{ old('title', $sop->title) }}"
                class="w-full px-3 py-2 border rounded-md" required>
        </div>

        <div class="grid grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                <select name="category" class="w-full px-3 py-2 border rounded-md">
                    @foreach(['Infrastructure', 'Security', 'Development', 'Helpdesk', 'General'] as $cat)
                    <option value="{{ $cat }}" @if(old('category', $sop->category) === $cat) selected @endif>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="w-full px-3 py-2 border rounded-md">
                    @foreach(['draft', 'review', 'approved', 'archived'] as $s)
                    <option value="{{ $s }}" @if(old('status', $sop->status) === $s) selected @endif>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Version</label>
                <input type="text" name="version" value="{{ old('version', $sop->version) }}" class="w-full px-3 py-2 border rounded-md">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Content</label>
            <textarea name="content" rows="10" class="w-full px-3 py-2 border rounded-md font-mono text-sm" required>{{ old('content', $sop->content) }}</textarea>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Update</button>
            <a href="{{ route('sops.index') }}" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md">Batal</a>
        </div>
    </form>
</div>
@stop