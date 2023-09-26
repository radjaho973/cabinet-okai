<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


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
            ->add("message",TextareaType::class,[
                "label" => false,
                "attr" => ["rows" => 3, "cols" => 60,"placeholder" => "Détailler votre demande"]
                ])
                ->add("agreeTerm",CheckboxType::class,[
                    "label" => "En cochant cette case, vous acceptez de recevoir
                    nos offres promotionnelles.
                    <a href=\"#\" >Consultez notre politique de confidentialité</a>",
                    "label_html" => true,
                    ])
                    ->add("submit",SubmitType::class,[
                        'label' => 'Envoyer',
                        "attr" => ["class" => "btn-contact"]
                
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver) :void
    {
        $resolver->setDefaults([
            'sanitize_html' => true,
            // use the "sanitizer" option to use a custom sanitizer (see below)
            //'sanitizer' => 'app.post_sanitizer',
        ]);
    }
}