<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
class DashboardController extends Controller
{
    // EmployeeController.php
public function index()
{
    // Fetch all employees
    $employees = Employee::all();

    // Initialize arrays for the column chart (age and gender distribution)
    $ageGroups = ['20-24', '25-29', '30-34', '35-39', '40-44', '45-49', '50-54', '55-59', '60+'];
    $maleCounts = array_fill_keys($ageGroups, 0);
    $femaleCounts = array_fill_keys($ageGroups, 0);

    // Initialize arrays for the donut chart (status distribution)
    $statusCounts = [];

    // Process employee data
    foreach ($employees as $employee) {
        // Column chart data: Group by age and gender
        $age = $employee->age;
        $gender = $employee->gender;

        if ($age >= 20 && $age <= 24) {
            $group = '20-24';
        } elseif ($age >= 25 && $age <= 29) {
            $group = '25-29';
        } elseif ($age >= 30 && $age <= 34) {
            $group = '30-34';
        } elseif ($age >= 35 && $age <= 39) {
            $group = '35-39';
        } elseif ($age >= 40 && $age <= 44) {
            $group = '40-44';
        } elseif ($age >= 45 && $age <= 49) {
            $group = '45-49';
        } elseif ($age >= 50 && $age <= 54) {
            $group = '50-54';
        } elseif ($age >= 55 && $age <= 59) {
            $group = '55-59';
        } else {
            $group = '60+';
        }

        if ($gender === 'Male') {
            $maleCounts[$group]++;
        } elseif ($gender === 'Female') {
            $femaleCounts[$group]++;
        }

        // Donut chart data: Group by status
        $status = $employee->status;
        if (!isset($statusCounts[$status])) {
            $statusCounts[$status] = 0;
        }
        $statusCounts[$status]++;
    }

    // Pass data to the view
    return view('hr1.dashboard.dashboard', [
        // Column chart data
        'ageGroups' => $ageGroups,
        'maleCounts' => array_values($maleCounts),
        'femaleCounts' => array_values($femaleCounts),

        // Donut chart data
        'statuses' => array_keys($statusCounts),
        'statusCounts' => array_values($statusCounts),
    ]);
}
}
