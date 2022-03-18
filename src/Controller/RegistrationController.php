<?php

namespace App\Controller;

use App\Entity\Adopters;
use App\Form\RegistrationType;
use App\Repository\AdoptersRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationController extends AbstractController
{   
    protected UserPasswordHasherInterface $hasher;

    #[Route('/registration', name: 'registration_new')]
    public function new(Request $request, AdoptersRepository $adoptersRepository, UserPasswordHasherInterface $hasher): Response
    {
        $this->hasher = $hasher;
        $adopter = new Adopters;
        $adopter->setCreationDate(new DateTime());
        $adopter->setIsAdmin(false);
        $form = $this->createForm(RegistrationType::class, $adopter);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $adopter->setPassword(
                $hasher->hashPassword(
                    $adopter, 
                    $adopter->getPassword()
                )
            );
            $adoptersRepository->add($adopter);
            return $this->redirectToRoute('app_home');
        }
        return $this->render('registration/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
