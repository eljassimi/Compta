<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Salary extends Model
{
    use HasFactory;

protected $fillable = ['employee_id', 'base_salary', 'employee_contribution', 'employer_contribution', 'ir', 'net_salary', 'bonus', 'deduction', 'month', 'year'];
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
