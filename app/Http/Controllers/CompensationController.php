<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Services\ContributionService;
use App\Models\Deduction;
use App\Models\Bonus;
use Illuminate\Http\Request;

class CompensationController extends Controller
{
    protected $contributionService;

    public function __construct(ContributionService $contributionService)
    {
        $this->contributionService = $contributionService;
    }
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
/*     public function storeContribution(Request $request)
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
    } */

    // Display form for creating a new deduction
    public function createDeduction()
    {
        $employees = Employee::all();
        return view('hr1.compensation.create_deduction', compact('employees'));
    }

    public function storeDeduction(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'deduction_name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:1',
            'deduction_type' => 'required|string|in:one_time,recurring,recurring_indefinitely',
            'frequency' => 'nullable|integer|min:1', // Optional frequency for recurring deductiones
        ]);

        // Prepare frequency based on deduction type
        $frequency = null;

        switch ($request->deduction_type) {
            case 'one_time':
                $frequency = 1; // For one-time deductiones
                break;
            case 'recurring':
                $frequency = $request->frequency; // User-defined frequency
                break;
            case 'recurring_indefinitely':
                $frequency = -1; // For recurring indefinitely
                break;
            default:
                // Handle unexpected cases (if needed)
                return redirect()->route('compensation.index')->with('error', 'Invalid deduction type.');
        }

        // Prepare deduction data
        $deductionData = [
            'employee_id' => $request->employee_id,
            'deduction_name' => $request->deduction_name,
            'amount' => $request->amount,
            'frequency' => $frequency,
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
            'bonus_name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:1',
            'bonus_type' => 'required|string|in:one_time,recurring,recurring_indefinitely',
            'frequency' => 'nullable|integer|min:1', // Optional frequency for recurring bonuses
        ]);

        // Prepare frequency based on bonus type
        $frequency = null;

        switch ($request->bonus_type) {
            case 'one_time':
                $frequency = 1; // For one-time bonuses
                break;
            case 'recurring':
                $frequency = $request->frequency; // User-defined frequency
                break;
            case 'recurring_indefinitely':
                $frequency = -1; // For recurring indefinitely
                break;
            default:
                // Handle unexpected cases (if needed)
                return redirect()->route('compensation.index')->with('error', 'Invalid bonus type.');
        }

        // Prepare bonus data
        $bonusData = [
            'employee_id' => $request->employee_id,
            'bonus_name' => $request->bonus_name,
            'amount' => $request->amount,
            'frequency' => $frequency,
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

    /**
     * Delete a deduction.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteDeduction($id)
    {
        // Find the deduction by its ID or throw a 404 if not found
        $deduction = Deduction::findOrFail($id);

        // Delete the deduction
        $deduction->delete();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Deduction deleted successfully.');
    }

    /**
     * Delete a bonus.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteBonus($id)
    {
        // Find the bonus by its ID or throw a 404 if not found
        $bonus = Bonus::findOrFail($id);

        // Delete the bonus
        $bonus->delete();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Bonus deleted successfully.');
    }

    // View employee details with contributions, deductions, and bonuses
    public function viewEmployee($id)
    {
        $employee = Employee::with('position', 'contributions')->findOrFail($id);
        $contributions = $this->contributionService->calculateContributions($employee);

        // Pass contributions along with the employee data to the view
        return view('hr1.compensation.view_employee', array_merge([
            'employee' => $employee
        ], $contributions));
    }


}
