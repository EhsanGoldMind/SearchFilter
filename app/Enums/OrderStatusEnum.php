<?php

namespace App\Enums;
enum OrderStatusEnum: int
{
    case REJECTED = 1;
    case PENDING = 0;
    case COMPLETED = 2;

    public static function getName(int $value): ?string
    {
        return match ($value) {
            self::REJECTED->value => 'رد',
            self::PENDING->value => 'در حال انجام',
            self::COMPLETED->value => 'تایید',
            default => null,
        };
    }

    public static function getValue(int $value): ?string
    {
        return match ($value) {
            self::COMPLETED->value => 2,
            self::REJECTED->value => 1,
            self::PENDING->value => 0,
            default => null,
        };
    }
}
