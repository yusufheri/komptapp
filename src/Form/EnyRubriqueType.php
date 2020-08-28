<?php

namespace App\Form;

use App\Entity\Devise;
use App\Entity\EnyMotif;
use App\Entity\EnyRubrique;
use App\Entity\EnySousRubrique;
use App\Entity\SousRubrique;
use App\Repository\DeviseRepository;
use App\Repository\EnyMotifRepository;
use App\Repository\EnySousRubriqueRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EnyRubriqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code', TextType::class, [
                "required" => false,
                "label" => "Code",
                "attr" => [
                    "placelhold" => "Saisir le code pour cette rubrique"
                ]
            ])
            ->add('name', TextType::class, [
                "label" => "Nom de la Rubrique (*)",
                "attr" => [
                    "placeholder" => "Saisir le nom de la rubrique "
                ]
            ])
            ->add('amount', MoneyType::class, [
                "label" => "Montant (*)",
                "attr" => [
                    "placelhold" => "Saisir le montant pour cette rubrique"
                ]
            ])
            ->add('premier', MoneyType::class, [
                'required' => false,
                "label" => "Première tranche",
                "attr" => [
                    "placelhold" => "Saisir le montant ici"
                ]
            ])
            ->add('deuxieme', MoneyType::class, [
                'required' => false,
                "label" => "Deuxième tranche ",
                "attr" => [
                    "placelhold" => "Saisir le montant ici"
                ]
            ])
            ->add('devise', EntityType::class, [
                'required' => true,
                'label' => "Sélectionnez la devise",
                'class' => Devise::class,
                "choice_label" => "name"
            ])
            ->add('content', TextareaType::class, [
                'label' => "Description de la rubrique",
                'required' => false,
                'row_attr' => ['class' => 'text-editor'],
                'attr' => [
                    "placeholder" => "Commentaire si possible",
                    "rows" => 5
                ]
            ])
            ->add('sousRubriques', EntityType::class, [
                'required' => false,
                'label' => "Sélectionnez les sous rubriques attachées à celles-ci",
                'class' => EnySousRubrique::class,
                'query_builder' => function(EnySousRubriqueRepository $enySousRubriqueRepository) {
                    $qb = $enySousRubriqueRepository->createQueryBuilder('e');
                    return $qb
                            ->where($qb->expr()->isNull('e.deletedAt'))
                            ->orderBy('e.name', "ASC");
                },
                "choice_label" => "name",
                "multiple" => true,
                "expanded" => true,
            ])
            ->add('enyMotifs', EntityType::class, [
                'required' => false,
                'label' => "Sélectionnez les motifs attachées à celles-ci",
                'class' => EnyMotif::class,
                'query_builder' => function(EnyMotifRepository $enyMotifRepository) {
                    $qb = $enyMotifRepository->createQueryBuilder('e');
                    return $qb
                            ->where($qb->expr()->isNull('e.rubrique'))
                            ->andWhere($qb->expr()->isNull('e.deletedAt'))
                            ->orderBy('e.name', "ASC");
                },
                "choice_label" => "name",
                "multiple" => true,
                "expanded" => true,
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EnyRubrique::class,
        ]);
    }
}
