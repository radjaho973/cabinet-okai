<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $email = (new TemplatedEmail())
            ->from('adresse@cabinet-okai.com')
            ->to('hello@studio-okai.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Nouvelle demande de contact')
            // ->text('Sending emails is fun again!')
            ->htmlTemplate('mail/contact_mail.html.twig')
            ->context([
                'mail' => $form->get('email')->getData(),
                'name' => $form->get('name')->getData(),
                "lastname" => $form->get("lastname")->getData(),
                "phone" => $form->get('phone')->getData(),
                "message" => $form->get('message')->getData()
            ]);

        $mailer->send($email);

            return $this->render('contact/index.html.twig', [
                'form' => $form,
            ]);
        }
        
        return $this->render('contact/index.html.twig', [
            'form' => $form,
        ]);
    }
}
