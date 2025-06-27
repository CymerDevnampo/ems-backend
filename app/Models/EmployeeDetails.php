<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeDetails extends Model
{
    protected $table = 'employee_details';

    protected $fillable = [
        'employee_id',
        'department',
        'position',
        'company',
        'sss',
        'tin',
        'philhealth',
        'hdmf',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function position()
    {
        return $this->belongsTo(Position::class, 'position'); 
    }
}
