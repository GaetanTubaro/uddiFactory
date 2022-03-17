<?php

namespace App\Controller;

use App\Entity\Advertisements;
use App\Repository\AdvertisementsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    protected $news;

    public function __construct(AdvertisementsRepository $advertisements)
    {
        $this->news = $advertisements->findNews();
    }

    #[Route(['/home', '/'], name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'tabNews' => $this->news,
        ]);
    }
}
