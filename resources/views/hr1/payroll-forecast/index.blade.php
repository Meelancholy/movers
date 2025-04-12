@extends('hr1.layouts.app')

@section('content')
<div class="container min-w-full bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-3xl font-bold text-gray-700">Payroll Budget Forecasting</h1>

    <div class="mt-6 bg-white p-6 rounded-lg shadow">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-700">Forecast Parameters</h2>
            <div class="flex space-x-4">
                <div>
                    <label for="months" class="block text-sm font-medium text-gray-700">Forecast Period</label>
                    <select id="months" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                        <option value="3">3 Months</option>
                        <option value="6" selected>6 Months</option>
                        <option value="12">12 Months</option>
                    </select>
                </div>
                <div>
                    <label for="confidence" class="block text-sm font-medium text-gray-700">Confidence Level</label>
                    <select id="confidence" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                        <option value="0.90">90%</option>
                        <option value="0.95" selected>95%</option>
                        <option value="0.99">99%</option>
                    </select>
                </div>
                <button id="updateForecast" class="mt-6 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Update Forecast
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
            <!-- Use col-span-2 on the direct child (not nested flex) -->
            <div class="flex lg:col-span-2 bg-white p-4 rounded-lg shadow">
                <!-- Container for chart with responsive sizing -->
                <div id="forecastChart" class="w-4/5" style="min-height: 400px;">
                    <!-- Chart will be inserted here -->
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-white p-4 rounded-lg shadow">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Forecast Summary</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Forecast Period:</span>
                            <span class="font-medium" id="forecastPeriodText">6 Months</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Confidence Level:</span>
                            <span class="font-medium" id="confidenceLevelText">95%</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Model Accuracy (R²):</span>
                            <span class="font-medium" id="modelAccuracy">{{ number_format($forecast['model_accuracy'] ?? 0, 1) }}%</span>
                        </div>
                        <div class="pt-3 border-t border-gray-200">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Next Month Forecast:</span>
                                <span class="font-medium text-blue-600">₱<span id="nextMonthForecast">{{ number_format($forecast['values'][0] ?? 0, 2) }}</span></span>
                            </div>
                            <div class="text-sm text-gray-500 mt-1">
                                Range: ₱<span id="nextMonthLower">{{ number_format($forecast['lower'][0] ?? 0, 2) }}</span> - ₱<span id="nextMonthUpper">{{ number_format($forecast['upper'][0] ?? 0, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-4 rounded-lg shadow">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Department Distribution</h3>
                    <div id="departmentChart" style="height: 250px;"></div>
                </div>
            </div>
        </div>

        <div class="mt-6 bg-white p-4 rounded-lg shadow">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Detailed Forecast</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Period</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Forecast Amount</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Confidence Range</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Variance</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="forecastTableBody">
                        @foreach($forecastMonths as $index => $month)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $month }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">₱{{ number_format($forecast['values'][$index], 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                ₱{{ number_format($forecast['lower'][$index], 2) }} - ₱{{ number_format($forecast['upper'][$index], 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($index > 0)
                                    @php
                                        $change = (($forecast['values'][$index] - $forecast['values'][$index-1]) / $forecast['values'][$index-1]) * 100;
                                        $color = $change >= 0 ? 'text-green-600' : 'text-red-600';
                                        $icon = $change >= 0 ? '▲' : '▼';
                                    @endphp
                                    <span class="{{ $color }}">{{ $icon }} {{ number_format(abs($change), 2) }}%</span>
                                @else
                                    @php
                                        $lastHistorical = last($grossPayData->toArray());
                                        if ($lastHistorical > 0) {
                                            $change = (($forecast['values'][$index] - $lastHistorical) / $lastHistorical) * 100;
                                            $color = $change >= 0 ? 'text-green-600' : 'text-red-600';
                                            $icon = $change >= 0 ? '▲' : '▼';
                                        }
                                    @endphp
                                    @if($lastHistorical > 0)
                                        <span class="{{ $color }}">{{ $icon }} {{ number_format(abs($change), 2) }}%</span>
                                    @else
                                        <span class="text-gray-400">N/A</span>
                                    @endif
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    // Initialize charts
    document.addEventListener('DOMContentLoaded', function() {
        // Historical and Forecast Chart
        const forecastChart = new ApexCharts(document.querySelector("#forecastChart"), {
            series: [{
                name: 'Historical Payroll',
                data: @json($grossPayData),
                type: 'line'
            }, {
                name: 'Forecast',
                data: Array(@json($grossPayData->count())).fill(null).concat(@json($forecast['values'])),
                type: 'line'
            }, {
                name: 'Upper Bound',
                data: Array(@json($grossPayData->count())).fill(null).concat(@json($forecast['upper'])),
                type: 'area'
            }, {
                name: 'Lower Bound',
                data: Array(@json($grossPayData->count())).fill(null).concat(@json($forecast['lower'])),
                type: 'area'
            }],
            chart: {
                type: 'line',
                zoom: {
                    enabled: false
                },
                animations: {
                    enabled: false
                }
            },
            stroke: {
                curve: 'straight',
                width: [3, 3, 0, 0]
            },
            fill: {
                type: 'solid',
                opacity: [1, 1, 0.2, 0.2]
            },
            colors: ['#3B82F6', '#10B981', '#10B981', '#10B981'],
            labels: @json($historicalMonths->concat($forecastMonths)),
            xaxis: {
                type: 'category',
                tickPlacement: 'on'
            },
            yaxis: {
                title: {
                    text: 'Amount (₱)'
                },
                labels: {
                    formatter: function(value) {
                        return '₱' + (value / 1000).toFixed(0) + 'k';
                    }
                }
            },
            tooltip: {
                y: {
                    formatter: function(value) {
                        return '₱' + value.toFixed(2);
                    }
                }
            },
            legend: {
                position: 'top'
            },
            markers: {
                size: 4
            }
        });
        forecastChart.render();

        // Department Distribution Chart
        const departmentChart = new ApexCharts(document.querySelector("#departmentChart"), {
            series: @json($departments->pluck('count')),
            chart: {
                type: 'donut',
                height: 250
            },
            labels: @json($departments->pluck('department')),
            colors: ['#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6'],
            legend: {
                position: 'bottom'
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        });
        departmentChart.render();

        // Update forecast when parameters change
        document.getElementById('updateForecast').addEventListener('click', function() {
            const months = document.getElementById('months').value;
            const confidence = document.getElementById('confidence').value;

            fetch("{{ route('payroll-forecast.forecast') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    months: months,
                    confidence: confidence
                })
            })
            .then(response => response.json())
            .then(data => {
                // Update forecast chart
                forecastChart.updateSeries([{
                    name: 'Historical Payroll',
                    data: @json($grossPayData),
                    type: 'line'
                }, {
                    name: 'Forecast',
                    data: Array(@json($grossPayData->count())).fill(null).concat(data.values),
                    type: 'line'
                }, {
                    name: 'Upper Bound',
                    data: Array(@json($grossPayData->count())).fill(null).concat(data.upper),
                    type: 'area'
                }, {
                    name: 'Lower Bound',
                    data: Array(@json($grossPayData->count())).fill(null).concat(data.lower),
                    type: 'area'
                }]);

                // Update labels
                forecastChart.updateOptions({
                    labels: @json($historicalMonths).concat(data.months)
                });

                // Update summary
                document.getElementById('forecastPeriodText').textContent = months + ' Months';
                document.getElementById('confidenceLevelText').textContent = (confidence * 100) + '%';
                document.getElementById('modelAccuracy').textContent = data.model_accuracy.toFixed(1) + '%';
                document.getElementById('nextMonthForecast').textContent = data.values[0].toFixed(2);
                document.getElementById('nextMonthLower').textContent = data.lower[0].toFixed(2);
                document.getElementById('nextMonthUpper').textContent = data.upper[0].toFixed(2);

                // Update detailed table
                const tableBody = document.getElementById('forecastTableBody');
                tableBody.innerHTML = '';

                data.months.forEach((month, index) => {
                    const row = document.createElement('tr');

                    // Month cell
                    const monthCell = document.createElement('td');
                    monthCell.className = 'px-6 py-4 whitespace-nowrap';
                    monthCell.textContent = month;
                    row.appendChild(monthCell);

                    // Forecast amount cell
                    const amountCell = document.createElement('td');
                    amountCell.className = 'px-6 py-4 whitespace-nowrap';
                    amountCell.textContent = '₱' + data.values[index].toFixed(2);
                    row.appendChild(amountCell);

                    // Confidence range cell
                    const rangeCell = document.createElement('td');
                    rangeCell.className = 'px-6 py-4 whitespace-nowrap';
                    rangeCell.textContent = '₱' + data.lower[index].toFixed(2) + ' - ₱' + data.upper[index].toFixed(2);
                    row.appendChild(rangeCell);

                    // Variance cell
                    const varianceCell = document.createElement('td');
                    varianceCell.className = 'px-6 py-4 whitespace-nowrap';

                    if (index > 0) {
                        const change = ((data.values[index] - data.values[index-1]) / data.values[index-1]) * 100;
                        const color = change >= 0 ? 'text-green-600' : 'text-red-600';
                        const icon = change >= 0 ? '▲' : '▼';

                        varianceCell.innerHTML = `<span class="${color}">${icon} ${Math.abs(change).toFixed(2)}%</span>`;
                    } else {
                        varianceCell.innerHTML = '<span class="text-gray-400">N/A</span>';
                    }

                    row.appendChild(varianceCell);

                    tableBody.appendChild(row);
                });
            });
        });
    });
</script>
@endsection
