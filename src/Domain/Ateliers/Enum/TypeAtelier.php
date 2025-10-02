<?php

namespace App\Domain\Ateliers\Enum;

enum TypeAtelier: string
{
    case ATELIER = 'Atelier';
    case ATELIER_FLASH = 'Atelier Flash';
    case COURS_YOGA = 'Cours de Yoga';

    public function label(): string
    {
        return match ($this) {
            self::ATELIER => 'Atelier',
            self::ATELIER_FLASH => 'Atelier Flash',
            self::COURS_YOGA => 'Cours de Yoga',

        };
    }
}