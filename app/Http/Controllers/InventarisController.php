<?php

namespace App\Http\Controllers;

use App\Models\InventarisItem;
use Illuminate\Http\Request;

class InventarisController extends Controller
{
    public function index(Request $request)
    {
        $kategori = $request->get('kategori');
        $query = InventarisItem::query();
        if ($kategori) {
            $query->where('kategori', $kategori);
        }
        $items = $query->latest()->paginate(20);
        $kategoris = ['Hardware', 'Software', 'Network', 'Peripheral', 'Furniture', 'Lainnya'];

        return view('inventaris.index', compact('items', 'kategoris', 'kategori'));
    }

    public function create()
    {
        return view('inventaris.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode' => 'required|string|max:50|unique:inventaris_items,kode',
            'nama' => 'required|string|max:255',
            'kategori' => 'required|string|max:50',
            'spesifikasi' => 'nullable|string',
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat,Dibuang',
            'lokasi' => 'nullable|string|max:255',
            'tanggal_beli' => 'nullable|date',
            'nilai' => 'required|numeric|min:0',
            'catatan' => 'nullable|string',
        ]);

        InventarisItem::create($validated);

        return redirect()->route('inventaris.index')->with('success', 'Item inventaris ditambahkan.');
    }

    public function show(InventarisItem $inventaris)
    {
        return view('inventaris.show', compact('inventaris'));
    }

    public function edit(InventarisItem $inventaris)
    {
        return view('inventaris.edit', compact('inventaris'));
    }

    public function update(Request $request, InventarisItem $inventaris)
    {
        $validated = $request->validate([
            'kode' => 'sometimes|required|string|max:50|unique:inventaris_items,kode,'.$inventaris->id,
            'nama' => 'sometimes|required|string|max:255',
            'kategori' => 'sometimes|required|string|max:50',
            'spesifikasi' => 'nullable|string',
            'kondisi' => 'sometimes|required|in:Baik,Rusak Ringan,Rusak Berat,Dibuang',
            'lokasi' => 'nullable|string|max:255',
            'tanggal_beli' => 'nullable|date',
            'nilai' => 'sometimes|required|numeric|min:0',
            'catatan' => 'nullable|string',
        ]);

        $inventaris->update($validated);

        return redirect()->route('inventaris.index')->with('success', 'Item inventaris diupdate.');
    }

    public function destroy(InventarisItem $inventaris)
    {
        $inventaris->delete();

        return redirect()->route('inventaris.index')->with('success', 'Item inventaris dihapus.');
    }
}
