@extends('layouts.app')

@section('title', 'Credential Vault')

@php
    $catStyle = [
        'Server'          => 'badge-neutral',
        'Database'        => 'badge-green',
        'Network'         => 'badge-amber',
        'SaaS'            => 'bg-sky-100 text-sky-500',
        'ServiceAccount'  => 'bg-crop-100 text-crop-800',
    ];
@endphp

@section('content')

<div class="mb-6 flex flex-wrap items-end justify-between gap-4">
    <div>
        <h1 class="page-title">Credential Vault</h1>
        <p class="page-subtitle">Gudang kredensial terenkripsi. Butuh password akun Anda untuk membuka isi.</p>
    </div>
    <a href="{{ route('vault.create') }}" class="btn-ember">+ Kredensial Baru</a>
</div>

<div class="mb-5 flex items-start gap-3 px-4 py-3 rounded-xl bg-ember-50 border border-ember-200">
    <span class="mt-0.5 shrink-0 text-ember-500" aria-hidden="true">⚿</span>
    <p class="text-sm text-ember-700">
        Seluruh kredensial disimpan dengan enkripsi <strong>AES-256-GCM</strong>. Setiap akses tercatat pada audit trail,
        dan nilai yang di-reveal otomatis tersamar kembali setelah 15 detik.
    </p>
</div>

<div class="panel overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="table-head">
                <tr>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Host / URL</th>
                    <th>Username</th>
                    <th class="!text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="table-body">
                @forelse ($credentials as $cred)
                    <tr x-data="{ show: false, revealData: null }">
                        <td class="font-medium text-soil-800">{{ $cred->title }}</td>
                        <td>
                            <span class="{{ $catStyle[$cred->category] ?? 'badge-neutral' }}">{{ $cred->category }}</span>
                        </td>
                        <td class="text-xs font-mono text-soil-500">{{ $cred->host_or_url ?? '—' }}</td>
                        <td class="font-mono text-xs text-soil-400 tracking-widest" aria-label="Tersamar">••••••••••</td>
                        <td>
                            <div class="flex items-center justify-end gap-3">
                                <button type="button" @click="show = true" class="action-link">Reveal</button>
                                <a href="{{ route('vault.edit', $cred) }}" class="action-link">Edit</a>
                                <form method="POST" action="{{ route('vault.destroy', $cred) }}"
                                      onsubmit="return confirm('Yakin menghapus kredensial ini?')" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="action-link action-link-danger">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    {{-- Reveal panel — Alpine state and fetch contract unchanged --}}
                    <tr x-show="show" x-cloak>
                        <td colspan="5" class="bg-soil-50">
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
                            }" class="space-y-4 py-2">
                                <p class="text-sm font-medium text-soil-700">Masukkan password akun Anda untuk membuka kredensial ini.</p>

                                <div class="flex flex-wrap gap-2" x-show="!data">
                                    <input type="password" x-model="password" placeholder="Password akun Anda"
                                           class="field flex-1 min-w-[12rem] max-w-sm" @keydown.enter="reveal()">
                                    <button type="button" @click="reveal()" class="btn-primary">Buka</button>
                                </div>

                                <p class="field-error" x-text="error" x-show="error"></p>

                                <div x-show="data" class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <span class="stat-label !mt-0 block">Username</span>
                                        <code class="block mt-1 px-2.5 py-1.5 bg-white border border-soil-200 rounded-md font-mono text-xs text-soil-800 break-all"
                                              x-text="data ? data.username : ''"></code>
                                    </div>
                                    <div>
                                        <span class="stat-label !mt-0 block">Password</span>
                                        <code class="block mt-1 px-2.5 py-1.5 bg-white border border-soil-200 rounded-md font-mono text-xs text-soil-800 break-all"
                                              x-text="data ? data.password : ''"></code>
                                    </div>
                                    <div x-show="data?.additional_secret" class="sm:col-span-2">
                                        <span class="stat-label !mt-0 block">Secret / API Key</span>
                                        <code class="block mt-1 px-2.5 py-1.5 bg-white border border-soil-200 rounded-md font-mono text-xs text-soil-800 break-all"
                                              x-text="data ? (data.additional_secret || '-') : ''"></code>
                                    </div>
                                </div>

                                <div class="flex flex-wrap items-center gap-3">
                                    <p class="text-xs text-soil-400" x-show="data">
                                        Tersamar otomatis dalam <span class="font-mono font-medium text-ember-600" x-text="timer"></span> detik.
                                        <button type="button" @click="data = null; timer = 0" class="underline ml-2 hover:text-soil-700">Sembunyikan sekarang</button>
                                    </p>
                                    <button type="button" @click="show = false; data = null" class="action-link ml-auto">Tutup</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-16 text-center">
                            <p class="text-sm text-soil-500">Belum ada kredensial tersimpan.</p>
                            <a href="{{ route('vault.create') }}" class="action-link mt-1 inline-block">Simpan yang pertama</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if ($credentials->hasPages())
    <div class="mt-6">{{ $credentials->links() }}</div>
@endif

@endsection