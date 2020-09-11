<?php

namespace App\Form;

use App\Entity\EnyTranche;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EnyTrancheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code', TextType::class, [
                'label' => 'Code associé',
                'attr' => [
                    'placeholder' => "Votre code ici"
                ]
            ])
            ->add('name', TextType::class, [
                'label' => 'Libellé',
                'attr' => [
                    'placeholder' => "Le libellé ici"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EnyTranche::class,
        ]);
    }
}
