<?php

namespace App\Form;

use App\Entity\SubPart;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SubPartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('subPartName',options:[
                'label' => 'Titre de sous-partie'
            ])
            ->add('subPartContent',options:[
                'label' => 'Contenu de la sous-partie'
            ])
            // ->add('guide')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SubPart::class,
        ]);
    }
}
