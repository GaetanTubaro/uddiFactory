<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function index(Request $request, ContactRepository $contactRepository): Response
    {
        $contact = new Contact();
        $contact->setCreationDate(new DateTime());
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $contactRepository->add($contact);
            $this->addFlash('success', 'Message envoyé');
            return $this->redirectToRoute('contact');
        }

        return $this->render('contact/index.html.twig', [
            'formContact' => $form->createView(),
        ]);
    }
}
