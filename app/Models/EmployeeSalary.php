<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeSalary extends Model
{
    protected $fillable = ['user_id', 'base_salary', 'bonus', 'deduction', 'month', 'year', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getTotalSalaryAttribute()
    {
        return $this->base_salary + $this->bonus - $this->deduction;
    }
}
