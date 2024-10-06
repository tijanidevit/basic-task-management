<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Employee extends Model
{
    use HasFactory, SoftDeletes, Notifiable;

    protected $guarded = ['id'];

    public function schedules() : BelongsToMany {
        return $this->belongsToMany(Schedule::class, 'employee_schedules');
    }

    public function employeeSchedules() : HasMany {
        return $this->hasMany(EmployeeSchedule::class);
    }
}
