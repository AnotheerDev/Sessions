<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Module;
use App\Entity\Session;
use App\Entity\Category;
use App\Entity\UserSecu;
use App\Entity\Formateur;
use App\Entity\Formation;
use App\Entity\Programme;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\Admin\FormateurCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(FormateurCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Sessions');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud('Formateur', 'fas fa-list', Formateur::class);
        yield MenuItem::linkToCrud('Formation', 'fas fa-list', Formation::class);
        yield MenuItem::linkToCrud('Module', 'fas fa-list', Module::class);
        yield MenuItem::linkToCrud('Programme', 'fas fa-list', Programme::class);
        yield MenuItem::linkToCrud('Session', 'fas fa-list', Session::class);
        yield MenuItem::linkToCrud('User', 'fas fa-list', User::class);
        yield MenuItem::linkToCrud('UserSecu', 'fas fa-list', UserSecu::class);
        yield MenuItem::linkToCrud('Category', 'fas fa-list', Category::class);
    }
}
