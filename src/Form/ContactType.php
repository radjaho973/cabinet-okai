<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\SubmitButton;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add("lastname",TextType::class,[
                'label' => "Nom"
            ])
            ->add("name",TextType::class,[
                'label' => "Prénom"
            ])
            ->add("email",EmailType::class,[])
            ->add("phone",TelType::class,[
                "label" => "Téléphone"
            ])
            ->add("agreeTerm",CheckboxType::class,[
                "label" => "En cochant cette case, vous acceptez de recevoir nos offres promotionnelles. Consultez notre politique de confidentialité",
            ])
            ->add("submit",SubmitType::class)
        ;
    }
}