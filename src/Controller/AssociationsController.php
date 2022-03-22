<?php

namespace App\Controller;

use App\Entity\Associations;
use App\Form\AssociationsType;
use App\Repository\AssociationsRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_ASSO')]
class AssociationsController extends AbstractController
{
    #[Route('/asso/informations', name: 'associations_infos')]
    public function infos(Request $request, AssociationsRepository $associationsRepository): Response
    {
        /** @var Associations $asso */
        $asso = $this->getUser();
        $form = $this->createForm(AssociationsType::class, $asso);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $associationsRepository->add($asso);

            $this->addFlash('success', 'Informations modifiées');

            return $this->redirectToRoute('associations_infos');
        }

        return $this->render('associations/infos.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
