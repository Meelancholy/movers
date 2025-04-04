<?php

namespace App\Services;

use App\Models\Payroll;
use App\Models\Cycle;
use Carbon\Carbon;
use Rubix\ML\Datasets\Unlabeled;
use Rubix\ML\Regressors\GradientBoost;
use Rubix\ML\CrossValidation\Metrics\RSquared;
use Rubix\ML\CrossValidation\HoldOut;

class PayrollForecastService
{
    public function generateForecast($periods = 6, $confidence = 0.95)
    {
        // Get historical data
        $historical = $this->getHistoricalData();

        // Simple forecasting (can be replaced with more complex model)
        $forecastValues = $this->simpleMovingAverageForecast($historical, $periods);

        // Calculate confidence intervals
        $stdDev = $this->calculateStandardDeviation($historical);
        $marginOfError = $this->calculateMarginOfError($stdDev, count($historical), $confidence);

        // Prepare forecast months
        $lastDate = Cycle::latest('end_date')->first()->end_date;
        $months = [];
        for ($i = 1; $i <= $periods; $i++) {
            $months[] = $lastDate->copy()->addMonths($i)->format('M Y');
        }

        return [
            'values' => $forecastValues,
            'upper' => array_map(function($v) use ($marginOfError) {
                return $v + $marginOfError;
            }, $forecastValues),
            'lower' => array_map(function($v) use ($marginOfError) {
                return max(0, $v - $marginOfError);
            }, $forecastValues),
            'months' => $months,
            'confidence' => $confidence * 100,
            'model_accuracy' => $this->evaluateModel($historical)
        ];
    }

    protected function getHistoricalData()
    {
        return Cycle::with('payrolls')
            ->orderBy('start_date')
            ->get()
            ->map(function($cycle) {
                return $cycle->payrolls->sum('gross_pay');
            })
            ->toArray();
    }

    protected function simpleMovingAverageForecast($data, $periods, $window = 3)
    {
        $forecast = [];
        $lastWindow = array_slice($data, -$window);

        for ($i = 0; $i < $periods; $i++) {
            $average = array_sum($lastWindow) / count($lastWindow);
            $forecast[] = $average;
            array_shift($lastWindow);
            $lastWindow[] = $average;
        }

        return $forecast;
    }

    protected function calculateStandardDeviation($data)
    {
        $n = count($data);
        if ($n < 2) return 0;

        $mean = array_sum($data) / $n;
        $variance = 0.0;

        foreach ($data as $value) {
            $variance += pow($value - $mean, 2);
        }

        return sqrt($variance / ($n - 1));
    }

    protected function calculateMarginOfError($stdDev, $sampleSize, $confidence)
    {
        // Z-score for 95% confidence is ~1.96
        $z = $this->getZScore($confidence);
        return $z * ($stdDev / sqrt($sampleSize));
    }

    protected function getZScore($confidence)
    {
        // Simplified - in practice you'd use a proper z-score table
        $scores = [
            0.90 => 1.645,
            0.95 => 1.96,
            0.99 => 2.576
        ];

        return $scores[round($confidence, 2)] ?? 1.96;
    }

    protected function evaluateModel($data)
    {
        if (count($data) < 6) {
            return null;
        }

        // Split data into training and testing sets
        $split = (int) (count($data) * 0.8);
        $training = array_slice($data, 0, $split);
        $testing = array_slice($data, $split);

        // Generate forecasts for test period
        $predictions = $this->simpleMovingAverageForecast($training, count($testing));

        // Calculate R-squared
        $metric = new RSquared();
        return $metric->score($predictions, $testing) * 100;
    }
}
