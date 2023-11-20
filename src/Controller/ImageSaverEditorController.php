<?php

namespace App\Controller;

use App\Entity\Guide;
use App\Entity\ImagesGuide;
use App\Service\ImageSaver;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ImageSaverEditorController extends AbstractController
{
    #[Route('/save-image-editor/{id}', name: 'app_image_saver_editor',methods:"POST")]
    public function ajax(Request $request, ImageSaver $imageSaver, Guide $guide, EntityManagerInterface $em): JsonResponse | BadRequestException
    {
        //! les images venant d'un nouvel article sont envoyé dans guide/new
        
        if (!$request->isXmlHttpRequest()) {
            
            return new BadRequestException();
        }else{
            
            $file = $request->files->get('file');
            
            $imagesGuide = new ImagesGuide();
            $imageSaver->persistImage($file, $imagesGuide);
            
            $guide->addImagesGuide($imagesGuide);
            $em->flush();

            //retourne une réponse contenant du Json
            return $this->json(["location" => "/images_guide_uploads/".$imagesGuide->getImageUrl()]);
            
        }
    }
}
