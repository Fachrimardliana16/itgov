@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">📋 IT SOP Documentation</h1>
    <a href="{{ route('sops.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 text-sm">+ SOP Baru</a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Code</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Version</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Author</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse ($sops as $sop)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 text-sm font-mono text-gray-900">{{ $sop->code }}</td>
                <td class="px-4 py-3 text-sm text-gray-900">{{ $sop->title }}</td>
                <td class="px-4 py-3 text-sm text-gray-500">{{ $sop->category }}</td>
                <td class="px-4 py-3 text-sm">
                    <span class="px-2 py-1 text-xs rounded-full @if($sop->status === 'approved') bg-green-100 text-green-800 @elseif($sop->status === 'draft') bg-gray-100 text-gray-800 @else bg-yellow-100 text-yellow-800 @endif">
                        {{ ucfirst($sop->status) }}
                    </span>
                </td>
                <td class="px-4 py-3 text-sm text-gray-500">{{ $sop->version }}</td>
                <td class="px-4 py-3 text-sm text-gray-500">{{ $sop->author?->name ?? 'N/A' }}</td>
                <td class="px-4 py-3 text-sm flex gap-2">
                    <a href="{{ route('sops.show', $sop) }}" class="text-blue-600 hover:underline text-xs">View</a>
                    <a href="{{ route('sops.edit', $sop) }}" class="text-yellow-600 hover:underline text-xs">Edit</a>
                    <form method="POST" action="{{ route('sops.destroy', $sop) }}" onsubmit="return confirm('Yakin hapus?')" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline text-xs">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-4 py-6 text-center text-gray-500 text-sm">Belum ada SOP.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $sops->links() }}</div>
@stop