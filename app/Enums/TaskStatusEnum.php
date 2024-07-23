<?php

namespace App\Enums;

enum TaskStatusEnum : string {
    case PENDING = 'pending';
    case COMPLETED = 'completed';

    public static function toArray(): array {
        return array_map(fn($case) => $case->value, static::cases());
    }
}
