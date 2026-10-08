@extends('layouts.app')

@section('title', $sop->title)

@section('content')

<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <nav class="text-xs text-soil-400 mb-3" aria-label="Breadcrumb">
            <a href="{{ route('sops.index') }}" class="hover:text-soil-700">SOP</a>
            <span class="mx-1.5" aria-hidden="true">/</span>
            <span class="text-soil-500 font-mono">{{ $sop->code }}</span>
        </nav>

        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <h1 class="page-title">{{ $sop->title }}</h1>
                <p class="page-subtitle">
                    {{ $sop->category }} · versi {{ $sop->version }} · ditulis oleh {{ $sop->author?->name ?? '—' }}
                </p>
            </div>
            <span @class([
                'badge-green'  => $sop->status === 'approved',
                'badge-amber'   => $sop->status === 'review',
                'badge-neutral' => in_array($sop->status, ['draft', 'archived'], true),
            ])>{{ ucfirst($sop->status) }}</span>
        </div>
    </div>

    <article class="panel p-6 sm:p-8">
        <div class="prose prose-sm max-w-none prose-headings:font-display prose-headings:text-soil-800
                    prose-p:text-soil-600 prose-a:text-crop-700 prose-code:text-soil-700
                    prose-pre:bg-soil-50 prose-pre:border prose-pre:border-soil-200
                    prose-table:text-sm prose-th:text-soil-600">
            {!! $sop->content !!}
        </div>
    </article>

    <div class="mt-6 flex flex-wrap gap-3">
        <a href="{{ route('sops.edit', $sop) }}" class="btn-primary">Edit SOP</a>
        <a href="{{ route('sops.index') }}" class="btn-quiet">Kembali ke daftar</a>
    </div>
</div>

@endsection