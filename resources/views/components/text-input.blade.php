@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'rounded-md border-slate-300 bg-white text-slate-900 shadow-sm placeholder:text-slate-400 focus:border-green-500 focus:ring-green-500 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100 dark:placeholder:text-slate-500 dark:focus:border-green-400 dark:focus:ring-green-400']) }}>
