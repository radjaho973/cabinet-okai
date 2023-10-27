<?php

namespace App\Controller;

use App\Entity\Guide;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/blog')]

class BlogController extends AbstractController
{
    #[Route('/', name: 'app_blog')]
    public function index(): Response
    {
        
        return $this->render('display_guide/index.html.twig', [
            'controller_name' => 'DisplayGuideController',
        ]);
    }
    #[Route('/post/{slug}', name: 'app_blog',methods: ['GET'])]
    public function show(Guide $guide): Response
    {

        return $this->render('blog/post.html.twig', [
            'guide' => $guide,
        ]);
    }
}
