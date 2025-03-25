@extends('hr1.layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<div class="container min-w-full bg-white p-6 rounded-lg shadow-md md:p-6">
    <h1 class="text-3xl font-bold text-gray-700 mr-auto">Dashboard</h1>
</div>
<div class="flex justify-around">
    <div class="bg-white p-4 m-2 rounded-lg shadow-lg">
        <h1 class="text-gray-600 font-bold text-lg mb-2">Total Employees</h1>
        <div class="flex items-center justify-between">
            <span class="text-3xl font-bold text-blue-600">{{ $employeeCount }}</span>
            <div class="p-3 bg-blue-100 rounded-full">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>
<div class="flex justify-around">

    <div class="bg-white p-4 m-2 rounded-lg">
        <h1 class="text-gray-600 font-bold">Employees Status Distribution</h1>
        <div id="donutChart" class=""></div>
    </div>
    <div class="bg-white p-4 m-2 rounded-lg">
        <h1 class="text-gray-600 font-bold">Employees Age by Gender Distribution </h1>
        <div id="columnChart" class="bg-white p-4 m-2 rounded-lg"></div>
    </div>

    <script>

        // Data passed from the controller
        var ageGroups = @json($ageGroups);
        var maleCounts = @json($maleCounts);
        var femaleCounts = @json($femaleCounts);

        var statuses = @json($statuses);
        var statusCounts = @json($statusCounts);

        // Column Chart Configuration
        var columnChartOptions = {
            series: [{
                name: 'Male',
                data: maleCounts
            }, {
                name: 'Female',
                data: femaleCounts
            }],
            chart: {
                type: 'bar',
                height: 315
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
                categories: ageGroups,
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
            }
        };

        // Donut Chart Configuration
        var donutChartOptions = {
            series: statusCounts,
            chart: {
                type: 'donut'
            },
            labels: statuses,
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 500
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };

        // Render the charts
        var columnChart = new ApexCharts(document.querySelector("#columnChart"), columnChartOptions);
        columnChart.render();

        var donutChart = new ApexCharts(document.querySelector("#donutChart"), donutChartOptions);
        donutChart.render();
    </script>
</div>
@endsection
