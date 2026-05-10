<x-app-layout>
    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-7">
            <div class="rounded-xl border border-gray-200/90 bg-white p-6 shadow-[0_12px_28px_rgba(15,23,42,0.08)]">
                <form method="GET" action="{{ route('transactions.index') }}" id="period-filter-form" class="space-y-4">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                        <div class="space-y-1">
                            <p class="text-xs uppercase tracking-wide text-gray-500">Filtro de Período</p>
                            <h3 class="text-sm font-semibold text-gray-800">Filtre a lista por intervalo</h3>
                        </div>

                        <div class="flex w-full flex-col gap-3 sm:flex-row sm:items-end lg:w-auto lg:justify-end">
                            <div class="w-full sm:w-[240px]">
                                <label for="period" class="block text-xs uppercase tracking-wide text-gray-500">Período</label>
                                <select id="period" name="period" class="mt-2 h-10 w-full rounded-xl border border-gray-300 bg-white text-sm text-gray-900 shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-100" onchange="window.toggleCustomPeriodFields(this.value)">
                                    @foreach ($periodOptions as $periodValue => $periodLabel)
                                        <option value="{{ $periodValue }}" @selected(request('period') !== 'custom' && $selectedPeriod === $periodValue)>{{ $periodLabel }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="w-full sm:w-[240px]">
                                <button type="submit" class="h-10 w-full rounded-xl border border-green-700 bg-green-600 px-4 text-sm font-semibold text-white shadow-sm transition hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-200">
                                    Aplicar
                                </button>
                            </div>
                        </div>
                    </div>

                    <div id="custom-period-fields" class="{{ request('period') === 'custom' ? 'grid' : 'hidden' }} grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label for="start_date" class="block text-xs uppercase tracking-wide text-gray-500">Data Inicial</label>
                            <input id="start_date" name="start_date" type="date" value="{{ request('start_date') }}" class="mt-2 h-10 w-full rounded-xl border border-gray-300 bg-white text-sm text-gray-900 shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-100">
                        </div>

                        <div>
                            <label for="end_date" class="block text-xs uppercase tracking-wide text-gray-500">Data Final</label>
                            <input id="end_date" name="end_date" type="date" value="{{ request('end_date') }}" class="mt-2 h-10 w-full rounded-xl border border-gray-300 bg-white text-sm text-gray-900 shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-100">
                        </div>
                    </div>
                </form>
            </div>

            @if (session('status'))
                <div class="rounded-lg border border-green-300 bg-green-50 px-4 py-3 text-sm font-medium text-green-800 shadow-sm">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="rounded-lg border border-red-300 bg-red-50 px-4 py-3 text-sm text-red-800 shadow-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

                <div class="overflow-hidden rounded-xl border border-gray-200/90 bg-white p-6 shadow-[0_12px_28px_rgba(15,23,42,0.08)]">
                <h3 class="mb-5 text-lg font-semibold text-gray-800">Nova Transação</h3>

                <form method="POST" action="{{ route('transactions.store') }}" class="flex flex-wrap gap-4 md:flex-nowrap md:items-end lg:gap-6">
                    @csrf

                    <div class="w-full md:w-auto md:flex-1">
                        <label for="type" class="block text-sm font-medium text-gray-700">Tipo</label>
                        <select id="type" name="type" @class([
                            'mt-2 h-10 block w-full rounded-xl border bg-white px-3 text-sm text-gray-900 shadow-sm focus:outline-none focus:ring-2 focus:ring-green-100',
                            'border-gray-300 focus:border-green-500 focus:ring-green-100' => ! $errors->has('type'),
                            'border-red-300 ring-2 ring-red-100 focus:border-red-400 focus:ring-red-100' => $errors->has('type'),
                        ]) required aria-invalid="@error('type') true @else false @enderror" aria-describedby="type-error">
                            <option value="income" @selected(old('type') === 'income')>Receita</option>
                            <option value="expense" @selected(old('type') === 'expense')>Despesa</option>
                        </select>
                        @error('type')
                            <p id="type-error" class="mt-1 text-sm font-medium text-red-700">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="w-full md:w-auto md:flex-1">
                        <label for="amount" class="block text-sm font-medium text-gray-700">Valor</label>
                        <input id="amount" name="amount" type="number" step="0.01" min="0.01" value="{{ old('amount') }}" @class([
                            'mt-2 h-10 block w-full rounded-xl border bg-white px-3 text-sm text-gray-900 shadow-sm focus:outline-none focus:ring-2 placeholder:text-gray-400',
                            'border-gray-300 focus:border-green-500 focus:ring-green-100' => ! $errors->has('amount'),
                            'border-red-300 ring-2 ring-red-100 focus:border-red-400 focus:ring-red-100' => $errors->has('amount'),
                        ]) placeholder="Ex: Digite o valor da transação" required aria-invalid="@error('amount') true @else false @enderror" aria-describedby="amount-error">
                        @error('amount')
                            <p id="amount-error" class="mt-1 text-sm font-medium text-red-700">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="w-full md:w-auto md:flex-1">
                        <label for="date" class="block text-sm font-medium text-gray-700">Data</label>
                        <input id="date" name="date" type="date" value="{{ old('date', today()->toDateString()) }}" @class([
                            'mt-2 h-10 block w-full rounded-xl border bg-white px-3 text-sm shadow-sm focus:outline-none focus:ring-2 text-gray-900',
                            'border-gray-300 focus:border-green-500 focus:ring-green-100' => ! $errors->has('date'),
                            'border-red-300 ring-2 ring-red-100 focus:border-red-400 focus:ring-red-100' => $errors->has('date'),
                        ]) required aria-invalid="@error('date') true @else false @enderror" aria-describedby="date-error">
                        @error('date')
                            <p id="date-error" class="mt-1 text-sm font-medium text-red-700">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="w-full md:w-auto md:flex-1">
                        <label for="category_name" class="block text-sm font-medium text-gray-700">Categoria</label>
                        <input id="category_name" name="category_name" type="text" maxlength="80" value="{{ old('category_name') }}" placeholder="Ex: Academia, Lazer, Streaming" @class([
                            'mt-2 h-10 block w-full rounded-xl border bg-white px-3 text-sm text-gray-900 shadow-sm focus:outline-none focus:ring-2 placeholder:text-gray-400',
                            'border-gray-300 focus:border-green-500 focus:ring-green-100' => ! $errors->has('category_name'),
                            'border-red-300 ring-2 ring-red-100 focus:border-red-400 focus:ring-red-100' => $errors->has('category_name'),
                        ]) required aria-invalid="@error('category_name') true @else false @enderror" aria-describedby="category-name-error">
                        @error('category_name')
                            <p id="category-name-error" class="mt-1 text-sm font-medium text-red-700">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="w-full md:w-auto md:shrink-0">
                        <button type="submit" class="inline-flex h-10 w-full items-center justify-center rounded-xl border border-green-700 bg-green-600 px-4 text-sm font-semibold uppercase tracking-wide text-white shadow-sm transition hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-200 focus:ring-offset-2">
                            Nova Transação
                        </button>
                    </div>
                </form>
            </div>


            <div class="overflow-hidden rounded-xl border border-gray-200/90 bg-white p-6 shadow-[0_12px_28px_rgba(15,23,42,0.08)]">
                <h3 class="mb-4 text-lg font-semibold text-gray-800">Suas Transações</h3>

                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Data</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Tipo</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Categoria</th>
                                <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-600">Valor</th>
                                <th class="px-4 py-3"></th>
                            </tr>
                        </thead>
                        <tbody id="transactions-table-body" class="divide-y divide-gray-200 bg-white">
                            @forelse ($transactions as $transaction)
                                <tr data-transaction-date="{{ optional($transaction->date)->format('Y-m-d') ?? $transaction->created_at->format('Y-m-d') }}" class="transition-colors odd:bg-white even:bg-gray-50 hover:bg-gray-100">
                                    <td class="whitespace-nowrap px-4 py-3 text-sm text-gray-700">{{ optional($transaction->date)->format('d/m/Y') ?? $transaction->created_at->format('d/m/Y') }}</td>
                                    <td class="px-4 py-3 text-sm">
                                        <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $transaction->type === 'income' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                            {{ $transaction->type === 'income' ? 'Receita' : 'Despesa' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-800">{{ $transaction->category->name }}</td>
                                    <td class="whitespace-nowrap px-4 py-3 text-right text-sm font-semibold {{ $transaction->type === 'income' ? 'text-green-700' : 'text-red-700' }}">
                                        {{ formatCurrency($transaction->amount) }}
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <div class="inline-flex items-center gap-2">
                                            <a href="{{ route('transactions.edit', $transaction) }}" class="inline-flex items-center rounded-md border border-gray-200 bg-white px-3 py-1.5 text-xs font-semibold uppercase tracking-wide text-gray-700 transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-200">
                                                Editar
                                            </a>

                                            <form method="POST" action="{{ route('transactions.destroy', $transaction) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center rounded-md border border-red-200 bg-white px-3 py-1.5 text-xs font-semibold uppercase tracking-wide text-red-700 transition hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-200" onclick="return confirm('Tem certeza que deseja excluir esta transação?')">
                                                    Excluir
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr id="transactions-empty-row">
                                    <td colspan="5" class="px-4 py-8 text-center text-sm text-gray-500">Nenhuma transação cadastrada ainda.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $transactions->links() }}
                </div>
            </div>
        </div>
    </div>

    <script>
        window.toggleCustomPeriodFields = function (periodValue) {
            const customFields = document.getElementById('custom-period-fields');

            if (!customFields) {
                return;
            }

            if (periodValue === 'custom') {
                customFields.classList.remove('hidden');
                return;
            }

            customFields.classList.add('hidden');
            document.getElementById('period-filter-form')?.submit();
        };

        (() => {
            const params = new URLSearchParams(window.location.search);

            if (params.get('period') !== 'custom') {
                return;
            }

            const startInput = document.getElementById('start_date');
            const endInput = document.getElementById('end_date');
            const rows = document.querySelectorAll('[data-transaction-date]');
            const emptyRow = document.getElementById('transactions-empty-row');

            const startDate = startInput?.value || params.get('start_date') || '';
            const endDate = endInput?.value || params.get('end_date') || '';

            const startTime = startDate ? new Date(`${startDate}T00:00:00`).getTime() : null;
            const endTime = endDate ? new Date(`${endDate}T23:59:59`).getTime() : null;

            let visibleCount = 0;

            rows.forEach((row) => {
                const rowTime = new Date(`${row.dataset.transactionDate}T00:00:00`).getTime();
                const matchesStart = startTime === null || rowTime >= startTime;
                const matchesEnd = endTime === null || rowTime <= endTime;
                const isVisible = matchesStart && matchesEnd;

                row.classList.toggle('hidden', ! isVisible);

                if (isVisible) {
                    visibleCount += 1;
                }
            });

            if (emptyRow) {
                emptyRow.classList.toggle('hidden', visibleCount > 0);
                const cell = emptyRow.querySelector('td');

                if (cell && visibleCount === 0) {
                    cell.textContent = 'Nenhuma transação encontrada para o período personalizado.';
                }
            }
        })();
    </script>

</x-app-layout>
