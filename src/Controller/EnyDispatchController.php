<?php

namespace App\Controller;

use App\Entity\EnyMvt;
use App\Entity\EnyTypeMvt;
use App\Entity\EnyDispatch;
use App\Entity\EnyRubriqueCpt;
use App\Repository\EnyMvtRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
     * @Route("/repartition", name="eny_dispatch")
     */
class EnyDispatchController extends AbstractController
{
    /**
     * @Route("", name="_index")
     */
    public function index(EnyMvtRepository $enyMvtRepository)
    {
        $type = $this->getDoctrine()->getManager()->getRepository(EnyTypeMvt::class)->find(1);
        return $this->render('eny_dispatch/index.html.twig', [
            'eny_mvts' => $enyMvtRepository->dispatch($type),
            'corriger' => $enyMvtRepository->corriger($type),
            'success' => $enyMvtRepository->success($type),
        ]);
    }

    /**
     * @Route("/{id}/request", name="_request")
     */
    public function dispatching(EnyMvt $mvt, EntityManagerInterface $entityManager)
    {
        if ($mvt->getDispatch() == false) 
        {
            $rubrique = $mvt->getRubrique();
            if (is_null($rubrique)) {
                $mvt    ->setError(true)
                        ->setErrorMessage("Aucune rubrique ne correspond à cette ligne, prière de vérifier les informations enregistrées")
                        ->setManual(true);
            } else {
                $detailRubrique = $rubrique->getLastDetailsRubrique(); 
                if (! (is_null($detailRubrique)))  
                {
                    //Recupere le montant fixé pour la rubrique sélectionnée
                    $amountRubrique = $detailRubrique->getAmount();
                    //dump("Montant de la rubrique : " . $amountRubrique);
                    $premierTranche = $detailRubrique->getTrancheOne();
                    $deuxiemeTranche = $detailRubrique->getTrancheTwo();
                    $amountTyped = $mvt->getAmount();
                    $cpts = new ArrayCollection(); 

                    $tranche = $mvt->getTranche()->getCode();
                    $montantPrevu = 0.0;
                    if ($amountRubrique == $amountTyped || $tranche  == 3) {
                        $cpts = $rubrique->getEnyRubriqueCpts();
                        $montantPrevu = $amountRubrique;
                    } 
                    // Celle-ci correspond à la dispatching de la premiere tranche de minerval
                    else if ($premierTranche == $amountTyped || $tranche  == 1) { 
                        $cpts = $rubrique->getEnyRubriqueCptsPremiereTranche();
                        $montantPrevu = $premierTranche;
                    } 
                    // Celle-ci correspond à la dispatching de la deuxieme tranche de minerval
                    else if ($amountTyped == $deuxiemeTranche || $tranche  == 2) {
                        $cpts = $rubrique->getEnyRubriqueCptsDeuxiemeTranche();
                        $montantPrevu = $deuxiemeTranche;
                    } else {
                        $mvt->setContent("Le montant payé est différent du montant fixé pour cette rubrique (".$mvt->getRubrique()->getName()."), prière de procéder au dispatching manuel");
                        $mvt->setManual(true);
                        $mvt->setError(true);
                        $mvt->setErrorMessage($mvt->getContent());
                        return;
                    }

                    $somme_debit = 0.0;
                    $reste  = $mvt->getReste()? 0 : $mvt->getReste();
                    /**@var EnyRubriqueCpt $compte */
                    foreach ($cpts as $key => $compte) {
                        $dispatch = new EnyDispatch();
                        //Montant à  affecter au compte approprié
                        //$debit = round($amountRubrique * $compte->getPercent()/100,2);
                        if ($tranche == 1) {
                            $debit = $compte->getTrancheOne();
                        } elseif ($tranche == 2) {
                            $debit = $compte->getTrancheTwo();
                        } else {
                            $debit = $compte->getAmount();
                        }
                        $somme_debit += $debit;
                        if ($somme_debit <= $montantPrevu) 
                        {
                            //La différence entre le montant entré et le montant à déduire pour affecter au cpt approprié                        
                            $reste -= $debit;
                            $dispatch   ->setCompte($compte) 
                                        ->setMvt($mvt)
                                        ->setAmount($debit)
                                        ->setSymbol(true)
                                        ->setAmountLetter(\base64_encode($debit))
                                        ->setContent($mvt->getContent());
                            $entityManager->persist($dispatch);
                        }                  
                    }
                    $mvt->setReste($reste);
                    $mvt->setDispatch(true);
                    //dump("Somme : ". $somme_debit);  
                    //dump("Montant prévu : " . $montantPrevu);
                    $entityManager->persist($mvt);
                    $entityManager->flush();
                    //dump($mvt->getReste());
                    return new Response("success", 200);

                } else {
                    $mvt ->setError(true)
                        ->setErrorMessage("Aucun detail sur cette rubrique, prière de vérifier les informations")
                        ;
                }
            }
        } else {
            return new Response("Already dispatching !!!", 304);
        }
    }

    
}
