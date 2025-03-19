@extends('hr1.layouts.app')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<div class="flex">
    <div class="">
        <div id="donutChart" class="bg-white p-4 m-2 rounded-lg"></div>
    </div>
    <div class="">
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
