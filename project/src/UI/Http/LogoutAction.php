<?php

declare(strict_types=1);

namespace App\UI\Http;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/logout', name: 'app_logout')]
final class LogoutAction extends AbstractController
{
    public function __invoke(): void
    {
        // This method will never be executed.
        // Symfony's security system intercepts this route and handles the logout.
        throw new \LogicException('This method can be blank - it will never be called!');
    }
}
