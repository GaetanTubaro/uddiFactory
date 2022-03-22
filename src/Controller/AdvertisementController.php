<?php

namespace App\Controller;

use App\Entity\Advertisements;
use App\Entity\Messages;
use App\Entity\Requests;
use App\Form\AdoptionType;
use App\Form\FiltersType;
use App\Form\Model\AdvertisementFilter;
use App\Repository\AdvertisementsRepository;
use App\Repository\RequestsRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdvertisementController extends AbstractController
{


    #[Route('/advertisement/{id}', name: 'show_advertisement')]
    public function show_advertisement(Advertisements $advertisement): Response
    {
        return $this->render('advertisement/index.html.twig', [
            'advertisement' => $advertisement,
        ]);
    }
    
    #[Route('/advertisement/{id}/adopt', name: 'adopt_dog')]
    #[IsGranted('ROLE_ADOPTERS')]
    public function adopt_dog(Advertisements $advertisement, RequestsRepository $requestsRepository, Request $request): Response
    {
        $adoptionRequest = new Requests();
        $message = new Messages();
        $message->setWriter($this->getUser());
        $adoptionRequest->addMessage($message);
        $adoptionRequest->setAdopter($this->getUser());
        $form = $this->createForm(AdoptionType::class, $adoptionRequest, [
            'ad_id' => $advertisement->getId(),
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $requestsRepository->add($adoptionRequest);
            $this->addFlash('success', 'Demande effectuée');
            
            return $this->redirectToRoute('show_advertisement', ['id' => $advertisement->getId()]);
        }
        
        return $this->render('advertisement/adoptForm.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
    #[Route('/advertisements', name: 'advertisements_list')]
    public function advertisements_list(AdvertisementsRepository $advertisementsRepository, Request $request): Response
    {
        $filterAd = new AdvertisementFilter();
        $filterForm = $this->createForm(FiltersType::class, $filterAd);
        $filterForm->handleRequest($request);

        $ads = $advertisementsRepository->findByFilter($filterAd);
        return $this->render('advertisement/advertisements.html.twig', [
            'filterForm' => $filterForm->createView(),
            'ads' => $ads,
        ]);
    }
}
