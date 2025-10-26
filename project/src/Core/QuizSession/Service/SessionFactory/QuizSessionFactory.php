<?php

declare(strict_types=1);

namespace App\Core\QuizSession\Service\SessionFactory;

use App\Core\Quiz\Model\Quiz;
use App\Core\QuizSession\Model\GameStyle;
use App\Core\QuizSession\Model\QuizSession;
use App\Core\User\Model\User;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag(QuizSessionFactory::class)]
interface QuizSessionFactory
{
    public function supports(GameStyle $style): bool;

    public function createNewSession(Quiz $quiz, User $user): QuizSession;
}