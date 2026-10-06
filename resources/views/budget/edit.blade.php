@extends('layouts.app')
@section('title', 'Edit Budget Plan: ' . $budget->code)
@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">Edit Budget Plan {{ $budget->code }}</h1>
    <form method="POST" action="{{ route('budget.update', $budget) }}" class="bg-white rounded-lg shadow p-6 space-y-4">
        @csrf @method('PUT')
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Fiscal Year *</label>
                <input type="number" name="fiscal_year" value="{{ old('fiscal_year', $budget->fiscal_year) }}"
                    class="w-full px-3 py-2 border rounded-md" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Code *</label>
                <input type="text" name="code" value="{{ old('code', $budget->code) }}"
                    class="w-full px-3 py-2 border rounded-md" required>
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Title *</label>
            <input type="text" name="title" value="{{ old('title', $budget->title) }}"
                class="w-full px-3 py-2 border rounded-md" required>
        </div>
        <div class="grid grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                <select name="category" class="w-full px-3 py-2 border rounded-md">
                    @foreach(['License', 'Hardware', 'SLA_Maintenance', 'Internet_Cloud', 'Training'] as $cat)
                    <option value="{{ $cat }}" @if(old('category', $budget->category) === $cat) selected @endif>{{ str_replace('_', ' ', $cat) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Budget Type</label>
                <select name="budget_type" class="w-full px-3 py-2 border rounded-md">
                    @foreach(['OPEX', 'CAPEX'] as $bt)
                    <option value="{{ $bt }}" @if(old('budget_type', $budget->budget_type) === $bt) selected @endif>{{ $bt }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Priority</label>
                <select name="priority" class="w-full px-3 py-2 border rounded-md">
                    @foreach(['low', 'medium', 'high', 'critical'] as $p)
                    <option value="{{ $p }}" @if(old('priority', $budget->priority) === $p) selected @endif>{{ ucfirst($p) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Planned Amount (Rp) *</label>
                <input type="number" name="planned_amount" value="{{ old('planned_amount', $budget->planned_amount) }}"
                    class="w-full px-3 py-2 border rounded-md" min="0" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Used Amount (Rp)</label>
                <input type="number" name="used_amount" value="{{ old('used_amount', $budget->used_amount) }}"
                    class="w-full px-3 py-2 border rounded-md" min="0">
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select name="status" class="w-full px-3 py-2 border rounded-md">
                @foreach(['proposed', 'approved', 'rejected', 'in_progress', 'completed'] as $s)
                <option value="{{ $s }}" @if(old('status', $budget->status) === $s) selected @endif>{{ ucfirst(str_replace('_', ' ', $s)) }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
            <textarea name="notes" rows="3" class="w-full px-3 py-2 border rounded-md">{{ old('notes', $budget->notes) }}</textarea>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Update</button>
            <a href="{{ route('budget.index') }}" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md">Batal</a>
        </div>
    </form>
</div>
@stop