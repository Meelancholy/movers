<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Payroll;
use App\Models\Cycle;
use App\Models\Adjustment;
use App\Models\PayrollAdjustment;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Employee Data
        $employees = Employee::all();
        $employeeCount = Employee::count();

        // Age and Gender Distribution
        $ageGroups = ['18-21', '22-25', '26-30', '31-35', '36-40', '41-45', '46-50', '51-55', '56-59', '60+'];
        $maleCounts = array_fill_keys($ageGroups, 0);
        $femaleCounts = array_fill_keys($ageGroups, 0);

        // Status Distribution
        $statusCounts = [];

        // Department Distribution
        $departmentCounts = [];

        // Job Type Distribution
        $jobTypeCounts = [];

        // Process employee data
        foreach ($employees as $employee) {
            // Age and Gender Distribution
            $bday = new \DateTime($employee->bdate);
            $today = new \DateTime();
            $age = $today->diff($bday)->y;

            $gender = $employee->gender;
            $group = $this->getAgeGroup($age);

            if ($gender === 'Male') {
                $maleCounts[$group]++;
            } elseif ($gender === 'Female') {
                $femaleCounts[$group]++;
            }

            // Status Distribution
            $status = $employee->status;
            $statusCounts[$status] = ($statusCounts[$status] ?? 0) + 1;

            // Department Distribution
            $department = $employee->department;
            $departmentCounts[$department] = ($departmentCounts[$department] ?? 0) + 1;

            // Job Type Distribution
            $jobType = $employee->job_type;
            $jobTypeCounts[$jobType] = ($jobTypeCounts[$jobType] ?? 0) + 1;
        }

        // Payroll Data
        $currentCycle = Cycle::latest()->first();
        $currentCycleStatus = $currentCycle ? ucfirst($currentCycle->status) : 'No active cycle';
        $currentPayrollTotal = Payroll::where('cycle_id', $currentCycle?->id)->sum('gross_pay') ?? 0;

        // Attendance Data
        $averageHoursWorked = number_format(Attendance::avg('hours_worked') ?? 0, 2);
        $recentAttendance = Attendance::with('employee')
            ->latest()
            ->limit(5)
            ->get();

        // Adjustments Data
        $recentAdjustments = PayrollAdjustment::with(['employee', 'adjustment'])
            ->latest()
            ->limit(5)
            ->get();

        // Payroll Breakdown (Top 10 employees)
        $payrollBreakdown = Payroll::with('employee')
            ->where('cycle_id', $currentCycle?->id)
            ->orderBy('gross_pay', 'desc')
            ->limit(10)
            ->get();

        return view('hr1.dashboard.dashboard', [
            // Age and Gender Distribution
            'ageGroups' => $ageGroups,
            'maleCounts' => array_values($maleCounts),
            'femaleCounts' => array_values($femaleCounts),

            // Employee Count and Status
            'employeeCount' => $employeeCount,
            'statuses' => array_keys($statusCounts),
            'statusCounts' => array_values($statusCounts),

            // Department Distribution
            'departmentNames' => array_keys($departmentCounts),
            'departmentCounts' => array_values($departmentCounts),

            // Job Type Distribution
            'jobTypeNames' => array_keys($jobTypeCounts),
            'jobTypeCounts' => array_values($jobTypeCounts),

            // Payroll Data
            'currentCycleStatus' => $currentCycleStatus,
            'currentPayrollTotal' => $currentPayrollTotal,
            'payrollBreakdown' => $payrollBreakdown,

            // Attendance Data
            'averageHoursWorked' => $averageHoursWorked,
            'recentAttendance' => $recentAttendance,

            // Adjustments Data
            'recentAdjustments' => $recentAdjustments,

            // Additional calculated data
            'newHiresCount' => Employee::where('created_at', '>=', now()->subDays(30))->count(),
            'turnoverRate' => $this->calculateTurnoverRate(),
        ]);
    }
    public function privacypolicy() {
        return view('hr1.privacy_policy');
    }

    private function getAgeGroup($age)
    {
        if ($age >= 18 && $age <= 21) return '18-21';
        if ($age >= 22 && $age <= 25) return '22-25';
        if ($age >= 26 && $age <= 30) return '26-30';
        if ($age >= 31 && $age <= 35) return '31-35';
        if ($age >= 36 && $age <= 40) return '36-40';
        if ($age >= 41 && $age <= 45) return '41-45';
        if ($age >= 46 && $age <= 50) return '46-50';
        if ($age >= 51 && $age <= 55) return '51-55';
        if ($age >= 56 && $age <= 59) return '56-59';
        return '60+';
    }

    private function calculateTurnoverRate()
    {
        $totalEmployees = Employee::count();
        $terminatedCount = Employee::where('status', 'Terminated')->count();

        return $totalEmployees > 0 ? round(($terminatedCount / $totalEmployees) * 100, 1) : 0;
    }
}
