<?php

namespace App\Enums;

enum SubscriptionType: int
{
    case BASIC = 1;
    case PREMIUM = 2;
    case BUSINESS = 3;

    // (opsional) helper untuk label
    public function label(): string
    {
        return match ($this) {
            self::BASIC => 'Basic',
            self::PREMIUM => 'Premium',
            self::BUSINESS => 'Business',
        };
    }

    // (opsional) durasi default
    public function durationDays(): int
    {
        return match ($this) {
            self::BASIC => 30,
            self::PREMIUM => 30,
            self::BUSINESS => 30,
        };
    }
}
