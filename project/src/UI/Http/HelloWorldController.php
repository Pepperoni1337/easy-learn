<?php

declare(strict_types=1);

namespace App\UI\Http;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/')]
final class HelloWorldController extends AbstractController
{
    public function __invoke(): Response
    {
        return new Response('Hello World');
    }
}