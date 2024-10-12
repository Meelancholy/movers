<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Contribution;
use App\Models\Deduction;
use App\Models\Bonus;
use Illuminate\Http\Request;

class CompensationController extends Controller
{
    // Display all employees with their contributions, deductions, and bonuses
    public function index()
    {
        $employees = Employee::with(['contributions', 'deductions', 'bonuses'])->get();
        return view('hr1.compensation.index', compact('employees'));
    }

/*     // Display form for creating a new contribution
    public function createContribution()
    {
        $employees = Employee::all();
        return view('hr1.compensation.create_contribution', compact('employees'));
    } */

    // Store a new contribution
    public function storeContribution(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'philhealth' => 'nullable|boolean',
            'sss' => 'nullable|boolean',
            'pagibig' => 'nullable|boolean',
            'is_recurring' => 'nullable|boolean',
        ]);

        Contribution::updateOrCreate(
            ['employee_id' => $request->employee_id],
            $request->only(['philhealth', 'sss', 'pagibig', 'is_recurring'])
        );

        return redirect()->route('compensation.index')->with('success', 'Contribution added successfully.');
    }

    // Display form for creating a new deduction
    public function createDeduction()
    {
        $employees = Employee::all();
        return view('hr1.compensation.create_deduction', compact('employees'));
    }

    // Store a new deduction
    public function storeDeduction(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'deduction_name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:1',
            'deduction_type' => 'required|in:one_time,recurring,recurring_indefinitely',
            'frequency' => 'nullable|integer|min:1', // Frequency is only required for recurring type
        ]);

        // Check if frequency is required based on deduction type
        if ($request->deduction_type == 'recurring' && !$request->filled('frequency')) {
            return back()->withErrors(['frequency' => 'Frequency is required for recurring deductions.']);
        }

        // Prepare data for storing the deduction
        $deductionData = [
            'employee_id' => $request->employee_id,
            'deduction_name' => $request->deduction_name,
            'amount' => $request->amount,
            'deduction_type' => $request->deduction_type,
            'frequency' => $request->deduction_type == 'recurring' ? $request->frequency : null,
        ];

        // Create or update deduction record
        Deduction::updateOrCreate(
            [
                'employee_id' => $request->employee_id,
                'deduction_name' => $request->deduction_name,
            ],
            $deductionData
        );

        // Redirect to the compensation index with success message
        return redirect()->route('compensation.index')->with('success', 'Deduction added successfully.');
    }


    // Display form for creating a new bonus
    public function createBonus()
    {
        $employees = Employee::all();
        return view('hr1.compensation.create_bonus', compact('employees'));
    }

    public function storeBonus(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'bonus_name' => 'required|string|max:255', // Added max length for bonus_name
            'amount' => 'required|numeric|min:1', // Minimum amount validation
            'bonus_type' => 'required|in:one_time,recurring,recurring_indefinitely', // Validate bonus type
            'frequency' => 'nullable|integer|min:1', // Frequency is only required for recurring type
        ]);

        // Check if frequency is required based on bonus type
        if ($request->bonus_type == 'recurring' && !$request->filled('frequency')) {
            return back()->withErrors(['frequency' => 'Frequency is required for recurring bonuses.']);
        }

        // Prepare data for storing the bonus
        $bonusData = [
            'employee_id' => $request->employee_id,
            'bonus_name' => $request->bonus_name,
            'amount' => $request->amount,
            'bonus_type' => $request->bonus_type,
            'frequency' => $request->bonus_type == 'recurring' ? $request->frequency : null, // Store frequency only for recurring bonuses
        ];

        // Create or update bonus record
        Bonus::updateOrCreate(
            [
                'employee_id' => $request->employee_id,
                'bonus_name' => $request->bonus_name,
            ],
            $bonusData
        );

        // Redirect to the compensation index with success message
        return redirect()->route('compensation.index')->with('success', 'Bonus added successfully.');
    }



    // Display employee for editing their contributions, deductions, and bonuses
    public function editEmployee($id)
    {
        $employee = Employee::with(['contributions', 'deductions', 'bonuses'])->findOrFail($id);
        return view('hr1.compensation.edit_employee', compact('employee'));
    }

    public function updateEmployee(Request $request, $id)
    {
        $request->validate([
            'contributions' => 'nullable|array',
            'deductions' => 'nullable|array',
            'bonuses' => 'nullable|array',
        ]);

        $employee = Employee::findOrFail($id);

        // Update contributions if provided
        if ($request->has('contributions')) {
            // Retrieve existing contributions
            $existingContributions = $employee->contributions->first();

            if ($existingContributions) {
                // Update contributions based on checkboxes
                foreach (['philhealth', 'sss', 'pagibig'] as $key) {
                    if (isset($request->contributions[$key]) && $request->contributions[$key] == 1) {
                        // Activate contribution
                        $employee->contributions()->updateOrCreate([], [$key => true]);
                    } else {
                        // Deactivate contribution
                        $employee->contributions()->updateOrCreate([], [$key => false]);
                    }
                }
            } else {
                // Create contributions if they don't exist
                $employee->contributions()->create([
                    'philhealth' => $request->contributions['philhealth'] ?? false,
                    'sss' => $request->contributions['sss'] ?? false,
                    'pagibig' => $request->contributions['pagibig'] ?? false,
                ]);
            }
        } else {
            // If no contributions are submitted, delete all contributions
            $employee->contributions()->delete();
        }

        // Update deductions if provided
        if ($request->has('deductions')) {
            foreach ($request->deductions as $deduction) {
                $employee->deductions()->updateOrCreate(
                    ['deduction_name' => $deduction['deduction_name']],
                    ['amount' => $deduction['amount']]
                );
            }
        }

        // Update bonuses if provided
        if ($request->has('bonuses')) {
            foreach ($request->bonuses as $bonus) {
                $employee->bonuses()->updateOrCreate(
                    ['bonus_name' => $bonus['bonus_name']],
                    ['amount' => $bonus['amount']]
                );
            }
        }

        return redirect()->route('compensation.index')->with('success', 'Employee updated successfully.');
    }

    public function deleteDeduction($id)
    {
        $deduction = Deduction::findOrFail($id);
        $deduction->delete();

        return redirect()->back()->with('success', 'Deduction deleted successfully.');
    }

    public function deleteBonus($id)
    {
        $bonus = Bonus::findOrFail($id);
        $bonus->delete();

        return redirect()->back()->with('success', 'Bonus deleted successfully.');
    }

    // View employee details with contributions, deductions, and bonuses
    public function viewEmployee($id)
    {
        $employee = Employee::with('position', 'contributions')->findOrFail($id);
        // Check if the employee has a position and retrieve the base salary, otherwise set to 0
        $salary = $employee->position ? $employee->position->base_salary : 0;
        // Initialize contribution variables
        $philhealth_employee_share = 0;
        $philhealth_employer_share = 0;
        $sssContribution = ['employee_share' => 0, 'employer_share' => 0];
        $pagibig_employee_share = 0;
        $pagibig_employer_share = 0;

        $philhealthContribution = $employee->contributions->firstWhere('philhealth', 1);
        $sssContributionData = $employee->contributions->firstWhere('sss', 1);
        $pagibigContribution = $employee->contributions->firstWhere('pagibig', 1);

        // PhilHealth Calculation
        if ($philhealthContribution && $philhealthContribution->philhealth == 1) {
            if ($salary <= 10000) {
                $philhealth_employee_share = 200.00;
                $philhealth_employer_share = 200.00;
            } elseif ($salary > 10000 && $salary <= 80000) {
                $philhealth_total = $salary * 0.04;
                $philhealth_employee_share = $philhealth_total / 2;
                $philhealth_employer_share = $philhealth_total / 2;
            } else {
                $philhealth_employee_share = 1600.00;
                $philhealth_employer_share = 1600.00;
            }
        }

        // SSS Calculation
        if ($sssContributionData && $sssContributionData->sss == 1) {
            $sssTable = [
                [4250, 380, 180],
                [4749.99, 427.50, 202.50],
                [5249.99, 475, 225],
                [5749.99, 522.50, 247.50],
                [6249.99, 570, 270],
                [6749.99, 617.50, 292.50],
                [7249.99, 665, 315],
                [7749.99, 712.50, 337.50],
                [8249.99, 760, 360],
                [8749.99, 807.50, 382.50],
                [9249.99, 855, 405],
                [9749.99, 902.50, 427.50],
                [10249.99, 950, 450],
                [10749.99, 997.50, 472.50],
                [11249.99, 1045, 495],
                [11749.99, 1092.50, 517.50],
                [12249.99, 1140, 540],
                [12749.99, 1187.50, 562.50],
                [13249.99, 1235, 585],
                [13749.99, 1282.50, 607.50],
                [14249.99, 1330, 630],
                [14749.99, 1377.50, 652.50],
                [15249.99, 1425, 675],
                [15749.99, 1472.50, 697.50],
                [16249.99, 1520, 720],
                [16749.99, 1567.50, 742.50],
                [17249.99, 1615, 765],
                [17749.99, 1662.50, 787.50],
                [18249.99, 1710, 810],
                [18749.99, 1757.50, 832.50],
                [19249.99, 1805, 855],
                [19749.99, 1852.50, 877.50],
                [20249.99, 1900, 900],
                [20749.99, 1947.50, 922.50],
                [21249.99, 1995, 945],
                [21749.99, 2042.50, 967.50],
                [22249.99, 2090, 990],
                [22749.99, 2137.50, 1012.50],
                [23249.99, 2185, 1035],
                [23749.99, 2232.50, 1057.50],
                [24249.99, 2280, 1080],
                [24749.99, 2327.50, 1102.50],
                [25249.99, 2375, 1125],
                [25749.99, 2422.50, 1147.50],
                [26249.99, 2470, 1170],
                [26749.99, 2517.50, 1192.50],
                [27249.99, 2565, 1215],
                [27749.99, 2612.50, 1237.50],
                [28249.99, 2660, 1260],
                [28749.99, 2707.50, 1282.50],
                [29249.99, 2755, 1305],
                [29749.99, 2802.50, 1327.50],
            ];
            if ($salary <= 29750) {
                foreach ($sssTable as $bracket) {
                    if ($salary <= $bracket[0]) {
                        $sssContribution['employee_share'] = $bracket[1];
                        $sssContribution['employer_share'] = $bracket[2];
                        break;
                    }
                }
            } else {
                $sssContribution['employee_share'] = 2802.50;
                $sssContribution['employer_share'] = 1327.50;
            }
        }

        // Pag-IBIG Calculation
        if ($pagibigContribution && $pagibigContribution->pagibig == 1) {
            if ($salary <= 1500) {
                $pagibig_employee_share = 15.00;
                $pagibig_employer_share = 30.00;
            } else {
                $pagibig_employee_share = min($salary * 0.02, 200);
                $pagibig_employer_share = min($salary * 0.02, 200);
            }
        }
        // Pass all variables to the view
        return view('hr1.compensation.view_employee', compact('employee', 'salary', 'sssContribution', 'philhealth_employee_share', 'philhealth_employer_share', 'pagibig_employee_share', 'pagibig_employer_share'));
    }

}
