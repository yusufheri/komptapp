<?php

namespace App\Form;

use App\Entity\EnyBank;
use App\Entity\EnyBankingInfo;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EnyBankingInfoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('account_name')
            ->add('account_number')
            ->add('content')
            ->add('bank', EntityType::class, [
                'class' => EnyBank::class,
                'choice_label' => 'name'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EnyBankingInfo::class,
        ]);
    }
}
