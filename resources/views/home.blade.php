@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">IT Governance Center</h1>
    <p class="text-gray-600 mt-1">Sistem pengelolaan SOP, Vault Kredensial, dan Budget IT</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    {{-- SOP Module --}}
    <a href="{{ route('sops.index') }}" class="block p-6 bg-white rounded-lg shadow hover:shadow-lg border-l-4 border-blue-500">
        <h2 class="text-xl font-semibold text-gray-900">📋 IT SOP Documentation</h2>
        <p class="text-sm text-gray-500 mt-1">Kelola & otomasi dokumentasi SOP IT</p>
        <p class="text-xs text-gray-400 mt-4">Status: {{ \App\Models\Sop::count() }} SOP</p>
    </a>

    {{-- Vault Module --}}
    <a href="{{ route('vault.index') }}" class="block p-6 bg-white rounded-lg shadow hover:shadow-lg border-l-4 border-red-500">
        <h2 class="text-xl font-semibold text-gray-900">🔐 Credential Vault</h2>
        <p class="text-sm text-gray-500 mt-1">Enkripsi AES-256-GCM, audit trail</p>
        <p class="text-xs text-gray-400 mt-4">Status: {{ \App\Models\Credential::count() }} kredensial</p>
    </a>

    {{-- Budget Module --}}
    <a href="{{ route('budget.index') }}" class="block p-6 bg-white rounded-lg shadow hover:shadow-lg border-l-4 border-green-500">
        <h2 class="text-xl font-semibold text-gray-900">💰 IT Budget Planner</h2>
        <p class="text-sm text-gray-500 mt-1">CAPEX / OPEX, planning & tracking</p>
        <p class="text-xs text-gray-400 mt-4">Tahun {{ now()->year }}: {{ number_format(\App\Models\BudgetPlan::where('fiscal_year', now()->year)->sum('planned_amount'), 0, ',', '.') }}</p>
    </a>
</div>

{{-- Quick Budget Summary --}}
@php
    $fy = now()->year;
    $total = \App\Models\BudgetPlan::where('fiscal_year', $fy)->sum('planned_amount');
    $used  = \App\Models\BudgetPlan::where('fiscal_year', $fy)->sum('used_amount');
    $capex = \App\Models\BudgetPlan::where('fiscal_year', $fy)->where('budget_type', 'CAPEX')->sum('planned_amount');
    $opex  = \App\Models\BudgetPlan::where('fiscal_year', $fy)->where('budget_type', 'OPEX')->sum('planned_amount');
@endphp
<div class="bg-white rounded-lg shadow p-6">
    <h3 class="text-lg font-semibold mb-4">📊 Budget Overview {{ $fy }}</h3>
    <div class="grid grid-cols-3 gap-4 text-center mb-4">
        <div>
            <p class="text-2xl font-bold text-blue-600">Rp {{ number_format($total, 0, ',', '.') }}</p>
            <p class="text-xs text-gray-500">Total Allocation</p>
        </div>
        <div>
            <p class="text-2xl font-bold text-orange-600">Rp {{ number_format($used, 0, ',', '.') }}</p>
            <p class="text-xs text-gray-500">Total Used</p>
        </div>
        <div>
            <p class="text-2xl font-bold text-green-600">Rp {{ number_format($total - $used, 0, ',', '.') }}</p>
            <p class="text-xs text-gray-500">Remaining</p>
        </div>
    </div>
    @if($total > 0)
    <div class="space-y-2">
        <div class="flex items-center gap-2">
            <span class="text-xs w-14">CAPEX</span>
            <div class="flex-1 bg-gray-200 rounded-full h-2">
                <div class="bg-blue-500 h-2 rounded-full" style="width: {{ ($capex/$total)*100 }}%"></div>
            </div>
            <span class="text-xs font-mono">{{ round(($capex/$total)*100) }}%</span>
        </div>
        <div class="flex items-center gap-2">
            <span class="text-xs w-14">OPEX</span>
            <div class="flex-1 bg-gray-200 rounded-full h-2">
                <div class="bg-green-500 h-2 rounded-full" style="width: {{ ($opex/$total)*100 }}%</div>
            </div>
            <span class="text-xs font-mono">{{ round(($opex/$total)*100) }}%</span>
        </div>
    </div>
    @endif
</div>
@stop