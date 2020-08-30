<?php

namespace App\Form;

use App\Entity\EnyPromoOrganisee;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EnyPromoOrganiseeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('datecreate')
            ->add('num_eny_departement')
            ->add('num_faculte')
            ->add('num_eny_annee_acad')
            ->add('salle')
            ->add('deleted')
            ->add('num_eny_etab')
            ->add('num_eny_promotion')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EnyPromoOrganisee::class,
        ]);
    }
}
