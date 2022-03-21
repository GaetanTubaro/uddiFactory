<?php

namespace App\Controller;

use App\Repository\AdvertisementsRepository;
use App\Repository\RequestsRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MyAccountController extends AbstractController
{
    #[Route('/my-account', name: 'user_account')]
    #[Security("is_granted('ROLE_ADOPTERS') or is_granted('ROLE_ASSO')")]
    public function index(RequestsRepository $requestsRepository, AdvertisementsRepository $advertisementsRepository): Response
    {
        $user = $this->getUser();
        if (in_array('ROLE_ADOPTERS', $user->getRoles())) {
            return $this->render('my_account/user_account.html.twig', [
            'requests' => $requestsRepository->findBy(['adopter' => $user]),
        ]);
        } elseif (in_array('ROLE_ASSO', $user->getRoles())) {
            return $this->render('my_account/asso_account.html.twig', [
                'advertisements' => $advertisementsRepository->findBy(['association' => $user])
        ]);
        }
    }
}
