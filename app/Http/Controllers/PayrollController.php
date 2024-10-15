<?php
namespace App\Http\Controllers;

use App\Models\Employee;
use App\Http\Controllers\PayrollCalculator;

class PayrollController extends Controller
{
    public function create()
    {
        $employees = Employee::with('position', 'bonuses')->get();
        $payrollCalculator = new PayrollCalculator();
        $employeePayrollData = $employees->map(function ($employee) use ($payrollCalculator) {
            return $payrollCalculator->calculatePayrollData($employee);
        });

        return view('hr1.payroll.generate', compact('employeePayrollData'));
    }
}
