<?php

declare(strict_types=1);

namespace App\UI\Http;

use App\Application\AI\QuestionGenerator;
use App\Core\User\Event\UserCreated;
use App\Util\StringUtil;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/test')]
final class TestAction extends AbstractController
{
    public function __construct(
        private readonly MessageBusInterface $bus,
    ) {
    }

    public function __invoke(): Response
    {
        $this->bus->dispatch(new UserCreated(3));
    }
}
