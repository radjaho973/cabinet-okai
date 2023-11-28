<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Message\ContactMail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request,MessageBusInterface $bus): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        $mailSent = false;

        if ($form->isSubmitted() && $form->isValid()) {
            
            $mailContent = [
                'mail' => $form->get('email')->getData(),
                'name' => $form->get('name')->getData(),
                "lastname" => $form->get("lastname")->getData(),
                "phone" => $form->get('phone')->getData(),
                "message" => $form->get('message')->getData()
            ];
            $bus->dispatch(New ContactMail($mailContent));
            
            $mailSent = true;
            return $this->render('home/index.html.twig', [
                'form' => $form,
                'mailSent' => $mailSent,
            ]);
        }

        return $this->render('home/index.html.twig', [
            'form' => $form,
            'mailSent' => $mailSent,
        ]);
        
    }
}
