<?php

namespace App\Controller\Pages;

use App\Form\ContactType;
use App\Service\MailerService\EmailSendService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            
            $this->emailSendService->sendEmailContact($data);

            $this->addFlash('success', 'Votre message a bien été envoyé !'); 
            
            return $this->redirectToRoute('contact');
        }

        return $this->render('pages/contact.html.twig', [

            'form' => $form->createView()
        ]);
    }
}
