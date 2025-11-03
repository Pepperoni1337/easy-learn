<?php

declare(strict_types=1);

namespace App\UI\Http;

use App\Core\Shared\Traits\WithEventDispatcher;
use App\Core\User\Event\UserCreated;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/test')]
final class TestAction extends AbstractController
{
    use WithEventDispatcher;

    public function __invoke(): Response
    {
        $this->dispatch(new UserCreated(3));
    }
}
