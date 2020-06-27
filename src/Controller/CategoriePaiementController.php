<?php

namespace App\Controller;

use App\Entity\CategoriePaiement;
use App\Form\CategoriePaiementType;
use App\Repository\CategoriePaiementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/categorie/paiement")
 */
class CategoriePaiementController extends AbstractController
{
    /**
     * @Route("/", name="categorie_paiement_index", methods={"GET"})
     */
    public function index(CategoriePaiementRepository $categoriePaiementRepository): Response
    {
        return $this->render('categorie_paiement/index.html.twig', [
            'categorie_paiements' => $categoriePaiementRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="categorie_paiement_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $categoriePaiement = new CategoriePaiement();
        $form = $this->createForm(CategoriePaiementType::class, $categoriePaiement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($categoriePaiement);
            $entityManager->flush();

            return $this->redirectToRoute('categorie_paiement_index');
        }

        return $this->render('categorie_paiement/new.html.twig', [
            'categorie_paiement' => $categoriePaiement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="categorie_paiement_show", methods={"GET"})
     */
    public function show(CategoriePaiement $categoriePaiement): Response
    {
        return $this->render('categorie_paiement/show.html.twig', [
            'categorie_paiement' => $categoriePaiement,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="categorie_paiement_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CategoriePaiement $categoriePaiement): Response
    {
        $form = $this->createForm(CategoriePaiementType::class, $categoriePaiement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('categorie_paiement_index');
        }

        return $this->render('categorie_paiement/edit.html.twig', [
            'categorie_paiement' => $categoriePaiement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="categorie_paiement_delete", methods={"DELETE"})
     */
    public function delete(Request $request, CategoriePaiement $categoriePaiement): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categoriePaiement->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($categoriePaiement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('categorie_paiement_index');
    }
}
