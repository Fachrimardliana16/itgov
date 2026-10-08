<?php

namespace App\Http\Controllers;

use App\Models\RkapPlan;
use Illuminate\Http\Request;

class RkapPlannerController extends Controller
{
    public function index(Request $request)
    {
        $fy = $request->get('fiscal_year', now()->year);
        $plans = RkapPlan::where('fiscal_year', $fy)->latest()->paginate(20);
        $totalPlanned = RkapPlan::where('fiscal_year', $fy)->sum('planned_amount');
        $totalUsed = RkapPlan::where('fiscal_year', $fy)->sum('used_amount');
        $kategoriTotals = RkapPlan::where('fiscal_year', $fy)
            ->selectRaw('kategori, sum(planned_amount) as total')
            ->groupBy('kategori')
            ->pluck('total', 'kategori');

        return view('rkap.index', compact('plans', 'fy', 'totalPlanned', 'totalUsed', 'kategoriTotals'));
    }

    public function summary(Request $request)
    {
        $fy = $request->get('fiscal_year', now()->year);
        $plans = RkapPlan::where('fiscal_year', $fy);
        $totalPlanned = $plans->sum('planned_amount');
        $totalUsed = $plans->sum('used_amount');
        $remaining = $totalPlanned - $totalUsed;
        $realizedPct = $totalPlanned > 0 ? round($totalUsed / $totalPlanned * 100) : 0;
        $kategoriTotals = RkapPlan::where('fiscal_year', $fy)
            ->selectRaw('kategori, sum(planned_amount) as total')
            ->groupBy('kategori')
            ->pluck('total', 'kategori');

        return view('rkap.summary-card', compact('fy', 'totalPlanned', 'totalUsed', 'remaining', 'realizedPct', 'kategoriTotals'));
    }

    public function create()
    {
        return view('rkap.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fiscal_year' => 'required|integer',
            'kode' => 'required|string|max:50|unique:rkap_plans,kode',
            'kegiatan' => 'required|string|max:255',
            'kategori' => 'required|string|max:50',
            'belanja' => 'required|string|max:50',
            'planned_amount' => 'required|numeric|min:0',
            'used_amount' => 'required|numeric|min:0',
            'prioritas' => 'required|in:rendah,sedang,tinggi,kritis',
            'status' => 'required|in:draft,diajukan,disetujui,ditolak,proses,selesai',
            'catatan' => 'nullable|string',
        ]);

        RkapPlan::create($validated);

        return redirect()->route('rkap.index')->with('success', 'Rencana RKAP dibuat.');
    }

    public function show(RkapPlan $rkap)
    {
        return view('rkap.show', compact('rkap'));
    }

    public function edit(RkapPlan $rkap)
    {
        return view('rkap.edit', compact('rkap'));
    }

    public function update(Request $request, RkapPlan $rkap)
    {
        $validated = $request->validate([
            'fiscal_year' => 'sometimes|required|integer',
            'kode' => 'sometimes|required|string|max:50|unique:rkap_plans,kode,'.$rkap->id,
            'kegiatan' => 'sometimes|required|string|max:255',
            'kategori' => 'sometimes|required|string|max:50',
            'belanja' => 'sometimes|required|string|max:50',
            'planned_amount' => 'sometimes|required|numeric|min:0',
            'used_amount' => 'sometimes|required|numeric|min:0',
            'prioritas' => 'sometimes|required|in:rendah,sedang,tinggi,kritis',
            'status' => 'sometimes|required|in:draft,diajukan,disetujui,ditolak,proses,selesai',
            'catatan' => 'nullable|string',
        ]);

        $rkap->update($validated);

        return redirect()->route('rkap.index')->with('success', 'Rencana RKAP diupdate.');
    }

    public function destroy(RkapPlan $rkap)
    {
        $rkap->delete();

        return redirect()->route('rkap.index')->with('success', 'Rencana RKAP dihapus.');
    }
}
