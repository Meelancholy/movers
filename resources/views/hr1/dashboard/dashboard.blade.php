@extends('hr1.layouts.app')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<div class="flex rounded-lg bg-white w-3/5">
    <div class="p-4 w-4/5">

        <div id="chart" class="text-xl font-bold text-gray-700">Employees Age by Gender Distribution</div>

        <script>
            // Data passed from the controller
            var ageGroups = @json($ageGroups);
            var maleCounts = @json($maleCounts);
            var femaleCounts = @json($femaleCounts);

            // ApexCharts configuration
            var options = {
                series: [{
                    name: 'Male',
                    data: maleCounts
                }, {
                    name: 'Female',
                    data: femaleCounts
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
                            return val + " employee";
                        }
                    }
                }
            };

            // Render the chart
            var chart = new ApexCharts(document.querySelector("#chart"), options);
            chart.render();

        </script>


</div>
@endsection
