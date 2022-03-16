<?php

namespace App\Controller;

use App\Repository\AdvertisementsRepository;
use App\Repository\DogsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdvertisementController extends AbstractController
{
    #[Route('/advertisement/{id}', name: 'show_advertisement')]
    public function index(int $id, AdvertisementsRepository $advertisementsRepository): Response
    {
        return $this->render('advertisement/index.html.twig', [
            'advertisement' => $advertisementsRepository->findOneBy(array("id" => $id))
        ]);
    }
}
