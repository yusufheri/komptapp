<?php

namespace App\Controller;

use App\Entity\EnyDispatch;
use App\Entity\EnyMvt;
use App\Entity\EnyRubriqueCpt;
use App\Entity\EnyTypeMvt;
use App\Form\EnyDepenseType;
use App\Form\EnyMvtType;
use App\Repository\EnyMvtRepository;
use Doctrine\ORM\Query\Expr\Math;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/operations")
 */
class EnyMvtController extends AbstractController
{
    /**
     * @Route("/entry", name="eny_mvt_entry", methods={"GET"})
     */
    public function entrees(EnyMvtRepository $enyMvtRepository): Response
    {
        $type = $this->getDoctrine()->getManager()->getRepository(EnyTypeMvt::class)->find(1);
        return $this->render('eny_mvt/index.html.twig', [
            'eny_mvts' => $enyMvtRepository->findMvt($type),
            'title' => 'Historiques des Entrées'
        ]);
    }

    /**
     * @Route("/depenses", name="eny_mvt_depenses", methods={"GET"})
     */
    public function sorties(EnyMvtRepository $enyMvtRepository): Response
    {
        $type = $this->getDoctrine()->getManager()->getRepository(EnyTypeMvt::class)->find(2);
        return $this->render('eny_mvt/depenses/index.html.twig', [
            'eny_mvts' => $enyMvtRepository->findMvt($type),
            'title' => 'Historiques des Depenses'
        ]);
    }

    /**
     * @Route("/entry/new", name="eny_mvt_entry_new", methods={"GET","POST"})
     */
    public function new_entry(Request $request): Response
    {
        $enyMvt = new EnyMvt();
        $form = $this->createForm(EnyMvtType::class, $enyMvt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $amountTyped = $enyMvt->getAmount();

            $enyMvt->setIdEtudiant($enyMvt->getStudent()->getNum())
                    ->setAmountLetter(\base64_encode($amountTyped))
                    ->setReste($amountTyped)
                    ->setTypeMvt($entityManager->getRepository(EnyTypeMvt::class)->find(1));
            
            $rubrique = $enyMvt->getRubrique();
            $cpts = $rubrique->getEnyRubriqueCpts();

            //Recupere le montant fixé pour la rubrique sélectionnée
            $amountRubrique = $rubrique->getLastDetailsRubrique()->getAmount(); 
            if ($amountRubrique >= $amountTyped) {
                /**@var EnyRubriqueCpt $compte */
                foreach ($cpts as $key => $compte) {
                    $dispatch = new EnyDispatch();
                    //Montant à  affecter au compte approprié
                    $debit = round($amountRubrique * $compte->getPercent()/100,2);
                    //La différence entre le montant entré et le montant à déduire pour affecter au cpt approprié
                    $enyMvt->setReste($enyMvt->getReste() - $debit);

                    $dispatch   ->setCompte($compte)
                                ->setMvt($enyMvt)
                                ->setAmount($debit)
                                ->setSymbol(true)
                                ->setAmountLetter(\base64_encode($enyMvt->getAmount()))
                                ->setContent($enyMvt->getContent());
                    $entityManager->persist($dispatch);    
                }
            } else {
                $enyMvt->setContent("Le montant payé est supérieur au montant fixé pour cette rubrique (".$enyMvt->getRubrique()->getName()."), prière de procéder au dispatching manuel");
            }

            //Encrypte le montant restant après le dispatching du montant payé par l'étudiant
            $enyMvt->setResteLetter(\base64_encode($enyMvt->getReste()));
            $entityManager->persist($enyMvt);
            $entityManager->flush();

            return $this->redirectToRoute('eny_mvt_entry');
        }

        return $this->render('eny_mvt/new.html.twig', [
            'eny_mvt' => $enyMvt,
            'form' => $form->createView(),
            'title' => 'Nouvelle entrée'
        ]);
    }

    /**
     * @Route("/depenses/new", name="eny_mvt_depenses_new", methods={"GET","POST"})
     */
    public function new_depense(Request $request): Response
    {
        $enyMvt = new EnyMvt();
        $form = $this->createForm(EnyDepenseType::class, $enyMvt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();

            $enyMvt     ->setIdEtudiant('')
                        ->setAmountLetter($enyMvt->getAmount())
                        ->setTypeMvt($entityManager->getRepository(EnyTypeMvt::class)->find(2));
            $entityManager->persist($enyMvt);

            $dispatch = new EnyDispatch();
            $dispatch   ->setCompte($enyMvt->getCompte())
                        ->setMvt($enyMvt)
                        ->setAmount($enyMvt->getAmount())
                        ->setSymbol(false)
                        ->setAmountLetter(\base64_encode($enyMvt->getAmount()))
                        ->setContent($enyMvt->getContent());

            $entityManager->persist($dispatch);
            $entityManager->flush();

            return $this->redirectToRoute('eny_mvt_depenses');
        }

        return $this->render('eny_mvt/depenses/new.html.twig', [
            'eny_mvt' => $enyMvt,
            'form' => $form->createView(),
            'title' => 'Nouvelle depense'
        ]);
    }

    /**
     * @Route("/entry/import-file", name="eny_mvt_entry_new_file", methods={"GET","POST"})
     */
    public function newFile(Request $request): Response
    {
        $enyMvt = new EnyMvt();
        $form = $this->createForm(EnyMvtType::class, $enyMvt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($enyMvt);
            $entityManager->flush();

            return $this->redirectToRoute('eny_mvt_index');
        }

        return $this->render('eny_mvt/new.html.twig', [
            'eny_mvt' => $enyMvt,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="eny_mvt_show", methods={"GET"})
     */
    public function show(EnyMvt $enyMvt): Response
    {
        return $this->render('eny_mvt/show.html.twig', [
            'eny_mvt' => $enyMvt,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="eny_mvt_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, EnyMvt $enyMvt): Response
    {
        $form = $this->createForm(EnyMvtType::class, $enyMvt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $type = $enyMvt->getTypeMvt()->getId();
            if($type == 1)
            {
                return $this->redirectToRoute('eny_mvt_entry');
            } else {
                return new Response("No access !!!",404);
            }
            
        }

        return $this->render('eny_mvt/edit.html.twig', [
            'eny_mvt' => $enyMvt,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/depenses/{id}", name="eny_mvt_show_depenses", methods={"GET"})
     */
    public function show_depenses(EnyMvt $enyMvt): Response
    {
        return $this->render('eny_mvt/depenses/show.html.twig', [
            'eny_mvt' => $enyMvt,
        ]);
    }

    /**
     * @Route("/depenses/{id}/edit", name="eny_mvt_edit_depenses", methods={"GET","POST"})
     */
    public function edit_depenses(Request $request, EnyMvt $enyMvt): Response
    {
        $form = $this->createForm(EnyDepenseType::class, $enyMvt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $type = $enyMvt->getTypeMvt()->getId();
            if($type == 2) {
                return $this->redirectToRoute('eny_mvt_depenses');
            } else {
                return new Response("No access !!!",404);
            }
            
        }

        return $this->render('eny_mvt/depenses/edit.html.twig', [
            'eny_mvt' => $enyMvt,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="eny_mvt_delete", methods={"DELETE"})
     */
    public function delete(Request $request, EnyMvt $enyMvt): Response
    {
        if ($this->isCsrfTokenValid('delete'.$enyMvt->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($enyMvt);
            $entityManager->flush();
        }

        return $this->redirectToRoute('homepage');
    }
}
