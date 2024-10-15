<?php
namespace App\Http\Controllers;

use App\Models\Department; // Replace with your actual model
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function index()
    {
        $data = Department::all(); // Fetch all records from the table
        return response()->json($data);
    }
}
