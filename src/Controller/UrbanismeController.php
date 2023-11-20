<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Repository\GuideRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class UrbanismeController extends AbstractController
{
    #[Route('/urbanisme', name: 'app_urbanisme')]
    public function index(Request $request ,GuideRepository $guideRepo): Response
    {
        $guides = $guideRepo->get10LastGuides();

        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        
            return $this->render('urbanisme/index.html.twig', [
                'form' => $form,
                'guides' => $guides,
            ]);
        }
        
        return $this->render('urbanisme/index.html.twig', [
            'form' => $form,
            'guides' => $guides,
        ]);
    }
}
