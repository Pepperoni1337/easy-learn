<?php

namespace App\Core\Quiz\Model;

enum Difficulty: string
{
    case Easy = 'easy';
    case Medium = 'medium';
    case Hard = 'hard';

    public function getCzechName(): string
    {
        return match ($this) {
            self::Easy => 'Jednoduchá',
            self::Medium => 'Středí',
            self::Hard => 'Těžká',
        };
    }
}
