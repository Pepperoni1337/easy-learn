<?php

declare(strict_types=1);

namespace App\Core\Quiz\Model;

use App\Core\Shared\Model\Entity;
use App\Core\Shared\Model\EntityTrait;
use App\Core\Shared\Model\Id;
use App\Core\User\Model\User;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
class QuizRating implements Entity
{
    use EntityTrait;

    public const QUIZ = 'quiz';
    public const USER = 'user';
    public const RATING = 'rating';

    #[ORM\ManyToOne(targetEntity: Quiz::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private Quiz $quiz;

    #[ORM\ManyToOne(targetEntity: User::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private User $user;

    #[ORM\Column(type: Types::INTEGER)]
    #[Assert\Range(min: 1, max: 5)]
    private int $rating;

    public function __construct(
        Quiz $quiz,
        User $user,
        int $rating,
    ) {
        $this->id = Id::new();
        $this->quiz = $quiz;
        $this->user = $user;
        $this->rating = $rating;
    }

    public function getQuiz(): Quiz
    {
        return $this->quiz;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getRating(): int
    {
        return $this->rating;
    }

    public function setRating(int $rating): void
    {
        $this->rating = $rating;
    }
}
