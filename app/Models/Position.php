<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $table = 'position';

    protected $fillable = [
        'created_by',
        'name',
    ];

    // public function employee()
    // {
    //     return $this->hasMany(Employee::class);
    // }
}
