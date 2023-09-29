<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('last_name', TextType::class,[
                'required'=>false,
                'label'=>'Nom',
                'attr'=>[
                    'placeholder'=>'Saisissez Votre nom'
                ]

            ])
            ->add('first_name', TextType::class,[
                'required'=>false,
                'label'=>'Prénom',
                'attr'=>[
                    'placeholder'=>'Saisissez votre prénom'
                ]

            ])
            ->add('email', EmailType::class,[
                'required'=>false,
                'label'=>'Email',
                'attr'=>[
                    'placeholder'=>'Saisissez votre email'
                ]
            ])
            ->add('password', PasswordType::class,[
                'required'=>false,
                'label'=>'Mot de passe',
                'attr'=>[
                    'placeholder'=>'Saisissez un mot de passe'
                ]

            ])
            ->add('birthdate', BirthdayType::class,[
                'required'=>false,
                'widget'=>'single_text'

            ])
            ->add('tel', TextType::class,[
                'required'=>false,
                'label'=>'Téléphone',
                'attr'=>[
                    'placeholder'=>'Saisissez un numéro de téléphone'
                ]

            ])
            ->add('street_number', NumberType::class,[
                'required'=>false,
                'label'=>'Numéro de voie',
                'attr'=>[
                    'placeholder'=>'Saisissez le numéro de voie'
                ]
            ])
            ->add('street_name', TextType::class,[
                'required'=>false,
                'label'=>'Libéllé de voie',
                'attr'=>[
                    'placeholder'=>'Saisissez le libéllé de voie'
                ]

            ])
            ->add('zip_code', NumberType::class,[
                'required'=>false,
                'label'=>'Code postal',
                'attr'=>[
                    'placeholder'=>'Saisissez le code postal'
                ]
            ])
            ->add('city', TextType::class,[
                'required'=>false,
                'label'=>'Ville',
                'attr'=>[
                    'placeholder'=>'Saisissez la ville'
                ]

            ])
            ->add('valider', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
