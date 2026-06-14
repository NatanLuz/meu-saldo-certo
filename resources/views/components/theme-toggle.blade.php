<button
    type="button"
    x-data
    x-init="$store.theme.init()"
    @click="$store.theme.toggle()"
    class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 shadow-sm transition hover:border-green-500 hover:text-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:hover:border-green-400 dark:hover:text-green-300 dark:focus:ring-offset-slate-900"
    aria-label="Alternar tema claro e escuro"
    :aria-pressed="$store.theme.isDark().toString()"
>
    <svg x-show="!$store.theme.isDark()" x-cloak class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <circle cx="12" cy="12" r="4" />
        <path d="M12 2v2" />
        <path d="M12 20v2" />
        <path d="M4.93 4.93l1.41 1.41" />
        <path d="M17.66 17.66l1.41 1.41" />
        <path d="M2 12h2" />
        <path d="M20 12h2" />
        <path d="M4.93 19.07l1.41-1.41" />
        <path d="M17.66 6.34l1.41-1.41" />
    </svg>

    <svg x-show="$store.theme.isDark()" x-cloak class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79Z" />
    </svg>

    <span x-text="$store.theme.isDark() ? 'Claro' : 'Escuro'"></span>
</button>
