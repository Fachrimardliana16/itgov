<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Credential;
use App\Models\CredentialAccessLog;
use Illuminate\Http\Request;

class CredentialVaultController extends Controller
{
    public function index()
    {
        $credentials = Credential::latest()->paginate(20);
        return view('vault.index', compact('credentials'));
    }

    public function create()
    {
        return view('vault.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:50',
            'host_or_url' => 'nullable|string|max:255',
            'username_encrypted' => 'required|string',
            'password_encrypted' => 'required|string',
            'additional_secret_encrypted' => 'nullable|string',
            'notes_encrypted' => 'nullable|string',
        ]);

        $credential = Credential::create($validated);

        CredentialAccessLog::create([
            'credential_id' => $credential->id,
            'user_id' => auth()->id(),
            'action' => 'CREATE',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('vault.index')->with('success', 'Kredensial disimpan.');
    }

    public function show(Credential $credential)
    {
        return view('vault.show', compact('credential'));
    }

    public function edit(Credential $credential)
    {
        return view('vault.edit', compact('credential'));
    }

    public function update(Request $request, Credential $credential)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'category' => 'sometimes|required|string|max:50',
            'host_or_url' => 'nullable|string|max:255',
            'username_encrypted' => 'sometimes|required|string',
            'password_encrypted' => 'sometimes|required|string',
            'additional_secret_encrypted' => 'nullable|string',
            'notes_encrypted' => 'nullable|string',
        ]);

        $credential->update($validated);

        CredentialAccessLog::create([
            'credential_id' => $credential->id,
            'user_id' => auth()->id(),
            'action' => 'UPDATE',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('vault.index')->with('success', 'Kredensial diupdate.');
    }

    public function destroy(Credential $credential)
    {
        CredentialAccessLog::create([
            'credential_id' => $credential->id,
            'user_id' => auth()->id(),
            'action' => 'DELETE',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        $credential->delete();
        return redirect()->route('vault.index')->with('success', 'Kredensial dihapus.');
    }

    /**
     * Reveal decrypted credential — requires password verification (sudo mode).
     * Returns decrypted data + sets 15s expiry for auto-mask.
     */
    public function reveal(Request $request, Credential $credential)
    {
        $request->validate(['password' => 'required|string']);

        // Sudo mode: verifikasi password user yang login
        if (!\Illuminate\Support\Facades\Hash::check($request->password, auth()->user()->password)) {
            return response()->json(['error' => 'Password salah.'], 403);
        }

        // Ambil nilai PLENKTEKS via accessors (decrypted by EncryptedAttribute cast)
        $username = $credential->username_encrypted;
        $password = $credential->password_encrypted;
        $secret   = $credential->additional_secret_encrypted;
        $notes    = $credential->notes_encrypted;

        // Audit log
        CredentialAccessLog::create([
            'credential_id' => $credential->id,
            'user_id' => auth()->id(),
            'action' => 'VIEW_PASSWORD',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return response()->json([
            'username' => $username,
            'password' => $password,
            'additional_secret' => $secret,
            'notes' => $notes,
            'expires_at' => now()->addSeconds(15)->toISOString(),
        ]);
    }
}