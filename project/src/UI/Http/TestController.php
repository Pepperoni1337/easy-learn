<?php

declare(strict_types=1);

namespace App\UI\Http;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/test')]
final class TestController extends AbstractController
{

    public function __invoke(): Response
    {
        return $this->render('test.html.twig');
    }
}
