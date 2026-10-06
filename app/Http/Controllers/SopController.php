<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Sop;
use Illuminate\Http\Request;

class SopController extends Controller
{
    public function index()
    {
        $sops = Sop::with('author')->latest()->paginate(20);
        return view('sops.index', compact('sops'));
    }

    public function create()
    {
        return view('sops.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:sops,code',
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:50',
            'content' => 'required|string',
            'version' => 'required|string|max:20',
            'status' => 'required|string|in:draft,review,approved,archived',
            'attachment_path' => 'nullable|string|max:255',
        ]);

        $sop = Sop::create([
            ...$validated,
            'author_id' => auth()->id(),
        ]);

        return redirect()->route('sops.index')->with('success', 'SOP created.');
    }

    public function show(Sop $sop)
    {
        return view('sops.show', compact('sop'));
    }

    public function edit(Sop $sop)
    {
        return view('sops.edit', compact('sop'));
    }

    public function update(Request $request, Sop $sop)
    {
        $validated = $request->validate([
            'code' => 'sometimes|required|string|max:50|unique:sops,code,' . $sop->id,
            'title' => 'sometimes|required|string|max:255',
            'category' => 'sometimes|required|string|max:50',
            'content' => 'sometimes|required|string',
            'version' => 'sometimes|required|string|max:20',
            'status' => 'sometimes|required|string|in:draft,review,approved,archived',
            'attachment_path' => 'nullable|string|max:255',
        ]);

        $sop->update($validated);
        return redirect()->route('sops.index')->with('success', 'SOP updated.');
    }

    public function destroy(Sop $sop)
    {
        $sop->delete();
        return redirect()->route('sops.index')->with('success', 'SOP deleted.');
    }
}