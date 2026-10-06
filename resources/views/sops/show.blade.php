@extends('layouts.app')

@section('title', $sop->title)

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-start mb-6">
        <div>
            <h1 class="text-2xl font-bold">{{ $sop->title }}</h1>
            <p class="text-sm text-gray-500 mt-1">{{ $sop->code }} · {{ $sop->category }} · v{{ $sop->version }}</p>
        </div>
        <span class="px-3 py-1 text-sm rounded-full @if($sop->status === 'approved') bg-green-100 text-green-800 @elseif($sop->status === 'draft') bg-gray-100 text-gray-800 @else bg-yellow-100 text-yellow-800 @endif">
            {{ ucfirst($sop->status) }}
        </span>
    </div>

    <div class="bg-white rounded-lg shadow p-6 prose max-w-none">
        {!! $sop->content !!}
    </div>

    <div class="mt-4 flex gap-3">
        <a href="{{ route('sops.edit', $sop) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600 text-sm">Edit</a>
        <a href="{{ route('sops.index') }}" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-300 text-sm">Kembali</a>
    </div>
</div>
@stop