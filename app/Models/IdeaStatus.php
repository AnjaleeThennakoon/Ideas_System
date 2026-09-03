<?php

namespace App\Models;

enum IdeaStatus: string
{
    // define rules for status   -php enum(only 3 idea )
    case PENDING = 'pending';
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'pending',
            self::IN_PROGRESS => 'In_progress',
            self::COMPLETED => 'Completed',
        };
    }

    public static function values()
    {
        return array_map(fn ($status) => $status->value, self::cases());
    }
}
