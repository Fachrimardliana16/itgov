<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use App\Models\ToolLoan;
use App\Models\User;
use Illuminate\Http\Request;

class ToolController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status');
        $kategori = $request->get('kategori');
        $query = Tool::query();
        if ($status) {
            $query->where('status', $status);
        }
        if ($kategori) {
            $query->where('kategori', $kategori);
        }
        $tools = $query->latest()->paginate(20);
        $statuses = ['tersedia', 'dipinjam', 'perbaikan', 'hilang'];
        $kategoris = ['Tester', 'Handtool', 'Measurement', 'Cleaning', 'Lainnya'];

        return view('tools.index', compact('tools', 'statuses', 'kategoris', 'status', 'kategori'));
    }

    public function create()
    {
        return view('tools.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode' => 'required|string|max:50|unique:tools,kode',
            'nama' => 'required|string|max:255',
            'kategori' => 'required|string|max:50',
            'status' => 'required|in:tersedia,dipinjam,perbaikan,hilang',
            'catatan' => 'nullable|string',
        ]);

        Tool::create($validated);

        return redirect()->route('tools.index')->with('success', 'Tool ditambahkan.');
    }

    public function show(Tool $tool)
    {
        $loans = $tool->loans()->with('user')->latest()->paginate(10);

        return view('tools.show', compact('tool', 'loans'));
    }

    public function edit(Tool $tool)
    {
        return view('tools.edit', compact('tool'));
    }

    public function update(Request $request, Tool $tool)
    {
        $validated = $request->validate([
            'kode' => 'sometimes|required|string|max:50|unique:tools,kode,'.$tool->id,
            'nama' => 'sometimes|required|string|max:255',
            'kategori' => 'sometimes|required|string|max:50',
            'status' => 'sometimes|required|in:tersedia,dipinjam,perbaikan,hilang',
            'catatan' => 'nullable|string',
        ]);

        $tool->update($validated);

        return redirect()->route('tools.index')->with('success', 'Tool diupdate.');
    }

    public function destroy(Tool $tool)
    {
        if ($tool->loans()->where('status', 'dipinjam')->exists()) {
            return back()->with('error', 'Tool masih dipinjam, tidak bisa dihapus.');
        }
        $tool->delete();

        return redirect()->route('tools.index')->with('success', 'Tool dihapus.');
    }

    // Pinjam (borrow)
    public function pinjam(Tool $tool)
    {
        if ($tool->status !== 'tersedia') {
            return back()->with('error', 'Tool tidak tersedia untuk dipinjam.');
        }
        $users = User::where('is_blocked', false)->orderBy('name')->get();

        return view('tools.pinjam', compact('tool', 'users'));
    }

    public function storePinjam(Request $request, Tool $tool)
    {
        if ($tool->status !== 'tersedia') {
            return back()->with('error', 'Tool tidak tersedia untuk dipinjam.');
        }

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_rencana_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'catatan_pinjam' => 'nullable|string',
        ]);

        $loan = ToolLoan::create([
            'tool_id' => $tool->id,
            'user_id' => $validated['user_id'],
            'tanggal_pinjam' => $validated['tanggal_pinjam'],
            'tanggal_rencana_kembali' => $validated['tanggal_rencana_kembali'],
            'status' => 'dipinjam',
            'catatan_pinjam' => $validated['catatan_pinjam'] ?? null,
        ]);

        $tool->update(['status' => 'dipinjam']);

        return redirect()->route('tools.show', $tool)->with('success', 'Tool dipinjam oleh '.$loan->user->name);
    }

    // Kembalikan (return)
    public function kembalikan(ToolLoan $loan)
    {
        if ($loan->status !== 'dipinjam') {
            return back()->with('error', 'Pinjaman ini sudah dikembalikan atau dibatalkan.');
        }

        return view('tools.kembalikan', compact('loan'));
    }

    public function updateKembalikan(Request $request, ToolLoan $loan)
    {
        if ($loan->status !== 'dipinjam') {
            return back()->with('error', 'Pinjaman ini sudah dikembalikan atau dibatalkan.');
        }

        $validated = $request->validate([
            'tanggal_kembali_aktual' => 'required|date',
            'catatan_kembali' => 'nullable|string',
        ]);

        $loan->update([
            'tanggal_kembali_aktual' => $validated['tanggal_kembali_aktual'],
            'status' => 'dikembalikan',
            'catatan_kembali' => $validated['catatan_kembali'] ?? null,
        ]);

        $loan->tool->update(['status' => 'tersedia']);

        return redirect()->route('tools.show', $loan->tool)->with('success', 'Tool dikembalikan.');
    }
}
