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
    $employeeCount = Employee::count();
    // Initialize arrays for the column chart (age and gender distribution)
    $ageGroups = ['18-21', '22-25', '26-30', '31-35', '36-40', '41-45', '46-50', '51-55', '56-59', '60+'];
    $maleCounts = array_fill_keys($ageGroups, 0);
    $femaleCounts = array_fill_keys($ageGroups, 0);

    // Initialize arrays for the donut chart (status distribution)
    $statusCounts = [];

    // Process employee data
    foreach ($employees as $employee) {
        // Column chart data: Group by age and gender

        $bday = new \DateTime($employee->bdate); // Use global namespace
        $today = new \DateTime(); // Use global namespace
        $age = $today->diff($bday)->y; // Extract years from DateInterval

        $gender = $employee->gender;

        if ($age >= 18 && $age <= 21) {
            $group = '18-21';
        } elseif ($age >= 22 && $age <= 25) {
            $group = '22-25';
        } elseif ($age >= 26 && $age <= 30) {
            $group = '26-30';
        } elseif ($age >= 31 && $age <= 35) {
            $group = '31-35';
        } elseif ($age >= 36 && $age <= 40) {
            $group = '36-40';
        } elseif ($age >= 41 && $age <= 45) {
            $group = '41-45';
        } elseif ($age >= 46 && $age <= 50) {
            $group = '46-50';
        } elseif ($age >= 51 && $age <= 55) {
            $group = '51-55';
        } elseif ($age >= 56 && $age <= 59) {
            $group = '56-59';
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
        'ageGroups' => $ageGroups,
        'maleCounts' => array_values($maleCounts),
        'femaleCounts' => array_values($femaleCounts),
        'employeeCount' => $employeeCount,
        'statuses' => array_keys($statusCounts),
        'statusCounts' => array_values($statusCounts),
    ]);
}
}
