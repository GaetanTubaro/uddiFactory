<?php

namespace App\Controller;

use App\Entity\Messages;
use App\Form\MessageType;
use App\Repository\AdvertisementsRepository;
use App\Repository\MessagesRepository;
use App\Repository\RequestsRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MyAccountController extends AbstractController
{
    #[Route('/my-account', name: 'user_account')]
    #[Security("is_granted('ROLE_ADOPTERS') or is_granted('ROLE_ASSO')")]
    public function index(RequestsRepository $requestsRepository, AdvertisementsRepository $advertisementsRepository): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        if (in_array('ROLE_ADOPTERS', $user->getRoles())) {
            return $this->render('my_account/user_account.html.twig', [
            'requests' => $requestsRepository->findBy(['adopter' => $user]),
            'user' => $user,
        ]);
        } elseif (in_array('ROLE_ASSO', $user->getRoles())) {
            return $this->render('my_account/asso_account.html.twig', [
                'advertisements' => $advertisementsRepository->findBy(['association' => $user]),
                'requests' => $requestsRepository->findByAssociation($user->getId()),
                'user' => $user,
        ]);
        }
    }

    #[Route('/my-account/request/{id}', name: 'request_detail')]
    #[Security("is_granted('ROLE_ADOPTERS') or is_granted('ROLE_ASSO')")]
    // L'utilisation du ParamConverter ici fait buguer la session utilisateur.
    public function requestDetails(RequestsRepository $requestsRepository, $id, Request $req, MessagesRepository $messagesRepository): Response
    {
        $request = $requestsRepository->find($id);
        $user = $this->getUser();

        $message = new Messages();
        $message->setRequest($request)
                ->setWriter($user);
        $form = $this->createForm(MessageType::class, $message, [
        ]);

        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) {
            $messagesRepository->add($message);

            return $this->redirectToRoute('request_detail', ['id' => $id]);
        }

        foreach ($request->getMessage() as $reqMess) {
            if ($reqMess->getWriter() != $user) {
                $reqMess->setIsRead(true);
                $messagesRepository->add($reqMess);
            }
        }

        return $this->render('my_account/request_detail.html.twig', [
            'request' => $request,
            'user' => $user,
            'messageForm' => $form->createView(),
            ]);
    }
}
