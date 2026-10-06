@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">💰 IT Budget Planner</h1>
    <div class="flex gap-3 items-center">
        <form method="GET" class="flex gap-2">
            <select name="fiscal_year" onchange="this.form.submit()"
                class="px-3 py-2 border rounded-md text-sm">
                @for($y = now()->year; $y >= now()->year - 5; $y--)
                <option value="{{ $y }}" @if(($fy ?? now()->year) == $y) selected @endif>{{ $y }}</option>
                @endfor
            </select>
        </form>
        <a href="{{ route('budget.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 text-sm">+ Budget Baru</a>
    </div>
</div>

{{-- Summary Card --}}
@include('budget.summary-card')

<div class="bg-white rounded-lg shadow overflow-hidden mt-6">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Code</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Planned</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Used</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sisa</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Priority</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse ($plans as $plan)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 text-sm font-mono text-gray-900">{{ $plan->code }}</td>
                <td class="px-4 py-3 text-sm text-gray-900">{{ $plan->title }}</td>
                <td class="px-4 py-3 text-sm">
                    <span class="px-2 py-1 text-xs rounded-full {{ $plan->budget_type === 'CAPEX' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                        {{ $plan->budget_type }}
                    </span>
                </td>
                <td class="px-4 py-3 text-sm text-gray-900">Rp {{ number_format($plan->planned_amount, 0, ',', '.') }}</td>
                <td class="px-4 py-3 text-sm text-orange-600">Rp {{ number_format($plan->used_amount, 0, ',', '.') }}</td>
                <td class="px-4 py-3 text-sm {{ ($plan->planned_amount - $plan->used_amount) < 0 ? 'text-red-600' : 'text-green-600' }}">
                    Rp {{ number_format($plan->planned_amount - $plan->used_amount, 0, ',', '.') }}
                </td>
                <td class="px-4 py-3 text-sm">
                    <span class="px-2 py-1 text-xs rounded-full
                        @if($plan->priority === 'critical') bg-red-100 text-red-800
                        @elseif($plan->priority === 'high') bg-orange-100 text-orange-800
                        @elseif($plan->priority === 'medium') bg-yellow-100 text-yellow-800
                        @else bg-gray-100 text-gray-800 @endif">
                        {{ ucfirst($plan->priority) }}
                    </span>
                </td>
                <td class="px-4 py-3 text-sm">
                    <span class="px-2 py-1 text-xs rounded-full
                        @if($plan->status === 'completed') bg-green-100 text-green-800
                        @elseif($plan->status === 'approved') bg-blue-100 text-blue-800
                        @elseif($plan->status === 'in_progress') bg-yellow-100 text-yellow-800
                        @else bg-gray-100 text-gray-800 @endif">
                        {{ ucfirst(str_replace('_', ' ', $plan->status)) }}
                    </span>
                </td>
                <td class="px-4 py-3 text-sm flex gap-2">
                    <a href="{{ route('budget.edit', $plan) }}" class="text-yellow-600 hover:underline text-xs">Edit</a>
                    <form method="POST" action="{{ route('budget.destroy', $plan) }}" onsubmit="return confirm('Yakin?')" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline text-xs">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="px-4 py-6 text-center text-gray-500 text-sm">Belum ada budget plan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $plans->appends(['fiscal_year' => $fy ?? now()->year])->links() }}</div>
@stop