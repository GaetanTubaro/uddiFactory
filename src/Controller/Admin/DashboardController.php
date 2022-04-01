<?php

namespace App\Controller\Admin;

use App\Entity\Adopters;
use App\Entity\Associations;
use App\Entity\Species;
use App\Entity\User;
use App\Repository\ContactRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    protected $tenMessages;

    public function __construct(ContactRepository $contact)
    {
        $this->tenMessages = $contact->lastTenMessages();
    }

    #[Route('/admin', name: 'admin_dashboard')]

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
        return $this->render('admin/dashboard.html.twig', [
            'tenMessages'=>$this->tenMessages
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('UddiFactory');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Administrateurs', 'fas fa-list', User::class);
        yield MenuItem::linkToCrud('Adoptants', 'fas fa-list', Adopters::class);
        yield MenuItem::linkToCrud('associations', 'fas fa-list', Associations::class);
        yield MenuItem::linkToCrud('Espèces ', 'fas fa-list', Species::class);
    }
}
