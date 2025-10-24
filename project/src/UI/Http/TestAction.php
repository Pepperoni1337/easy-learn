<?php

declare(strict_types=1);

namespace App\UI\Http;

use App\Application\AI\QuestionGenerator;
use App\Util\StringUtil;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/test')]
final class TestAction extends AbstractController
{
    public function __construct(
        private readonly QuestionGenerator $generator,
    ) {
    }

    public function __invoke(): Response
    {
        $prompt = StringUtil::concat(

        );

        dd($this->generator->generateQuestions($prompt, 2,5));

        return $this->render('test.html.twig');
    }
}
