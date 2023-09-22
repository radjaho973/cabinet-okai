<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class UrbanismeController extends AbstractController
{
    #[Route('/urbanisme', name: 'app_urbanisme')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        
            return $this->render('urbanisme/index.html.twig', [
                'form' => $form,
            ]);
        }
        
        return $this->render('urbanisme/index.html.twig', [
            'form' => $form,
        ]);
    }
}
