<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Slider;
use App\Entity\Chambre;
use App\Entity\Commande;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin_backoffice', name: 'admin')]
    public function index(): Response
    {
        // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        return $this->render('admin/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('BACK OFFICE');
    }

    public function configureMenuItems(): iterable
    {
        // yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);

        return [
            // RAjouter l'icone
          MenuItem::linkToDashboard('Accueil', 'fa-solid fa-house'),
          // Rajouter une section 
          MenuItem::section('Membre'), 
        //   Importer la classe ( )
          MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', User::class),
        //   Faire des Sous menu
          MenuItem::subMenu('Gestion', 'fa fa-newspaper')->setSubItems([
            // Faire une entité/classe Article/Comment/Category
            MenuItem::linkToCrud('Chambre', 'fa fa-book', Chambre::class),
            MenuItem::linkToCrud('Commande', 'fa fa-comment', Commande::class),
            MenuItem::linkToCrud('Slider', 'fa fa-layer-group', Slider::class),
          ]),
            // MenuItem::subMenu('Chambres', 'fa fa-newspaper')->setSubItems([
              // Faire une entité/classe Article/Comment/Category
          //     MenuItem::linkToCrud('Chambre classique', 'fa fa-book', Chambre::class),
          //     MenuItem::linkToCrud('Chambre confort', 'fa fa-book', Chambre::class),
          //     MenuItem::linkToCrud('Chambre suite', 'fa fa-book', Chambre::class),
          // ]),

          MenuItem::section('retour au site'),
          MenuItem::linkToRoute('Accueil du site', 'fa fa-igloo', 'home')
        ];
    }
}
