<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeSchedule extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function schedule() : BelongsTo {
        return $this->belongsTo(Schedule::class);
    }

    public function employee() : BelongsTo {
        return $this->belongsTo(Employee::class);
    }
}
