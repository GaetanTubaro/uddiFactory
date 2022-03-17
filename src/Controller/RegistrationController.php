<?php

namespace App\Controller;

use App\Entity\Adopters;
use App\Form\RegistrationType;
use App\Repository\AdoptersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('/registration', name: 'registration_new')]
    public function new(Request $request, AdoptersRepository $adoptersRepository): Response
    {
        $adopter = new Adopters;
        $form = $this->createForm(RegistrationType::class, $adopter);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $adoptersRepository->add($adopter);
            return $this->redirectToRoute('security_login');
        }
        return $this->render('registration/index.html.twig', [
            'controller_name' => 'RegistrationController',
        ]);
    }
}
