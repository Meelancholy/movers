<?php

namespace App\Livewire\CompensationAndBenefits;
use App\Models\Adjustment;
use Livewire\Component;

class Salaryadjustment extends Component
{
    function createOrUpdatePhilhealth($name, $rangestart, $rangeend, $percentage, $fixedamount) {
        // Check if a row with the same name already exists
        $existingAdjustment = Adjustment::where('adjustment', $name)->first();

        if ($existingAdjustment) {
            // If it exists, insert only the range details
            Adjustment::create([
                'adjustment' => $name, // Keep the same name
                'rangestart' => $rangestart,
                'rangeend' => $rangeend,
                'percentage' => $percentage,
                'fixedamount' => $fixedamount,
            ]);
        } else {
            // If it doesn't exist, insert both the name and range details
            Adjustment::create([
                'adjustment' => $name,
                'rangestart' => $rangestart,
                'rangeend' => $rangeend,
                'percentage' => $percentage,
                'fixedamount' => $fixedamount,
            ]);
        }
    }
    public function render() {
        // Fetch all adjustments
        $adjustments = Adjustment::all();

        // Group adjustments by the 'adjustment' field
        $groupedAdjustments = $adjustments->groupBy('adjustment');

        return view('livewire.compensation-and-benefits.salaryadjustment', compact('groupedAdjustments'));
    }
    public function deleteAdjustment($id)
    {
        $adjustment = Adjustment::findOrFail($id);
        $adjustment->delete();
        return redirect()->back()->with('success', 'Adjustment deleted successfully.');
    }
}
