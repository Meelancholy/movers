<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
class DashboardController extends Controller
{
    public function index()
    {
    $employee = Employee::all();
    // Initialize arrays to store counts
    $maleCounts = [];
    $femaleCounts = [];
    $ageGroups = ['18-24', '25-29', '30-34', '35-39', '40-44', '45-49', '50-54', '55-59', '60+'];

    foreach ($ageGroups as $group) {
        $maleCounts[$group] = 0;
        $femaleCounts[$group] = 0;
    }

    // Group employees by age and gender
    foreach ($employee as $employees) {
        $age = $employees->age;
        $gender = $employees->gender;

        // Determine the age group
        if ($age >= 18 && $age <= 24) {
            $group = '18-24';
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

        // Increment the count based on gender
        if ($gender === 'Male') {
            $maleCounts[$group]++;
        } elseif ($gender === 'Female') {
            $femaleCounts[$group]++;
        }
    }

    // Pass data to the view
    return view('hr1.dashboard.dashboard', [
        'ageGroups' => $ageGroups,
        'maleCounts' => array_values($maleCounts), // Convert associative array to indexed array
        'femaleCounts' => array_values($femaleCounts), // Convert associative array to indexed array
    ]);
}
}
