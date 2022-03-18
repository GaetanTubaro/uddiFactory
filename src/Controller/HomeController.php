<?php

namespace App\Controller;

use App\Entity\Advertisements;
use App\Repository\AdvertisementsRepository;
use App\Repository\AssociationsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    protected $news;
    protected $assos;

    public function __construct(AdvertisementsRepository $advertisements, AssociationsRepository $associations)
    {
        $this->news = $advertisements->findNews();
        $this->assos = $associations->findListHome();
    }

    #[Route(['/home', '/'], name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'tabNews' => $this->news,
            'associations' => $this->assos,
        ]);
    }
}
