@extends('layouts.app')
@section('title', 'Tambah Budget Plan')
@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">💰 Tambah Budget Plan</h1>
    <form method="POST" action="{{ route('budget.store') }}" class="bg-white rounded-lg shadow p-6 space-y-4">
        @csrf
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Fiscal Year *</label>
                <input type="number" name="fiscal_year" value="{{ old('fiscal_year', now()->year) }}"
                    class="w-full px-3 py-2 border rounded-md" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Code *</label>
                <input type="text" name="code" value="{{ old('code', 'BGT-' . now()->year . '-') }}"
                    class="w-full px-3 py-2 border rounded-md" required>
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Title *</label>
            <input type="text" name="title" value="{{ old('title') }}"
                class="w-full px-3 py-2 border rounded-md" required>
        </div>
        <div class="grid grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Category *</label>
                <select name="category" class="w-full px-3 py-2 border rounded-md" required>
                    @foreach(['License', 'Hardware', 'SLA_Maintenance', 'Internet_Cloud', 'Training'] as $cat)
                    <option value="{{ $cat }}">{{ str_replace('_', ' ', $cat) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Budget Type *</label>
                <select name="budget_type" class="w-full px-3 py-2 border rounded-md" required>
                    <option value="OPEX">OPEX</option>
                    <option value="CAPEX">CAPEX</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Priority *</label>
                <select name="priority" class="w-full px-3 py-2 border rounded-md">
                    <option value="low">Low</option>
                    <option value="medium" selected>Medium</option>
                    <option value="high">High</option>
                    <option value="critical">Critical</option>
                </select>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Planned Amount (Rp) *</label>
                <input type="number" name="planned_amount" value="{{ old('planned_amount', 0) }}"
                    class="w-full px-3 py-2 border rounded-md" min="0" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Used Amount (Rp)</label>
                <input type="number" name="used_amount" value="{{ old('used_amount', 0) }}"
                    class="w-full px-3 py-2 border rounded-md" min="0">
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select name="status" class="w-full px-3 py-2 border rounded-md">
                @foreach(['proposed', 'approved', 'rejected', 'in_progress', 'completed'] as $s)
                <option value="{{ $s }}">{{ ucfirst(str_replace('_', ' ', $s)) }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
            <textarea name="notes" rows="3" class="w-full px-3 py-2 border rounded-md">{{ old('notes') }}</textarea>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">Simpan</button>
            <a href="{{ route('budget.index') }}" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md">Batal</a>
        </div>
    </form>
</div>
@stop