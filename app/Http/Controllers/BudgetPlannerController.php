<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BudgetPlan;
use Illuminate\Http\Request;

class BudgetPlannerController extends Controller
{
    public function index()
    {
        $fy = request('fiscal_year', now()->year);
        $plans = BudgetPlan::where('fiscal_year', $fy)->latest()->paginate(20);
        return view('budget.index', compact('plans', 'fy'));
    }

    public function create()
    {
        return view('budget.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fiscal_year' => 'required|integer',
            'code' => 'required|string|max:50|unique:budget_plans,code',
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:50',
            'budget_type' => 'required|in:CAPEX,OPEX',
            'planned_amount' => 'required|numeric|min:0',
            'used_amount' => 'required|numeric|min:0',
            'priority' => 'required|in:low,medium,high,critical',
            'status' => 'required|in:proposed,approved,rejected,in_progress,completed',
            'notes' => 'nullable|string',
        ]);

        BudgetPlan::create($validated);
        return redirect()->route('budget.index')->with('success', 'Budget plan dibuat.');
    }

    public function show(BudgetPlan $budget)
    {
        return view('budget.show', compact('budget'));
    }

    public function edit(BudgetPlan $budget)
    {
        return view('budget.edit', compact('budget'));
    }

    public function update(Request $request, BudgetPlan $budget)
    {
        $validated = $request->validate([
            'fiscal_year' => 'sometimes|required|integer',
            'code' => 'sometimes|required|string|max:50|unique:budget_plans,code,' . $budget->id,
            'title' => 'sometimes|required|string|max:255',
            'category' => 'sometimes|required|string|max:50',
            'budget_type' => 'sometimes|required|in:CAPEX,OPEX',
            'planned_amount' => 'sometimes|required|numeric|min:0',
            'used_amount' => 'sometimes|required|numeric|min:0',
            'priority' => 'sometimes|required|in:low,medium,high,critical',
            'status' => 'sometimes|required|in:proposed,approved,rejected,in_progress,completed',
            'notes' => 'nullable|string',
        ]);

        $budget->update($validated);
        return redirect()->route('budget.index')->with('success', 'Budget plan diupdate.');
    }

    public function destroy(BudgetPlan $budget)
    {
        $budget->delete();
        return redirect()->route('budget.index')->with('success', 'Budget plan dihapus.');
    }

    public function summary()
    {
        $fy = (int) request('fiscal_year', now()->year);
        $totalPlanned = BudgetPlan::where('fiscal_year', $fy)->sum('planned_amount');
        $totalUsed    = BudgetPlan::where('fiscal_year', $fy)->sum('used_amount');
        $capexTotal   = BudgetPlan::where('fiscal_year', $fy)->where('budget_type', 'CAPEX')->sum('planned_amount');
        $opexTotal    = BudgetPlan::where('fiscal_year', $fy)->where('budget_type', 'OPEX')->sum('planned_amount');
        $capexUsed    = BudgetPlan::where('fiscal_year', $fy)->where('budget_type', 'CAPEX')->sum('used_amount');
        $opexUsed     = BudgetPlan::where('fiscal_year', $fy)->where('budget_type', 'OPEX')->sum('used_amount');

        return view('budget.summary-card', compact(
            'fy', 'totalPlanned', 'totalUsed',
            'capexTotal', 'opexTotal', 'capexUsed', 'opexUsed'
        ));
    }
}