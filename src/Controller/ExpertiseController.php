<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ExpertiseController extends AbstractController
{
    #[Route('/expertise', name: 'app_expertise')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        
            return $this->render('expertise/index.html.twig', [
                'form' => $form,
            ]);
        }
        
        return $this->render('expertise/index.html.twig', [
            'form' => $form,
        ]);
    }
}
