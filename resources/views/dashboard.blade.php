<x-app-layout>
    <div class="py-10">
        <div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 space-y-8">

            <!-- Filtro de período -->
            <div class="rounded-xl border border-gray-200/90 bg-white p-6 shadow-[0_12px_28px_rgba(15,23,42,0.08)]">
                <div class="flex flex-col gap-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.14em] text-gray-500">Filtro de Período</p>
                        <h3 class="mt-2 text-sm font-semibold text-gray-800">Filtre o painel por intervalo para ver suas despesas e receitas.</h3>
                    </div>

                    <div>
                        <label for="period" class="block text-xs font-semibold uppercase tracking-[0.14em] text-gray-500">Período</label>
                        <select id="period" name="period" form="dashboard-period-form" class="mt-2 h-10 w-full rounded-xl border border-gray-300 bg-white text-sm text-gray-900 shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-100" onchange="window.toggleDashboardCustomPeriod(this.value)">
                            @foreach ($periodOptions as $periodValue => $periodLabel)
                                <option value="{{ $periodValue }}" @selected($selectedPeriod === $periodValue)>{{ $periodLabel }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Campos customizados (aparecem apenas com custom) -->
                <form method="GET" action="{{ route('dashboard') }}" id="dashboard-period-form" class="mt-4 grid grid-cols-1 gap-4 {{ $selectedPeriod === 'custom' ? 'block' : 'hidden' }}">
                    <div>
                        <label for="start_date" class="block text-xs font-semibold uppercase tracking-[0.14em] text-gray-500">Data Inicial</label>
                        <input id="start_date" name="start_date" type="date" value="{{ $customStartDate }}" class="mt-2 h-10 w-full rounded-xl border border-gray-300 bg-white text-sm text-gray-900 shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-100">
                    </div>

                    <div>
                        <label for="end_date" class="block text-xs font-semibold uppercase tracking-[0.14em] text-gray-500">Data Final</label>
                        <input id="end_date" name="end_date" type="date" value="{{ $customEndDate }}" class="mt-2 h-10 w-full rounded-xl border border-gray-300 bg-white text-sm text-gray-900 shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-100">
                    </div>

                    <button type="submit" class="h-10 w-full rounded-xl border border-green-700 bg-green-600 text-sm font-semibold text-white shadow-sm transition hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-200">
                        Aplicar
                    </button>
                </form>
            </div>

            <!-- Cards sobre o financeiro  -->
            <div class="grid w-full grid-cols-1 gap-4 md:grid-cols-3">
                <div class="rounded-xl border border-slate-200 bg-white px-5 py-4 shadow-sm transition hover:shadow-md">
                    <p class="text-xs uppercase tracking-wide text-slate-400">Saldo</p>
                    <p class="mt-2 text-3xl font-bold leading-none tracking-tight {{ $balance >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ formatCurrency($balance) }}
                    </p>
                </div>

                <div class="rounded-xl border border-slate-200 bg-white px-5 py-4 shadow-sm transition hover:shadow-md">
                    <p class="text-xs uppercase tracking-wide text-slate-400">Total De Receitas</p>
                    <p class="mt-2 text-2xl font-semibold leading-none tracking-tight text-blue-600 sm:text-3xl">{{ formatCurrency($incomeTotal) }}</p>
                </div>

                <div class="rounded-xl border border-slate-200 bg-white px-5 py-4 shadow-sm transition hover:shadow-md">
                    <p class="text-xs uppercase tracking-wide text-slate-400">Total De Despesas</p>
                    <p class="mt-2 text-2xl font-semibold leading-none tracking-tight text-red-600 sm:text-3xl">{{ formatCurrency($expenseTotal) }}</p>
                </div>
            </div>

                <div class="mt-8 overflow-hidden rounded-xl border border-slate-200 bg-white p-6 shadow-sm transition duration-200 hover:shadow-md">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900">Receitas e Despesas</h3>
                        <p class="mt-1 text-sm text-slate-500">Resumo financeiro do período.</p>
                    </div>
                </div>
                <div class="mt-6 w-full min-h-[220px] md:min-h-[260px] lg:min-h-[300px]">
                    <canvas id="financeChart" class="w-full h-full"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        window.toggleDashboardCustomPeriod = function (periodValue) {
            const form = document.getElementById('dashboard-period-form');

            if (!form) {
                return;
            }

            if (periodValue === 'custom') {
                form.classList.remove('hidden');
                form.classList.add('block');
                return;
            }

            form.classList.add('hidden');
            form.classList.remove('block');
            form?.submit();
        };

        const monthlyData = @json($monthlyData);
        const ctx = document.getElementById('financeChart');
        const currencyFormatter = new Intl.NumberFormat('pt-BR', {
            style: 'currency',
            currency: 'BRL',
        });

        const getChartTheme = () => {
            const isDark = document.documentElement.classList.contains('dark');

            // acrescentando contraste forte para elementos principais, contraste médio para elementos secundários e transparências para detalhes e fundos de gráfico
            return {
                gridColor: isDark ? 'rgba(148, 163, 184, 0.12)' : 'rgba(148, 163, 184, 0.32)',
                tickColor: isDark ? '#e6eef8' : '#0f172a',
                legendColor: isDark ? '#e6eef8' : '#0f172a',
                tooltipBg: isDark ? 'rgba(10,14,20,0.95)' : '#ffffff',
                tooltipBorder: isDark ? '#21303b' : '#e6eaf0',
                income: isDark ? '#34d399' : '#16a34a',
                expense: isDark ? '#fb7185' : '#dc2626',
            };
        };

        const buildChart = () => {
            const theme = getChartTheme();

            return new Chart(ctx, {
                type: 'bar',
                layout: {
                    padding: {
                        top: 8,
                        right: 8,
                        bottom: 8,
                        left: 8,
                    },
                },
                data: {
                    labels: monthlyData.labels,
                    datasets: [
                        {
                            label: 'Receitas',
                            data: monthlyData.income,
                            backgroundColor: theme.income,
                            borderRadius: 8,
                            barThickness: 40,
                            maxBarThickness: 56,
                            barPercentage: 0.88,
                            categoryPercentage: 0.78,
                        },
                        {
                            label: 'Despesas',
                            data: monthlyData.expense,
                            backgroundColor: theme.expense,
                            borderRadius: 8,
                            barThickness: 40,
                            maxBarThickness: 56,
                            barPercentage: 0.88,
                            categoryPercentage: 0.78,
                        },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    layout: {
                        padding: {
                            top: 12,
                            right: 10,
                            bottom: 8,
                            left: 10,
                        },
                    },
                    plugins: {
                        legend: {
                            display: true,
                            labels: {
                                color: theme.legendColor,
                                font: { weight: '600', size: 12 }
                            },
                        },
                        tooltip: {
                            backgroundColor: theme.tooltipBg,
                            borderColor: theme.tooltipBorder,
                            borderWidth: 1,
                            titleColor: theme.tickColor,
                            bodyColor: theme.tickColor,
                            titleFont: { weight: '600' },
                            bodyFont: { weight: '500' },
                            callbacks: {
                                label(context) {
                                    const value = Number(context.raw ?? 0);
                                    return `${context.dataset.label}: ${currencyFormatter.format(value)}`;
                                },
                            },
                        },
                    },
                    scales: {
                        x: {
                            ticks: {
                                color: theme.tickColor,
                                font: { weight: '600', size: 12 },
                                maxTicksLimit: 12,
                                autoSkip: false,
                            },
                            grid: {
                                color: theme.gridColor,
                            },
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                color: theme.tickColor,
                                font: { weight: '600', size: 12 },
                                callback(value) {
                                    return currencyFormatter.format(Number(value));
                                },
                            },
                            grid: {
                                color: theme.gridColor,
                            },
                        },
                    },
                },
            });
        };

        let financeChart = buildChart();

        window.addEventListener('theme-changed', () => {
            financeChart.destroy();
            financeChart = buildChart();
        });
    </script>
</x-app-layout>
