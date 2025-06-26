<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employee';

    protected $fillable = [
        'user_id',
        'employee_number',
        'address',
        'birthday',
        'age',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function employeeDetails()
    {
        return $this->hasMany(EmployeeDetails::class, 'employee_id');
    }
}
