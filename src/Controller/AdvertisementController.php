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
    public function show_advertisement(int $id, AdvertisementsRepository $advertisementsRepository): Response
    {
        return $this->render('advertisement/index.html.twig', [
            'advertisement' => $advertisementsRepository->findOneBy(array("id" => $id))
        ]);
    }
    
    #[Route('/advertisement/{id}/adopt', name: 'adopt_dog')]
    public function adopt_dog(int $id, AdvertisementsRepository $advertisementsRepository): Response
    {
        return $this->render('advertisement/adoptForm.html.twig', [
            'advertisement' => $advertisementsRepository->findOneBy(array("id" => $id))
        ]);
    }
}
