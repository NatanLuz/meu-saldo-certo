@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'rounded-md border-slate-300 bg-white text-slate-900 shadow-sm placeholder:text-slate-400 focus:border-green-500 focus:ring-green-500']) }}>
