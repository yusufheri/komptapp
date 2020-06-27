<?php

namespace App\Controller;

use App\Entity\Tranche;
use App\Form\TrancheType;
use App\Repository\TrancheRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tranche")
 */
class TrancheController extends AbstractController
{
    /**
     * @Route("/", name="tranche_index", methods={"GET"})
     */
    public function index(TrancheRepository $trancheRepository): Response
    {
        return $this->render('tranche/index.html.twig', [
            'tranches' => $trancheRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="tranche_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $tranche = new Tranche();
        $form = $this->createForm(TrancheType::class, $tranche);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tranche);
            $entityManager->flush();

            return $this->redirectToRoute('tranche_index');
        }

        return $this->render('tranche/new.html.twig', [
            'tranche' => $tranche,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tranche_show", methods={"GET"})
     */
    public function show(Tranche $tranche): Response
    {
        return $this->render('tranche/show.html.twig', [
            'tranche' => $tranche,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tranche_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Tranche $tranche): Response
    {
        $form = $this->createForm(TrancheType::class, $tranche);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tranche_index');
        }

        return $this->render('tranche/edit.html.twig', [
            'tranche' => $tranche,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tranche_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Tranche $tranche): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tranche->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($tranche);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tranche_index');
    }
}
