<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\Regles;
use App\Controller\Admin\CandidatCrudController;
use App\Controller\Admin\AdminCrudController;
use App\Controller\Admin\RecruteurCrudController;



class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Administrateur FindJob')
            // ->setTitle('<img src="..."> ACME <span class="text-small">Corp.</span>')
            ->setTranslationDomain('findJob.com')
            ->disableUrlSignatures()
            ;
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Administrateurs', 'fas fa-user-cog', User::class)->setController(AdminCrudController::class);
        yield MenuItem::linkToCrud('Recruteurs', 'fas fa-building', User::class)->setController(RecruteurCrudController::class);
        yield MenuItem::linkToCrud('Candidats', 'fas fa-users', User::class)->setController(CandidatCrudController::class);
        yield MenuItem::linkToCrud('Règles', 'fas fa-ruler-vertical', Regles::class);
    }
}
