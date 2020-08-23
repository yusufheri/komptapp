<?php

namespace App\Form;

use App\Entity\Devise;
use App\Entity\DetailRubrique;
use App\Repository\DeviseRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

class DetailRubriqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('rubrique', RubriqueType::class, [
                    'label' => false
                ])
                ->add('amount', MoneyType::class, [
                    'currency' => 'CDF',
                    'label' => 'Montant',
                    'attr' => [
                        'placeholder' => 'Saisir le montant pour cette rubrique'
                    ]
                ])
                ->add('devise', EntityType::class, [
                    'label' => 'Devise',
                    'class' => Devise::class,
                    'query_builder' => function (DeviseRepository $deviseRepository) {
                        return $deviseRepository->createQueryBuilder('d')
                                ->orderBy('d.name', 'ASC');
                    },
                    'choice_label' => 'name',
                    'placeholder' => 'Sélectionnez la devise',                    
                ])
            
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DetailRubrique::class,
        ]);
    }
}
