<?php

declare(strict_types=1);

namespace App\Core\Quiz\Event;

use App\Core\Quiz\Model\QuizRating;
use App\Core\Shared\Event\Event;

final class RatingCreated implements Event
{
    public function __construct(
        public readonly QuizRating $rating,
    ) {
    }
}