<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Payroll;
use Barryvdh\DomPDF\Facade\Pdf;

class Payrollrecords extends Component
{
    use WithPagination;

    public $search = '';
    protected $queryString = ['search'];

    public function searchEmployees()
    {
        $this->resetPage();
    }

public function downloadPdf($payrollId)
{
    try {
        $payroll = Payroll::with(['employee', 'cycle', 'payrollAdjustments.adjustment'])
                        ->findOrFail($payrollId);

        // Configure PDF options
        $pdf = Pdf::loadView('payroll.pdf', ['payroll' => $payroll])
                ->setOption('defaultFont', 'DejaVu Sans')
                ->setOption('isHtml5ParserEnabled', true)
                ->setOption('isRemoteEnabled', true)
                ->setOption('isPhpEnabled', true)
                ->setOption('encoding', 'UTF-8');

        return response()->streamDownload(
            fn () => print($pdf->output()),
            "payroll-{$payroll->employee->id}-{$payroll->created_at->format('Ymd')}.pdf",
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment'
            ]
        );

    } catch (\Exception $e) {
        session()->flash('error', 'Failed to generate PDF: '.$e->getMessage());
        return back();
    }
}
    public function render()
    {
        $payrolls = Payroll::with(['employee', 'cycle'])
            ->whereHas('employee', function($query) {
                $query->when($this->search, function($q) {
                    $q->where('first_name', 'like', '%'.$this->search.'%')
                      ->orWhere('last_name', 'like', '%'.$this->search.'%');
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.payrollrecords', [
            'payrolls' => $payrolls
        ]);
    }
}
