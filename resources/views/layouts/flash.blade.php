@if (session('success'))
    <div role="status"
         class="mb-6 flex items-start gap-3 px-4 py-3 rounded-xl bg-crop-50 border border-crop-200 text-sm text-crop-800">
        <span class="mt-0.5 shrink-0" aria-hidden="true">✓</span>
        <p>{{ session('success') }}</p>
    </div>
@endif

@if (session('error'))
    <div role="alert"
         class="mb-6 flex items-start gap-3 px-4 py-3 rounded-xl bg-ember-50 border border-ember-200 text-sm text-ember-700">
        <span class="mt-0.5 shrink-0" aria-hidden="true">!</span>
        <p>{{ session('error') }}</p>
    </div>
@endif