<?php

namespace App\Form;

use App\Entity\Activity;
use App\Entity\Package;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PackageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if ($options['search']!=null)
        {
            $builder
                ->add('activity_count', NumberType::class,[
                        'required'=>false,
                        'label'=>'Nombre d\'activités'

                    ]
                )
                ->add('activities', EntityType::class, [
                    'class'=>Activity::class,
                    'label'=>'Activités',
                    'choice_label'=>'name',
                    'multiple'=>true,
                    'placeholder'=>'Saisissez les activités du circuit',
                    'query_builder' => function (EntityRepository $er) use ( $options): QueryBuilder {
                        return $er->createQueryBuilder('a')
                            ->join('a.city', 'c')
                            ->andWhere('c.name LIKE :city')
                            ->setParameter('city', "%{$options['search']}%");

                    },
                    'attr'=>[
                        'class'=>'select2'
                    ]

                ])
                ->add('valider', SubmitType::class)
            ;


        }else{

            $builder
                ->add('activity_count', NumberType::class,[
                        'required'=>false,
                        'label'=>'Nombre d\'activités'

                    ]
                )
                ->add('activities', EntityType::class, [
                    'class'=>Activity::class,
                    'label'=>'Activités',
                    'choice_label'=>'name',
                    'multiple'=>true,
                    'placeholder'=>'Saisissez les activités du circuit',
                    'attr'=>[
                        'class'=>'select2'
                    ]

                ])
                ->add('valider', SubmitType::class)
            ;

        }



    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Package::class,
            'search'=>null
        ]);
    }
}
