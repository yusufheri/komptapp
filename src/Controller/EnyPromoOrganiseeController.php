<?php

namespace App\Controller;

use App\Entity\EnyPromoOrganisee;
use App\Form\EnyPromoOrganiseeType;
use App\Repository\EnyDepartementRepository;
use App\Repository\EnyPromoOrganiseeRepository;
use App\Repository\EnySectionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/eny_promo_organisee")
 */
class EnyPromoOrganiseeController extends AbstractController
{
    /**
     * @Route("/", name="eny_promo_organisee_index", methods={"GET"})
     */
    public function index(EnyPromoOrganiseeRepository $enyPromoOrganiseeRepository, 
    EnyDepartementRepository $departement, EnySectionRepository $enySection ): Response
    {
        $data  = $enyPromoOrganiseeRepository->findAll();
        $promotions = [];
        foreach ($data as $key => $enyPromoOrganisee) {
            $orientation  = $departement->find(trim($enyPromoOrganisee->getNumEnyDepartement()));
            $section = $enySection->find( trim($enyPromoOrganisee->getNumFaculte()));

            $enyPromoOrganisee->setNameSection((is_null($section)?'':$section->getName()));
            $enyPromoOrganisee->setNameOrientation((is_null($orientation)?'':$orientation->getLib()));
            $promotions [] = $enyPromoOrganisee;
        }
        return $this->render('eny_promo_organisee/index.html.twig', [
            'eny_promo_organisees' => $promotions,
        ]);
    }

    /**
     * @Route("/new", name="eny_promo_organisee_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $enyPromoOrganisee = new EnyPromoOrganisee();
        $form = $this->createForm(EnyPromoOrganiseeType::class, $enyPromoOrganisee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($enyPromoOrganisee);
            $entityManager->flush();

            return $this->redirectToRoute('eny_promo_organisee_index');
        }

        return $this->render('eny_promo_organisee/new.html.twig', [
            'eny_promo_organisee' => $enyPromoOrganisee,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="eny_promo_organisee_show", methods={"GET"})
     */
    public function show(EnyPromoOrganisee $enyPromoOrganisee): Response
    {
        return $this->render('eny_promo_organisee/show.html.twig', [
            'eny_promo_organisee' => $enyPromoOrganisee,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="eny_promo_organisee_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, EnyPromoOrganisee $enyPromoOrganisee): Response
    {
        $form = $this->createForm(EnyPromoOrganiseeType::class, $enyPromoOrganisee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('eny_promo_organisee_index');
        }

        return $this->render('eny_promo_organisee/edit.html.twig', [
            'eny_promo_organisee' => $enyPromoOrganisee,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="eny_promo_organisee_delete", methods={"DELETE"})
     */
    public function delete(Request $request, EnyPromoOrganisee $enyPromoOrganisee): Response
    {
        if ($this->isCsrfTokenValid('delete'.$enyPromoOrganisee->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($enyPromoOrganisee);
            $entityManager->flush();
        }

        return $this->redirectToRoute('eny_promo_organisee_index');
    }
}
