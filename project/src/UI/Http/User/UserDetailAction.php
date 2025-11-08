<?php

declare(strict_types=1);

namespace App\UI\Http\User;

use App\Core\User\Model\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/user/{user}/detail', name: 'app_user/detail')]
final class UserDetailAction extends AbstractController
{
    public function __invoke(User $user): Response
    {
        return $this->render('user/detail.html.twig', [
            'user' => $this->getUser(),
            'quizHistory' => 'test', //naposledy hrane kvizy
            'createdQuizzes' => 'test', //vytvorene kvizy
        ]);
    }
}
