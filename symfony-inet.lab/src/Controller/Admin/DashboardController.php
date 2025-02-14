<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    #[Route(path: '/admin', name: 'admin')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->redirect(url: $this->container
            ->get(AdminUrlGenerator::class)
            ->setController(UserCrudController::class)
            ->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Inet Lab')
            ->setFaviconPath('favicon.ico')
            ->renderContentMaximized();
    }

    public function __construct(){}

    public function configureMenuItems(): iterable
    {
        yield MenuItem::section('Настройки');
            yield MenuItem::linkToCrud('Пользователи', 'fa fa-users', User::class);
            yield MenuItem::linkToUrl('API', 'fa fa-link', '/api')
                ->setLinkTarget('_blank')
                ->setPermission('ROLE_ADMIN');
    }
}