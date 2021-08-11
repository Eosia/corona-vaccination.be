<?php

namespace App\Controller\Admin;

use App\Entity\Centre;
use App\Entity\Province;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        // redirect to some CRUD controller
        $routeBuilder = $this->get(AdminUrlGenerator::class);

        return $this->redirect($routeBuilder->setController(CentreCrudController::class)->generateUrl());

    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Corona Vaccination');
    }

    public function configureMenuItems(): iterable
    {

        yield MenuItem::section('Raccourcis');
        yield MenuItem::linkToUrl('Retour au site', 'fa fa-globe', '/');
        yield MenuItem::linkToUrl('Déconnexion', 'fas fa-sign-out-alt', '/admin/logout');

        yield MenuItem::section('Liste des Centres');
        yield MenuItem::linkToCrud('Centres', 'fas fa-syringe', Centre::class);

        yield MenuItem::section('Liste des Provinces');
        yield MenuItem::linkToCrud('Provinces', 'fas fa-map-marked-alt', Province::class);


        yield MenuItem::section('Admin');
        yield MenuItem::linkToCrud('Utilisateurs', 'fa fa-user-circle', User::class);



    }
}
