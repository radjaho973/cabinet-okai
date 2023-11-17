<?php

namespace App\Form;

use App\Entity\Guide;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class GuideType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('auteur')
            ->add('description',options:[
                
            ])
            ->add('readingTime',options:[
                'label' => 'Temps de lecture'
                ])
            ->add('ispublished',CheckboxType::class,[
                'mapped' => true,
                'label' => 'Publier',
                'required' => false,
            ])
            ->add('image',FileType::class, [
                'label'=> 'Fichier Image',
                'mapped'=> false,
                'required'=> false,
                'constraints' => [
                    new File([
                        'extensions' => [
                            'jpg',
                            'png',
                            'webp',
                            'jpeg',
                        ],
                        'extensionsMessage' =>
                         'Veuillez téléverser un fichier image valide (jpg/png/webp)'
                    ])
                ],
            ])
            // ->add('publishAt')
            // ->add('modifiedAt')

            ->add('content',TextareaType::class,[
                'label' =>false,
                'attr' => [
                    'data-controller' => 'tinymce'                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Guide::class,
        ]);
    }
}
