<?php

namespace App\UI\Http\Admin;

use App\Core\Quiz\Model\Quiz;
use App\Core\Quiz\Model\QuizQuestion;
use App\Core\QuizSession\Model\QuizSession;
use App\Core\User\Model\User;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    #[Route('/', name: 'admin')]
    public function index(): Response
    {
        return $this->render('@EasyAdmin/layout.html.twig', [
            'dashboard_controller_filepath' => (new \ReflectionClass(static::class))->getFileName(),
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Quick learn administrace');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Uživatelé', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Kvízy', 'fa-solid fa-list-ol', Quiz::class);
        yield MenuItem::linkToCrud('Otázky', 'fa-solid fa-question', QuizQuestion::class);
        yield MenuItem::linkToCrud('Rozehrané kvízy', 'fa-solid fa-puzzle-piece', QuizSession::class);

    }
}
