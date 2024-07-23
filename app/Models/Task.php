<?php

namespace App\Models;

use App\Enums\TaskStatusEnum;
use App\Traits\HasCreator;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory, HasUuids, HasCreator;

    protected $guarded = ['id'];
    protected $attributes = [
        'status' => TaskStatusEnum::PENDING->value,
    ];
}
