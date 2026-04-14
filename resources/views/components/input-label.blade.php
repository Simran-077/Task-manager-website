@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-xs font-bold text-slate-500 uppercase tracking-widest mb-2 ml-1']) }}>
    {{ $value ?? $slot }}
</label>
