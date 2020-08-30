<?php

namespace App\Form;

use DateTime;
use App\Entity\Devise;
use App\Entity\EnyMvt;
use App\Entity\EnyRubrique;
use App\Entity\EnyInscription;
use App\Repository\DeviseRepository;
use Doctrine\DBAL\Types\DecimalType;
use Symfony\Component\Form\AbstractType;
use App\Repository\EnyRubriqueRepository;
use App\Repository\EnyInscriptionRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class EnyMvtType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('paidAt', DateType::class, [
                'label' => 'Date de paiement (*)',
                'attr' => [
                    'placeholder' => 'Selectionner la date',
                ],                
                'widget' => 'single_text'
            ])
            ->add('amount', MoneyType::class, [
                'label' => 'Montant payé (*)',
                'attr' => [
                    'placeholder' => 'Saisir le montant payé'
                ]
            ])
            ->add('amount_letter', HiddenType::class,[
                'required' => false,]
            )                     
            ->add('student', EntityType::class, [
                'label' => "Nom de l'Etudiant (*)",
                'class' => EnyInscription::class,                
                'query_builder' => function(EnyInscriptionRepository $i){
                    $q1 = $i   ->createQueryBuilder('i');
                    return  $q1->select('e', 'i')
                                ->join('i.num_eny_etudiant', 'e')
                                ->where($q1->expr()->andX(
                                    $q1->expr()->isNull('i.deleted'),
                                    $q1->expr()->isNull('e.deletedAt')
                                ) )
                                ->orderBy('e.nom', 'ASC')
                                ; 
                },
                'choice_label' => function($enyInscription){
                    return $enyInscription->getNumEnyEtudiant()->getNames();
                },
                'choice_value' => function(?EnyInscription $inscription){
                    return $inscription ? $inscription->getId() : '';
                },
                'attr' => [
                    'placeholder' => 'Selectionnez le nom de l etudiant'
                ]
            ])
            ->add('rubrique', EntityType::class, [
                'label' => 'Motif de paiement (*)',
                'class' => EnyRubrique::class,
                'choice_label' => 'name',
                'query_builder' => function(EnyRubriqueRepository $e){
                    $q = $e->createQueryBuilder('e');
                    return $q   ->orderBy('e.name', 'ASC')
                                ->where($q->expr()->isNull('e.deletedAt'))
                                ;
                },
                'attr' => [
                    'placeholder' => 'Selectionnez la devise'
                ]
            ])
            ->add('devise', EntityType::class, [
                'label' => 'Devise (*)',
                'class' => Devise::class,
                'choice_label' => 'name',
                'attr' => [
                    'placeholder' => 'Selectionnez la devise'
                ]
            ])
            ->add('content', TextareaType::class,[
                'label' => 'Commentaire',
                'required' => false,
                'attr' => [
                    'rows' => 5,
                    'placeholder' => 'Laissez un commentaire ici'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EnyMvt::class,
        ]);
    }
}
