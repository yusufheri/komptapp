<?php

namespace App\Form;

use App\Entity\EnyAnneeAcad;
use App\Entity\EnyCommune;
use App\Entity\EnyEtudiant;
use App\Entity\EnyPays;
use App\Entity\EnyProvince;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EnyEtudiantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('anneeAcad', EntityType::class, [
                'class' => EnyAnneeAcad::class,
                'label' => 'Année académique',
                'choice_label' => "lib",
                "placeholder" => "Selectionnez votre année académique",
                'attr' => [
                    "placeholder" => "Selectionnez votre année académique"
                ]
            ])
            ->add('matricule')
            ->add('nom')
            ->add('postnom')
            ->add('prenom')
            ->add('sexe')
            ->add('lieuNais')
            ->add('dateNais')
            ->add('nomPere')
            ->add('nomMere')
            ->add('adresse')
            ->add('tel')            
            ->add('province', EntityType::class, [
                'class' => EnyProvince::class,
                'label' => "Province d'origine",
                'choice_label' => "lib",
                "required" => false,
                "placeholder" => "Selectionnez votre province d'origine",
                'attr' => [
                    "placeholder" => "Selectionnez votre province d'origine"
                ]
            ])
            ->add('commune', EntityType::class, [
                'class' => EnyCommune::class,
                'label' => "Commune",
                "required" => false,
                'choice_label' => "lib",
                "placeholder" => "Selectionnez votre commune",
                'attr' => [
                    "placeholder" => "Selectionnez votre commune"
                ]
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EnyEtudiant::class,
        ]);
    }
}
