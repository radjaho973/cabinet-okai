<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Message\ContactMail;
use App\Repository\GuideRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Messenger\MessageBusInterface;

class ExpertiseController extends AbstractController
{
    #[Route('/expertise', name: 'app_expertise')]
    public function index(Request $request,MessageBusInterface $bus,GuideRepository $guideRepo): Response
    {
        $guides = $guideRepo->get10LastGuides();
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

            return $this->render('expertise/index.html.twig', [
                'form' => $form,
                'guides' => $guides,
                'mailSent' => $mailSent,

            ]);
        }
        
        return $this->render('expertise/index.html.twig', [
            'form' => $form,
            'guides' => $guides,
            'mailSent' => $mailSent,

        ]);
    }
}
