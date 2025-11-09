<?php

declare(strict_types=1);

namespace App\UI\Http\User;

use App\Core\Quiz\Query\FindMyQuizzes;
use App\Core\Shared\Traits\WithQueryBus;
use App\Core\User\Model\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/user/{user}/detail', name: 'app_user_detail')]
final class UserDetailAction extends AbstractController
{
    use WithQueryBus;

    public function __invoke(User $user): Response
    {
        return $this->render('user/detail.html.twig', [
            'user' => $user,
            'quizHistory' => 'test', //naposledy hrane kvizy
            'createdQuizzes' => $this->query(new FindMyQuizzes($user, 100)),
        ]);
    }
}
