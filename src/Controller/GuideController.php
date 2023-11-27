<?php

namespace App\Controller;

use App\Entity\Guide;
use DateTimeImmutable;
use App\Form\GuideType;
use App\Entity\ImagesGuide;
use App\Service\ImageSaver;
use App\Repository\GuideRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/guide')]
class GuideController extends AbstractController
{
    #[Route('/', name: 'app_guide_index', methods: ['GET'])]
    public function index(GuideRepository $guideRepository): Response
    {
        $this->denyAccessUnlessGranted('ADMIN');
        return $this->render('guide/index.html.twig', [
            'guides' => $guideRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_guide_new', methods: ['GET', 'POST'])]
    public function new(SluggerInterface $slugger,Request $request,ImageSaver $imageSaver, EntityManagerInterface $entityManager): JsonResponse | Response 
    {
        $this->denyAccessUnlessGranted('ADMIN');
        $guide = new Guide();
        $imagesGuideArray = [];
        // récupère les images envoyées depuis l'éditeur
        if ($request->isXmlHttpRequest()) {
            
            $imagesGuide = new ImagesGuide();
            
            $file = $request->files->get('file');
            $imageSaver->persistImage($file, $imagesGuide);
            $imagesGuideArray[] = $imagesGuide;
            $guide->addImagesGuide($imagesGuide);
            
            //retourne une réponse contenant du Json avec l'emplacement de l'image
            return $this->json(["location" => "/images_guide_uploads/".$imagesGuide->getImageUrl()]);
            
        }
            $form = $this->createForm(GuideType::class, $guide);
            $form->handleRequest($request);
            
            if ($form->isSubmitted() && $form->isValid()) {
                // on enregistre l'image 
                $image = $form->get("image")->getData();
                $imageSaver->persistImage($image,$guide);
                
                //on défini les heures de publication
                date_default_timezone_set("America/Guadeloupe");
                $guide->setPublishAt(new DateTimeImmutable("now"));
                $guide->setModifiedAt(new DateTimeImmutable("now"));
                
                //on défini le slug
                $slug = $slugger->slug($form->get("titre")->getData());
                $guide->setSlug($slug);
                
                $entityManager->persist($guide);
                $entityManager->flush();
                
                return $this->redirectToRoute('app_guide_index', [], Response::HTTP_SEE_OTHER);
            }
        
            return $this->render('guide/new.html.twig', [
                'guide' => $guide,
                'form' => $form,
            ]);
        
    }

    // #[Route('/{id}', name: 'app_guide_show', methods: ['GET'])]
    // public function show(Guide $guide): Response
    // {
    //     return $this->render('guide/show.html.twig', [
    //         'guide' => $guide,
    //     ]);
    // }

    #[Route('/{id}/edit', name: 'app_guide_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ImageSaver $imageSaver, Guide $guide,SluggerInterface $slugger, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ADMIN');
        $form = $this->createForm(GuideType::class, $guide);
        $form->handleRequest($request);
        $oldSlug = $guide->getSlug();

        if ($form->isSubmitted() && $form->isValid()) {
            
            // slugify le nvx titre
            $slug = $slugger->slug($form->get("titre")->getData());
            if ($slug->getSting() !== $oldSlug) {
                $guide->setSlug($slug);  
                $guide->addOldSlugs($oldSlug);
            }
            
            // on enregistre l'image 
            $image = $form->get('image')->getData();
            if ($image) {
                $image = $form->get("image")->getData();
                $imageSaver->persistImage($image,$guide);
            }
            
            $isformPublished =$form->get('ispublished')->getData();
            $guide->setIsPublished($isformPublished);
            
            // on modifie la date de publication
            date_default_timezone_set("America/Guadeloupe");
            $guide->setModifiedAt(new DateTimeImmutable("now"));
            


            $entityManager->flush();

            return $this->redirectToRoute('app_guide_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('guide/edit.html.twig', [
            'guide' => $guide,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_guide_delete', methods: ['POST','GET'])]
    public function delete(Request $request, Guide $guide, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ADMIN');
        if ($this->isCsrfTokenValid('delete'.$guide->getId(), $request->request->get('_token'))) {
            $entityManager->remove($guide);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_guide_index', [], Response::HTTP_SEE_OTHER);
    }
}
