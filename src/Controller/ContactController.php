<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Message\ContactMail;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, MessageBusInterface $bus): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $mailContent = [
                'mail' => $form->get('email')->getData(),
                'name' => $form->get('name')->getData(),
                "lastname" => $form->get("lastname")->getData(),
                "phone" => $form->get('phone')->getData(),
                "message" => $form->get('message')->getData()
            ];
            $bus->dispatch(New ContactMail($mailContent));

            return $this->render('contact/index.html.twig', [
                'form' => $form,
            ]);
        }
        
        return $this->render('contact/index.html.twig', [
            'form' => $form,
        ]);
    }
}
