<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Payroll;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    /**
     * Show the Generate Payroll page.
     */
    public function create()
    {
        // Get all employees with their positions and base salary
        $employees = Employee::with('position')->get();
        return view('hr1.payroll.generate', compact('employees'));
    }

    /**
     * Store generated payroll.
     */
    public function store(Request $request)
    {
        // Loop through each employee and calculate payroll
        foreach ($request->bonus as $employeeId => $bonus) {
            $employee = Employee::findOrFail($employeeId);
            $baseSalary = $employee->position->base_salary;

            // Tax computation (using your provided tax table)
            $tax = $this->calculateTax($baseSalary);

            // Get deductions, benefits, and net salary calculations
            $deductions = $request->deductions[$employeeId] ?? 0;
            $benefits = $request->benefits[$employeeId] ?? 0;
            $netSalary = $baseSalary - $tax + $bonus - $deductions + $benefits;

            // Store payroll in the database
            Payroll::create([
                'employee_id' => $employee->id,
                'salary' => $baseSalary,
                'bonus' => $bonus,
                'deductions' => $deductions,
                'benefits' => $benefits,
                'net_pay' => $netSalary,
            ]);
        }

        // Redirect to Payroll Records page
        return redirect()->route('payroll.records')->with('success', 'Payroll generated successfully.');
    }

    /**
     * Show payroll records.
     */
    public function records(Request $request)
    {
        // If search by employee name is used, filter results
        $payrolls = Payroll::with('employee')
            ->when($request->employee_name, function ($query) use ($request) {
                $query->whereHas('employee', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->employee_name . '%');
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Get recent payroll transactions (e.g., last 5)
        $recentTransactions = Payroll::with('employee')->latest()->limit(5)->get();

        return view('hr1.payroll.records', compact('payrolls', 'recentTransactions'));
    }

    /**
     * Show detailed payroll for an employee.
     */
    public function show($id)
    {
        // Get payroll for the specific employee
        $payroll = Payroll::with('employee')->findOrFail($id);

        return view('hr1.payroll.show', compact('payroll'));
    }

    /**
     * Calculate tax based on salary.
     */
    private function calculateTax($baseSalary)
    {
        $tax = 0;

        if ($baseSalary > 666667) {
            $tax = 200833.33 + ($baseSalary - 666667) * 0.35;
        } elseif ($baseSalary > 166667) {
            $tax = 40833.33 + ($baseSalary - 166667) * 0.30;
        } elseif ($baseSalary > 66667) {
            $tax = 10833.33 + ($baseSalary - 66667) * 0.25;
        } elseif ($baseSalary > 33333) {
            $tax = 2500 + ($baseSalary - 33333) * 0.20;
        } elseif ($baseSalary > 20833) {
            $tax = ($baseSalary - 20833) * 0.15;
        }

        return $tax;
    }
}
