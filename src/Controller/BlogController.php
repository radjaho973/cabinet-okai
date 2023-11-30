<?php

namespace App\Controller;

use Error;
use App\Entity\Guide;
use App\Repository\GuideRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

#[Route('/blog')]

class BlogController extends AbstractController
{
    #[Route('/', name: 'app_blog')]
    public function index(GuideRepository $guideRepo): Response
    {
        $this->denyAccessUnlessGranted('ADMIN');
        // sépare les 10 derniers guides en 2 pour faciliter
        // l'affichage coté front
         $guides = array_chunk($guideRepo->get10LastGuides(),5);
         $guidesLeft = $guides[0];
         $guidesRight = $guides[1];

        return $this->render('blog/index.html.twig', [
            'guidesLeft'  => $guidesLeft ,
            'guidesRight' => $guidesRight,
        ]);
    }

    #[Route('/post/{slug}',name: 'app_slug_handler',methods: ['GET'],)]
    public function dispatchLinks(Request $request ,GuideRepository $guideRepo): Response | BadRequestException
    {   
        $this->denyAccessUnlessGranted('ADMIN');
        $requestedSlug = $request->get("slug");
        
        // vérifie si le slug match un ancien slug d'article
        //  et si il est bien publié
        $guide = $guideRepo->matchSlug($requestedSlug);

        if ($guide instanceof Guide ) {
            return $this->render('blog/post.html.twig', [
                'guide' => $guide,
            ]);
        // vérifie si le slug match un slug actif
        }else{
            $actifGuide = $guideRepo->findOneBy(['slug' => $requestedSlug]);
            
            $isGuidePublished = $actifGuide->isPublished();
            
            if ($actifGuide instanceof Guide && $isGuidePublished){
                return $this->render('blog/post.html.twig', [
                    'guide' => $actifGuide,
                ]);

            }else{
                throw new BadRequestException('Aucun article trouvé',404);
            }
        }
    }
    
    // #[Route('/post/{slug}',name: 'app_blog_post',methods: ['GET'],)]
    // public function show(Guide $guide): Response
    // {
                
    //     return $this->render('blog/post.html.twig', [
    //         'guide' => $guide,
    //     ]);
    // }
}
