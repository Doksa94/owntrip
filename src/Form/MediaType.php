<?php

namespace App\Form;

use App\Entity\Media;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MediaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if ($options['lien']==true){


            $builder
                ->add('name', TextType::class, [
                    'required'=>false,
                    'label'=>'Liens de la vidéo youTube',
                    'attr'=>[

                        'placeholder'=>'Collez lez liens de la vidéo YouTube souhaitée'
                    ]

                ])
                ->add('Valider', SubmitType::class)

            ;


        }else{

            $builder
                ->add('name', FileType::class, [
                    'required'=>false,
                    'label'=>'Fichier Photo/Vidéo à uploader',
                    'attr'=>[
                        'onChange'=>'loadFile(event)'
                    ]


                ])
                ->add('Valider', SubmitType::class)

            ;




        }


    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Media::class,
            'lien'=>false,
            'fichier'=>false
        ]);
    }
}
