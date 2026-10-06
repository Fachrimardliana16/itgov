@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">🔐 Credential Vault</h1>
    <a href="{{ route('vault.create') }}" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 text-sm">+ Kredensial Baru</a>
</div>

@if(session('success'))
    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">{{ session('success') }}</div>
@endif

<div class="bg-white rounded-lg shadow overflow-hidden mb-6">
    <div class="p-4 border-b bg-red-50">
        <p class="text-xs text-red-600 font-medium">🔒 Semua kredensial terenkripsi AES-256-GCM. Password hanya terlihat 15 detik.</p>
    </div>

    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Host/URL</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Username</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse ($credentials as $cred)
            <tr class="hover:bg-gray-50" x-data="{ show: false, revealData: null }">
                <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $cred->title }}</td>
                <td class="px-4 py-3 text-sm text-gray-500">{{ $cred->category }}</td>
                <td class="px-4 py-3 text-sm text-gray-500 text-xs">{{ $cred->host_or_url ?? '-' }}</td>
                <td class="px-4 py-3 text-sm font-mono text-gray-400">••••••••••</td>
                <td class="px-4 py-3 text-sm flex gap-2">
                    <button @click="show = true"
                        class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs hover:bg-gray-200">
                        Reveal
                    </button>
                    <a href="{{ route('vault.edit', $cred) }}" class="text-yellow-600 hover:underline text-xs">Edit</a>
                    <form method="POST" action="{{ route('vault.destroy', $cred) }}" onsubmit="return confirm('Yakin hapus?')" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline text-xs">Delete</button>
                    </form>
                </td>
            </tr>

            {{-- Alpine.js reveal modal --}}
            <tr x-show="show" x-cloak>
                <td colspan="5" class="px-4 py-4 bg-gray-100">
                    <div x-data="{
                        password: '',
                        data: null,
                        timer: 15,
                        error: '',
                        async reveal() {
                            let resp = await fetch('/vault/{{ $cred->id }}/reveal', {
                                method: 'POST',
                                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json', 'Accept': 'application/json' },
                                body: JSON.stringify({ password: this.password })
                            });
                            let j = await resp.json();
                            if (j.error) { this.error = j.error; return; }
                            this.data = j;
                            this.error = '';
                            this.password = '';
                            this.timer = 15;
                            let iv = setInterval(() => { this.timer--; if (this.timer <= 0) { this.data = null; clearInterval(iv); } }, 1000);
                        }
                    }" class="space-y-3">
                        <p class="text-sm font-medium text-gray-700">Masukkan password untuk reveal (otomatis mask 15 detik):</p>
                        <div class="flex gap-2" x-show="!data">
                            <input type="password" x-model="password" placeholder="Password akun kamu"
                                class="flex-1 px-3 py-2 border rounded-md text-sm">
                            <button @click="reveal()" class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm hover:bg-blue-700">Reveal</button>
                        </div>
                        <p class="text-red-500 text-sm" x-text="error" x-show="error"></p>
                        <div x-show="data" class="grid grid-cols-2 gap-4 text-sm">
                            <div><span class="text-gray-500">Username:</span>
                                <code class="block bg-white px-2 py-1 rounded mt-1" x-text="data ? data.username : ''"></code>
                            </div>
                            <div><span class="text-gray-500">Password:</span>
                                <code class="block bg-white px-2 py-1 rounded mt-1" x-text="data ? data.password : ''"></code>
                            </div>
                            <div x-show="data?.additional_secret"><span class="text-gray-500">Secret:</span>
                                <code class="block bg-white px-2 py-1 rounded mt-1" x-text="data ? (data.additional_secret || '-') : ''"></code>
                            </div>
                        </div>
                        <p class="text-xs text-gray-400" x-show="data">
                            Auto-mask dalam <span x-text="timer"></span> detik.
                            <button @click="data = null; timer = 0" class="underline ml-2">Clear</button>
                        </p>
                        <button @click="show = false; data = null" class="text-sm text-gray-500 hover:underline">Tutup</button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-4 py-6 text-center text-gray-500 text-sm">Belum ada kredensial.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $credentials->links() }}</div>
@stop