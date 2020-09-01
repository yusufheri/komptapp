<?php

namespace App\Form;

use App\Entity\Devise;
use App\Entity\EnyMvt;
use App\Entity\EnyCompte;
use App\Entity\EnyRubrique;
use App\Entity\EnyRubriqueCpt;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use App\Repository\EnyRubriqueRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;

class EnyDepenseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('paidAt', DateType::class, [
                'label' => 'Date de paiement (*)',
                'attr' => [
                    'placeholder' => 'Selectionner la date',
                ],                
                'widget' => 'single_text',
            ])
            ->add('amount', MoneyType::class, [
                'label' => 'Montant depensé (*)',
                'attr' => [
                    'placeholder' => 'Saisir le montant depensé'
                ]
            ])
            ->add('amount_letter', HiddenType::class,[
                'required' => false,]
            )   
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
                ],
                'placeholder' => 'Sélectionnez la rubrique (Motif)'
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
            ]);

            $builder->get('rubrique')->addEventListener(
                FormEvents::POST_SUBMIT,
                function (FormEvent $event) {
                    $form = $event->getForm();
                    $this->addCompteField($form->getParent(), $form->getData());                    
                }
            );
            $builder->addEventListener(
                FormEvents::POST_SET_DATA,
                function (FormEvent $event) {
                    $data = $event->getData(); //Contient l'objet EnyMvt
                    /**@var  EnyRubriqueCpt */
                    $compte = $data->getCompte(); //Recupere les entites de la classe EnyRubriqueCpt
                    $form = $event->getForm();

                    if ($compte) {
                        $rubrique = $compte->getRubrique();

                        $this->addCompteField($form, $rubrique);
                        $this->addSoldeField($form, $compte);
                        
                        $form->get('rubrique')->setData($rubrique);
                        $form->get('solde')->setData($compte);
                    } else {
                        $this->addCompteField($form, null);
                        $this->addSoldeField($form, null);
                    }
                }
            );
        
    }

    /**
     * Permet de rajouter un champ select EnyCompte au Formulaire
     *
     * @param FormInterface $form
     * @param EnyRubrique $rubrique
     * Chef de departement adminstratif
     */
    private function addCompteField(FormInterface $form, ?EnyRubrique $rubrique)
    {
        $builder = $form->getConfig()->getFormFactory()->createNamedBuilder(
                        'compte',
                        EntityType::class,
                        null,
                        [
                            'label' => 'Compte',
                            'auto_initialize' => false,
                            'class' => EnyRubriqueCpt::class,
                            'placeholder' => $rubrique ? 'Sélectionnez le compte à débiter': 'Sélectionnez d abord la rubrique',
                            'choices' => $rubrique ? $rubrique->getEnyRubriqueCpts() : []
                        ]
                );
        $builder->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm();
                $this->addSoldeField($form->getParent(), $form->getData());
            }
        );
        $form->add($builder->getForm());
    }

    /**
     * Permet de rajouter un champ select EnyCompte au Formulaire
     *
     * @param FormInterface $form
     * @param EnyRubrique $rubrique
     * Chef de departement adminstratif
     */
    
    private function addSoldeField(FormInterface $form, ?EnyRubriqueCpt $enyRubriqueCpt)
    {
        $form->add('solde', TextType::class, [
                    'label' => 'Solde du Compte',
                    'data' => 'La vi est belle',
                    'attr' => [
                        'value' => $enyRubriqueCpt ? $enyRubriqueCpt->getAmount().' '.$enyRubriqueCpt->getDevise()->getName():''                       
                    ]
                ]
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EnyMvt::class,
        ]);
    }
}
