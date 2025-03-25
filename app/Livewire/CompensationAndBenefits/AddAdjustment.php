<?php

namespace App\Livewire\CompensationAndBenefits;
use App\Models\Adjustments;
use Livewire\Component;

class AddAdjustment extends Component
{
    public $adjustment;
    public $rangestart;
    public $rangeend;
    public $operation;
    public $percentage;
    public $fixedamount;

    protected $rules = [
        'adjustment' => 'required|string',
        'rangestart' => 'nullable|string',
        'rangeend' => 'nullable|string',
        'operation' => 'required|string',
        'percentage' => 'nullable|string|required_without:fixedamount',
        'fixedamount' => 'nullable|string|required_without:percentage',
    ];

    protected $messages = [
        'percentage.required_without' => 'Either percentage or fixed amount is required (but not both).',
        'fixedamount.required_without' => 'Either fixed amount or percentage is required (but not both).',
    ];

    public function updated($propertyName)
    {
        // When percentage is updated, clear fixed amount if percentage has value
        if ($propertyName === 'percentage' && $this->percentage) {
            $this->fixedamount = null;
        }

        // When fixed amount is updated, clear percentage if fixed amount has value
        if ($propertyName === 'fixedamount' && $this->fixedamount) {
            $this->percentage = null;
        }

        $this->validateOnly($propertyName);
    }

    public function submit()
    {
        $this->validate();

        Adjustments::create([
            'adjustment' => $this->adjustment,
            'rangestart' => $this->rangestart,
            'rangeend' => $this->rangeend,
            'operation' => $this->operation,
            'percentage' => $this->percentage,
            'fixedamount' => $this->fixedamount,
        ]);
        return view('livewire.compensation-and-benefits.add-adjustment');
    }
    public function render()
    {
        $adjustments = Adjustments::all();
        return view('livewire.compensation-and-benefits.add-adjustment');
    }
}
