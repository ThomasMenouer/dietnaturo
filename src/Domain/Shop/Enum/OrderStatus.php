<?php

namespace App\Domain\Shop\Enum;

enum OrderStatus: string
{
    case PENDING = 'pending';
    case CANCELLED = 'cancelled';


    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::CANCELLED => 'cancelled',
        };
    }
}