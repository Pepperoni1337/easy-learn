<?php

declare(strict_types=1);

namespace App\UI\Http\Shared;

use App\Core\Quiz\Model\QuizQuestion;
use App\Core\Shared\Model\Id;
use App\Util\ArrayUtil;

final class QuestionOutput
{
    public function __construct(
        public readonly Id $id,
        public readonly string $question,
        /** @var array<string> */
        public readonly array $possibleAnswers,
    ) {
    }

    public static function fromQuestion(QuizQuestion $question): self
    {
        $possibleAnswers = [
            $question->getAnswer(),
            $question->getWrongAnswer1(),
            $question->getWrongAnswer2(),
            $question->getWrongAnswer3(),
        ];

        $shuffledAnswers = ArrayUtil::shuffle($possibleAnswers);

        return new self(
            id: $question->getId(),
            question: $question->getQuestion(),
            possibleAnswers: $shuffledAnswers,
        );
    }
}