<?php

namespace App\Form;

use App\Entity\EnyBank;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EnyBankType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('content')
            ->add('tel')
            ->add('email')
            ->add('website')
            ->add('address')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EnyBank::class,
        ]);
    }
}
