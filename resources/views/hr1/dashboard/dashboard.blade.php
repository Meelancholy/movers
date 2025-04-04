@extends('hr1.layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<div class="mx-auto bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-3xl font-bold text-gray-700">Dashboard</h1>
</div>

<!-- Key Metrics Section -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 py-2">
    @php
        $metrics = [
            ['title' => 'Total Employees', 'count' => $employeeCount, 'color' => 'blue', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'],
            ['title' => 'New Hires (30d)', 'count' => $newHiresCount, 'color' => 'green', 'icon' => 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6'],
            ['title' => 'Turnover Rate', 'count' => $turnoverRate . '%', 'color' => 'red', 'icon' => 'M13 17h8m0 0V9m0 8l-8-8-4 4-6-6'],
            ['title' => 'Current Payroll', 'count' => '₱' . number_format($currentPayrollTotal), 'color' => 'purple', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z']
        ];
    @endphp

    @foreach($metrics as $metric)
    <div class="bg-white p-6 rounded-lg shadow-lg flex justify-between items-center">
        <div>
            <h2 class="text-gray-600 font-bold text-lg">{{ $metric['title'] }}</h2>
            <span class="text-3xl font-bold text-{{ $metric['color'] }}-600">{{ $metric['count'] }}</span>
        </div>
        <div class="p-3 bg-{{ $metric['color'] }}-100 rounded-full">
            <svg class="w-8 h-8 text-{{ $metric['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $metric['icon'] }}"></path>
            </svg>
        </div>
    </div>
    @endforeach
</div>

<!-- Charts Section -->
<div class="flex justify-between">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-gray-600 font-bold">Employees Age by Gender Distribution</h2>
        <div id="columnChart"></div>
    </div>
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-gray-600 font-bold">Department Distribution</h2>
        <div id="departmentChart"></div>
    </div>
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-gray-600 font-bold">Employees Status Distribution</h2>
        <div id="donutChart"></div>
    </div>

    <!-- Job Type Distribution -->
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-gray-600 font-bold">Job Type Distribution</h1>
        <div id="jobTypeChart"></div>
    </div>
</div>

<script>
    // Column Chart Configuration (Age by Gender)
    var columnChartOptions = {
        series: [{
            name: 'Male',
            data: @json($maleCounts)
        }, {
            name: 'Female',
            data: @json($femaleCounts)
        }],
        chart: {
            type: 'bar',
            height: 350
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '55%',
                borderRadius: 5,
                borderRadiusApplication: 'end'
            }
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            show: true,
            width: 2,
            colors: ['transparent']
        },
        xaxis: {
            categories: @json($ageGroups),
            title: {
                text: 'Age Group'
            }
        },
        yaxis: {
            title: {
                text: 'Number of Employees'
            }
        },
        fill: {
            opacity: 1
        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return val + " employees";
                }
            }
        },
        colors: ['#3B82F6', '#EC4899']
    };

    // Donut Chart Configuration (Status Distribution)
    var donutChartOptions = {
        series: @json($statusCounts),
        chart: {
            type: 'donut',
            height: 350
        },
        labels: @json($statuses),
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
        }],
        colors: ['#10B981', '#F59E0B', '#EF4444', '#8B5CF6']
    };

    // Department Distribution Chart
    var departmentChart = new ApexCharts(document.querySelector("#departmentChart"), {
        series: @json($departmentCounts),
        chart: {
            type: 'pie',
            height: 350
        },
        labels: @json($departmentNames),
        colors: ['#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6'],
        legend: {
            position: 'bottom'
        }
    });

    // Job Type Distribution Chart
    var jobTypeChart = new ApexCharts(document.querySelector("#jobTypeChart"), {
        series: @json($jobTypeCounts),
        chart: {
            type: 'radialBar',
            height: 350
        },
        plotOptions: {
            radialBar: {
                dataLabels: {
                    name: {
                        fontSize: '22px',
                    },
                    value: {
                        fontSize: '16px',
                    },
                    total: {
                        show: true,
                        label: 'Total',
                        formatter: function (w) {
                            return @json(array_sum($jobTypeCounts))
                        }
                    }
                }
            }
        },
        labels: @json($jobTypeNames),
        colors: ['#3B82F6', '#10B981', '#F59E0B', '#EF4444']
    });

    // Render the charts
    var columnChart = new ApexCharts(document.querySelector("#columnChart"), columnChartOptions);
    columnChart.render();

    var donutChart = new ApexCharts(document.querySelector("#donutChart"), donutChartOptions);
    donutChart.render();

    departmentChart.render();
    jobTypeChart.render();
</script>
@endsection
