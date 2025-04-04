<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payroll;
use App\Models\Employee;
use App\Models\Cycle;
use App\Services\PayrollForecastService;
use Carbon\Carbon;

class PayrollForecastController extends Controller
{
    protected $forecastService;

    public function __construct(PayrollForecastService $forecastService)
    {
        $this->forecastService = $forecastService;
    }

    public function index()
    {
        // Get historical payroll data
        $historicalData = Payroll::with(['employee', 'cycle'])
            ->orderBy('cycle_id')
            ->get()
            ->groupBy('cycle_id');

        // Prepare data for chart
        $cycles = Cycle::orderBy('start_date')->get();
        $cycleLabels = $cycles->pluck('name');
        $grossPayData = $cycles->map(function($cycle) use ($historicalData) {
            return $historicalData->has($cycle->id) ?
                $historicalData[$cycle->id]->sum('gross_pay') : 0;
        });

        // Get current employee count by department
        $departments = Employee::select('department')
            ->selectRaw('count(*) as count')
            ->groupBy('department')
            ->get();

        // Get forecast for next 6 months
        $forecast = $this->forecastService->generateForecast(6);

        return view('hr1.payroll-forecast.index', [
            'cycleLabels' => $cycleLabels,
            'grossPayData' => $grossPayData,
            'departments' => $departments,
            'forecast' => $forecast,
            'historicalMonths' => $cycles->pluck('start_date')->map(function($date) {
                return $date->format('M Y');
            }),
            'forecastMonths' => collect($forecast['months']),
        ]);
    }

    public function forecast(Request $request)
    {
        $validated = $request->validate([
            'months' => 'required|integer|min:1|max:12',
            'confidence' => 'required|numeric|min:0.5|max:0.99'
        ]);

        $forecast = $this->forecastService->generateForecast(
            $validated['months'],
            $validated['confidence']
        );

        return response()->json($forecast);
    }
}
