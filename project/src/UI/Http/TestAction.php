<?php

declare(strict_types=1);

namespace App\UI\Http;

use App\Core\Shared\Traits\WithEventDispatcher;
use App\Core\Shared\Traits\WithQueryBus;
use App\Core\User\Event\UserCreated;
use App\Core\User\Query\GetUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/test')]
final class TestAction extends AbstractController
{
    use WithEventDispatcher;
    use WithQueryBus;

    public function __invoke(): Response
    {
        $test = $this->query(new GetUser('asdda'));

        dump($test);

        $this->dispatch(new UserCreated(3));
    }
}
