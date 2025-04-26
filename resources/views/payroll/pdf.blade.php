<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Movers - Payroll Slip</title>
    <style>
        @page {
            size: landscape;
            margin: 10px;
        }
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 15px;
            color: #333;
            font-size: 12px;
            line-height: 1.3;
        }
        .header {
            text-align: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #2c3e50;
        }
        .company-name {
            font-size: 20px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 5px;
        }
        .payroll-title {
            font-size: 14px;
            color: #7f8c8d;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .details-section {
            display: flex;
            margin-bottom: 15px;
        }
        .details-column {
            width: 48%;
        }
        .section-title {
            font-weight: bold;
            font-size: 13px;
            color: #2c3e50;
            border-bottom: 1px solid #eee;
            padding-bottom: 3px;
            margin-bottom: 8px;
        }
        .amounts-section {
            border: 1px solid #ddd;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 3px;
            margin-bottom: 15px;
        }
        .amount-row {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
        }
        .adjustments-table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
            font-size: 11px;
        }
        .adjustments-table th {
            padding: 5px;
            border: 1px solid #ddd;
            background-color: #f5f5f5;
            text-align: left;
        }
        .adjustments-table td {
            padding: 5px;
            border: 1px solid #ddd;
        }
        .positive-amount { color: #27ae60; }
        .negative-amount { color: #e74c3c; }
        .totals-section {
            margin-top: 15px;
        }
        .net-pay {
            font-size: 14px;
            font-weight: bold;
            background-color: #f8f9fa;
            padding: 8px;
            border-radius: 3px;
            margin-top: 10px;
        }
        .text-right {
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">MOVERS COMPANY</div>
        <div class="payroll-title">Employee Payroll Slip</div>
    </div>

    <div class="details-section">
        <div class="details-column">
            <div class="section-title">Employee Information</div>
            <p><strong>Name:</strong> {{ $payroll->employee->first_name }} {{ $payroll->employee->last_name }}</p>
            <p><strong>Position:</strong> {{ $payroll->employee->position }}</p>
            <p><strong>Employee ID:</strong> {{ $payroll->employee->id }}</p>
        </div>
        <div class="details-column text-right">
            <div class="section-title">Payroll Details</div>
            <p><strong>Pay Period:</strong> {{ $payroll->cycle->start_date->format('M d, Y') }} - {{ $payroll->cycle->end_date->format('M d, Y') }}</p>
            <p><strong>Date Generated:</strong> {{ $payroll->created_at->format('M d, Y') }}</p>
            <p><strong>Payroll ID:</strong> {{ $payroll->id }}</p>
        </div>
    </div>

    <div class="amounts-section">
        <div class="amount-row"><span>Hours Worked:</span><span><strong>{{ $payroll->hours_worked }} hours</strong></span></div>
        <div class="amount-row"><span>Basic Pay:</span><span><strong>PHP {{ number_format($payroll->base_pay, 2) }}</strong></span></div>
        <div class="amount-row"><span>Tax:</span><span><strong>PHP {{ number_format($payroll->tax, 2) }}</strong></span></div>
</div>

    <div class="section-title">Payroll Adjustments</div>
    @if($payroll->payrollAdjustments->count() > 0)
        <table class="adjustments-table">
            <thead>
                <tr>
                    <th>Adjustment</th>
                    <th>Type</th>
                    <th style="text-align: right;">Amount</th>
                    <th>Details</th>
                    <th>Employer Share</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payroll->payrollAdjustments as $adjustment)
                    @php
                        $details = $adjustment->adjustment_details;
                    @endphp
                    <tr>
                        <td>{{ $details['adjustment'] ?? 'N/A' }}</td>
                        <td>{{ ucfirst($adjustment->type) }}</td>
                        <td style="text-align: right;">
                            @if($adjustment->type === 'incentive')
                                <span class="positive-amount">+PHP {{ number_format($adjustment->amount, 2) }}</span>
                            @else
                                <span class="negative-amount">-PHP {{ number_format($adjustment->amount, 2) }}</span>
                            @endif
                        </td>
                        <td>
                            @if(!empty($details['percentage']))
                                {{ $details['percentage'] }}%
                            @elseif(!empty($details['fixedamount']))
                                Fixed amount
                            @endif
                            @if(!empty($details['rangestart']) && !empty($details['rangeend']))
                                <br>Range: {{ $details['rangestart'] }} - {{ $details['rangeend'] }}
                            @endif
                        </td>
                        <td>
                            @if($adjustment->type === 'contribution')
                                <span>{{ number_format($adjustment->amount, 2) }}</span>
                            @else
                                <span></span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p style="font-style: italic; color: #777;">No adjustments applied</p>
    @endif

    <div class="totals-section">
        <div class="amount-row">
            <span>Gross Pay:</span>
            <span><strong>PHP {{ number_format($payroll->gross_pay, 2) }}</strong></span>
        </div>
        <div class="net-pay amount-row">
            <span>NET PAY:</span>
            <span>PHP {{ number_format($payroll->net_pay, 2) }}</span>
        </div>
    </div>
</body>
</html>
