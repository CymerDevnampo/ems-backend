<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employee';

    protected $fillable = [
        'created_by',
        'user_id',
        'employee_number',
        'address',
        'birthday',
        'age',
    ];

    // protected $hidden = ['id', 'user_id', 'encrypted_id'];
    protected $hidden = ['id', 'user_id',];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function employeeDetails()
    {
        return $this->hasMany(EmployeeDetails::class, 'employee_id');
    }
}
