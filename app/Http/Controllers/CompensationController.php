<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Services\ContributionService;
use Illuminate\Http\Request;

class CompensationController extends Controller
{
    public function index()
    {
        return view('hr1.compensation.index');
    }
    public function addAdjustment()
    {
        return view('hr1.compensation.AddAdjustment');
    }
}
