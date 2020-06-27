<?php

namespace App\Controller;

use App\Entity\Motif;
use App\Form\MotifType;
use App\Repository\MotifRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/motif")
 */
class MotifController extends AbstractController
{
    /**
     * @Route("/", name="motif_index", methods={"GET"})
     */
    public function index(MotifRepository $motifRepository): Response
    {
        return $this->render('motif/index.html.twig', [
            'motifs' => $motifRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="motif_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $motif = new Motif();
        $form = $this->createForm(MotifType::class, $motif);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($motif);
            $entityManager->flush();

            return $this->redirectToRoute('motif_index');
        }

        return $this->render('motif/new.html.twig', [
            'motif' => $motif,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="motif_show", methods={"GET"})
     */
    public function show(Motif $motif): Response
    {
        return $this->render('motif/show.html.twig', [
            'motif' => $motif,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="motif_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Motif $motif): Response
    {
        $form = $this->createForm(MotifType::class, $motif);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('motif_index');
        }

        return $this->render('motif/edit.html.twig', [
            'motif' => $motif,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="motif_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Motif $motif): Response
    {
        if ($this->isCsrfTokenValid('delete'.$motif->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($motif);
            $entityManager->flush();
        }

        return $this->redirectToRoute('motif_index');
    }
}
