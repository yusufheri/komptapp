<?php

namespace App\Form;

use App\Entity\DetailRubrique;
use App\Entity\Devise;
use App\Entity\Rubrique;
use App\Repository\DeviseRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RubriqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('code', TextType::class, [
                    'label' => 'Code',
                    'attr' => [
                        'placeholder' => 'Attribuer un code'
                    ]
                ])
                ->add('name', TextType::class, [
                    'label' => 'Intitulé de la rubrique',
                    'attr' => [
                        'placeholder' => "Saisir l'intitulé de la rubrique"
                    ]
                ])
                ->add('content', TextareaType::class,[
                    'label' => 'Commentaire',
                    'attr' => [
                        'class' => 'tinymce',
                        'placeholder' => 'Faites un commentaire si possible',
                        'rows' => 10
                    ],
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Rubrique::class,
        ]);
    }
}
