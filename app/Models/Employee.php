<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = [
        'first_name', 'last_name', 'email', 'contact', 'hire_date', 'department_id', 'position_id', 'status', 'department', 'position', 'gender', 'bdate', 'job_type'
    ];
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
    // In Employee.php model
    public function adjustments()
    {
        return $this->belongsToMany(Adjustment::class, 'employee_adjustment')
                   ->withPivot('frequency')
                   ->withTimestamps();
    }
        // In Employee model
    public function salary()
    {
        return $this->hasOne(EmployeeSalary::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
