<?php

declare(strict_types=1);

namespace App\Core\QuizSession\Model;

use App\Core\Shared\Model\Entity;
use App\Core\Shared\Model\EntityTrait;
use App\Core\Shared\Model\Id;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class QuizSessionSettings implements Entity
{
    use EntityTrait;

    public const KEEP_WRONGLY_ANSWERED_QUESTIONS = 'keepWronglyAnsweredQuestions';
    public const RANDOM_ORDER = 'randomOrder';

    #[ORM\Column(type: Types::BOOLEAN, options: ['default' => true])]
    private bool $keepWronglyAnsweredQuestions;

    #[ORM\Column(type: Types::BOOLEAN, options: ['default' => true])]
    private bool $randomOrder;

    public function __construct(
        bool $keepWronglyAnsweredQuestions,
        bool $randomOrder,
    ) {
        $this->id = Id::new();
        $this->keepWronglyAnsweredQuestions = $keepWronglyAnsweredQuestions;
        $this->randomOrder = $randomOrder;
    }

    public function isKeepWronglyAnsweredQuestions(): bool
    {
        return $this->keepWronglyAnsweredQuestions;
    }

    public function isRandomOrder(): bool
    {
        return $this->randomOrder;
    }
}
