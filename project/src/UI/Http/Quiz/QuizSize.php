<?php

declare(strict_types=1);

namespace App\UI\Http\Quiz;

enum QuizSize: string
{
    case Small = 'small';
    case Medium = 'medium';
    case Large = 'large';

    public function getMin(): int
    {
        return match ($this) {
            self::Small => 3,
            self::Medium => 5,
            self::Large => 10,
        };
    }

    public function getMax(): int
    {
        return match ($this) {
            self::Small => 5,
            self::Medium => 10,
            self::Large => 20,
        };
    }
}
