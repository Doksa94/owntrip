<?php

namespace App\Form;

use App\Entity\City;
use App\Entity\Country;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required'=>false,
                'label'=>'Nom de la ville',
                'attr'=>[
                    'placeholder'=>'Saisissez le nom de la ville'
                ]

            ])
            ->add('country', EntityType::class,[
                "class"=>Country::class,
                "choice_label"=>"name",
                'label'=>'Quel pays ?',
                'attr'=>[
                    'data-placeholder'=>"Sélectionnez le pays correspondant"
                ]

            ])
            ->add('Valider', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => City::class,
        ]);
    }
}
