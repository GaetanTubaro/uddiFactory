<?php

namespace App\Controller;

use App\Entity\Advertisements;
use App\Entity\Dogs;
use App\Form\DogType;
use App\Repository\AdvertisementsRepository;
use App\Repository\DogsRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DogController extends AbstractController
{
    #[Route('/dog/advertisement/{id}/create_dog', name: 'create_dog')]
    #[IsGranted('ROLE_ASSO')]
    public function create_dog(Request $request, int $id, DogsRepository $dogsRepository, AdvertisementsRepository $advertisementsRepository): Response
    {
        $advertisement = $advertisementsRepository->find($id);
        $newDog = new Dogs();
        $newDog->setAdvertisement($advertisement);
        $dogForm = $this->createForm(DogType::class, $newDog, [
            'submit' => true,
        ]);
        $dogForm->handleRequest($request);
        if ($dogForm->isSubmitted() && $dogForm->isValid())
        {
            $dogsRepository->add($newDog);
        };
        return $this->render('dog/dogForm.html.twig', [
            'dogForm' => $dogForm->createView(),
        ]);
    }
}
