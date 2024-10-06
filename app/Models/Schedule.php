<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Schedule extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function employees() : BelongsToMany {
        return $this->belongsToMany(Employee::class, 'employee_schedules');
    }

    public function employeeSchedules() : HasMany {
        return $this->hasMany(EmployeeSchedule::class);
    }
}
