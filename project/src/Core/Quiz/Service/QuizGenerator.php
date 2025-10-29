<?php

declare(strict_types=1);

namespace App\Core\Quiz\Service;

use App\Application\AI\QuestionGenerator;
use App\Core\Quiz\Model\Quiz;
use App\Core\Quiz\Model\QuizQuestion;
use App\Core\User\Model\User;
use App\Infrastructure\OpenAI\PromptService;
use App\UI\Http\Quiz\QuizDto;

final class QuizGenerator
{
    public function __construct(
        private readonly QuestionGenerator $generator,
        private readonly PromptService $promptService,
    ) {
    }

    public function generateQuiz(User $user, QuizDto $quizDto): Quiz
    {
        $quiz = new Quiz(
            $user,
        );
        $quiz->setTitle($quizDto->name);
        $quiz->setDescription($quizDto->prompt);

        $size = $quizDto->size;

        $questions = $this->generator->generateQuestions(
            $this->promptService->createPrompt($quizDto->prompt),
            $size->getMin(),
            $size->getMax(),
        );

        foreach ($questions as $questionDto) {
            $quizQuestion = new QuizQuestion(
                quiz: $quiz,
                question: $questionDto->question,
                answer: $questionDto->answer,
            );
            $quizQuestion->setWrongAnswer1($questionDto->wrongAnswer1);
            $quizQuestion->setWrongAnswer2($questionDto->wrongAnswer2);
            $quizQuestion->setWrongAnswer3($questionDto->wrongAnswer3);
            $quiz->addQuestion($quizQuestion);
        }

        return $quiz;
    }
}
