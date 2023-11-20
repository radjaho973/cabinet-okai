<?php
namespace App\Service;

use Exception;
use App\Entity\Car;
use App\Entity\Guide;
use App\Entity\Services;
use InvalidArgumentException;
use App\Entity\ImageCollection;
use App\Entity\ImagesGuide;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Cache\Psr6\InvalidArgument;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ImageSaver
{
    private $appServiceParameters;
    private EntityManagerInterface $em;

    public function __construct(ParameterBagInterface $appServiceParameters,EntityManagerInterface $em)
    {
        $this->appServiceParameters = $appServiceParameters;
        $this->em = $em;
    }

    public function persistImage(UploadedFile $uploadedFile, Guide | ImagesGuide $entity )
    {

        //on vérifie que le fichier est bien le type attendu
        if($this->validateUpload($uploadedFile) && $this->validateExtension($uploadedFile));
            
        // crée un nom de fichier utilisable 
        $newFileName = uniqid().'.'.$uploadedFile->guessExtension();
        
        // on déplace le fichier dans le dossier choisi en fonction de l'entité
        if ($entity instanceof Guide) {

            $this->persistGuide($uploadedFile,$entity,$newFileName);

        }elseif($entity instanceof ImagesGuide){

            $this->persistImagesGuide($uploadedFile,$entity,$newFileName);
        }else{
            throw new InvalidArgumentException("Waiting for Instance of Guide or ImagesGuide entity, received : ".$entity);
        }
    
    }
    // /**
    //  *  @deprecated
    //  */
    // public function persistThubmnail(UploadedFile $uploadedFile, Guide $entity)
    // {
    //     //on vérifie que le fichier est bien le type attendu
    //     if($this->validateUpload($uploadedFile) && $this->validateExtension($uploadedFile));
            
    //     // crée un nom de fichier utilisable 
    //     $newFileName = uniqid().'.'.$uploadedFile->guessExtension();
        
    //     // on déplace le fichier dans le dossier choisi
    //     $this->persistGuide($uploadedFile,$entity,$newFileName);

    // }

    private function validateUpload(UploadedFile $uploadedFile)
    {
        if (!$uploadedFile instanceof UploadedFile) {
            throw new InvalidArgumentException("Waiting for Instance of UploadedFile class, received : ".$uploadedFile);
        }else{
            return true;
        }
    }

    private function validateExtension(UploadedFile $uploadedFile)
    {
        //extensions autorisés
        $extensionsArray = ["jpg","png","webp","jpeg","gif"];

        $fileExtension =  $uploadedFile->guessExtension();

        if (!in_array($fileExtension,$extensionsArray)) {
            throw new Exception("File extension not allowed, accepted file extensions are : ".implode(",",$extensionsArray));
        }else{
            return true;
        }
    }


    public function persistGuide(UploadedFile $uploadedFile, Guide $guide, $newFileName)
    {
        try{
            $uploadedFile->move(
                //services.yaml sous parameters
                $this->appServiceParameters->get('image_directory'),
                $newFileName
            );
            $guide->setThumbnail($newFileName);

            $this->em->persist($guide,true);
        
        }catch (FileException $e){
            return new $e(`Une erreur c'est produite durant
            l'envoie de fichier, cette méthode ne doit pas être utilisé sans avoir vérifier
             le fichier préalablement`,400 );
        }
    }


    public function persistImagesGuide(UploadedFile $uploadedFile, ImagesGuide $imagesGuide, $newFileName)
    {
        try{
            $uploadedFile->move(
                //services.yaml sous parameters
                $this->appServiceParameters->get('guide_images_directory'),
                $newFileName
            );
            $imagesGuide->setImageUrl($newFileName);

            $this->em->persist($imagesGuide,true);
        
        }catch (FileException $e){
            return new $e(`Une erreur c'est produite durant
            l'envoie de fichier, cette méthode ne doit pas être utilisé sans avoir vérifier
             le fichier préalablement`,400 );
        }
    }
}