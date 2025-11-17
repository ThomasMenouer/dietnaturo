<?php

namespace App\Presentation\Web\Controller\Pages;

use App\Presentation\Web\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Infrastructure\Mailer\EmailSendService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{

    public function __construct(private EmailSendService $emailSendService){

        $this->emailSendService = $emailSendService;
    }

    #[Route('/contact', name: 'contact')]
    public function index(Request $request): Response
    {

        // $contacts = $getAllContactUseCase->execute();

        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $this->emailSendService->sendEmailContact($data);

            $this->addFlash('success', 'Votre message a bien été envoyé !'); 
            
            return $this->redirectToRoute('contact');
        }

        return $this->render('pages/contact.html.twig', [
            'controller_name' => 'Contact',
            // 'contacts' => $contacts,
            'form' => $form
        ]);
    }
}
