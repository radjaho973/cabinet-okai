<?php

namespace App\Form;

use App\Entity\Guide;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class GuideType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('auteur')
            ->add('description')
            ->add('readingTime')
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
            ->add("subPart",CollectionType::class,[
                'mapped' => false,
                'entry_type' => SubPartType::class,
                'by_reference'=> false,
                'allow_add'=> true,
                'allow_delete'=> true,
                'prototype'=> true,
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
