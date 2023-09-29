<?php

namespace App\Form;

use App\Entity\Activity;
use App\Entity\ActivityCategory;
use App\Entity\City;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActivityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,[
                'required'=>false,
                'label'=>'Nom de l\'activité',
                'attr'=>[
                    'placeholder'=>'Saisissez le nom de l\'activité'
                ]
            ])
            ->add('first_price', NumberType::class,[
                'required'=>false,
                'label'=>'Prix Minimum',
                'attr'=>[
                    'placeholder'=>'Saisissez le prix minimum de l\'activité'
                ]
            ])
            ->add('max_price', NumberType::class,[
                'required'=>false,
                'label'=>'Prix Maximum',
                'attr'=>[
                    'placeholder'=>'Saisissez le prix maximum de l\'activité'
                ]
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
            ->add('duration', NumberType::class,[
                'required'=>false,
                'label'=>'Durée de l\'activité (en heure)',
                'attr'=>[
                    'placeholder'=>'Saisissez une estimation de la durée de l\'activité'
                ]
            ])
            ->add('category', EntityType::class, [
                'class'=>ActivityCategory::class,
                'label'=>'Catégorie',
                'choice_label'=>'name',
                'multiple'=>true,
                'placeholder'=>'Saisissez les catégories en liens avec l\'activité',
                'attr'=>[
                    'class'=>'select2'
                ]

            ])
            ->add('type', EntityType::class, [
                'class'=>\App\Entity\ActivityType::class,
                'choice_label'=>'name',
                'label'=>'Type d\'activité',
                'placeholder'=>'Saisissez le type d\'activité'

            ])
            ->add('city', EntityType::class, [
                'class'=>City::class,
                'choice_label'=>'name',
                'label'=>'Ville',
                 'placeholder'=>'Saisissez la ville de l\'activité',

            ])
            ->add('Valider', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Activity::class,
        ]);
    }
}
