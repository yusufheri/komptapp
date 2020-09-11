<?php

namespace App\Controller;

use App\Entity\EnyTranche;
use App\Form\EnyTrancheType;
use App\Repository\EnyTrancheRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tranches")
 */
class EnyTrancheController extends AbstractController
{
    /**
     * @Route("/", name="eny_tranche_index", methods={"GET"})
     */
    public function index(EnyTrancheRepository $enyTrancheRepository): Response
    {
        return $this->render('eny_tranche/index.html.twig', [
            'eny_tranches' => $enyTrancheRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="eny_tranche_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $enyTranche = new EnyTranche();
        $form = $this->createForm(EnyTrancheType::class, $enyTranche);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($enyTranche);
            $entityManager->flush();

            return $this->redirectToRoute('eny_tranche_index');
        }

        return $this->render('eny_tranche/new.html.twig', [
            'eny_tranche' => $enyTranche,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="eny_tranche_show", methods={"GET"})
     */
    public function show(EnyTranche $enyTranche): Response
    {
        return $this->render('eny_tranche/show.html.twig', [
            'eny_tranche' => $enyTranche,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="eny_tranche_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, EnyTranche $enyTranche): Response
    {
        $form = $this->createForm(EnyTrancheType::class, $enyTranche);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('eny_tranche_index');
        }

        return $this->render('eny_tranche/edit.html.twig', [
            'eny_tranche' => $enyTranche,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="eny_tranche_delete", methods={"DELETE"})
     */
    public function delete(Request $request, EnyTranche $enyTranche): Response
    {
        if ($this->isCsrfTokenValid('delete'.$enyTranche->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($enyTranche);
            $entityManager->flush();
        }

        return $this->redirectToRoute('eny_tranche_index');
    }
}
