<?php

namespace App\Controller;

use App\Entity\EnySection;
use App\Form\EnySectionType;
use App\Repository\EnySectionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/eny_section")
 */
class EnySectionController extends AbstractController
{
    /**
     * @Route("/", name="eny_section_index", methods={"GET"})
     */
    public function index(EnySectionRepository $enySectionRepository): Response
    {
        return $this->render('eny_section/index.html.twig', [
            'eny_sections' => $enySectionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="eny_section_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $enySection = new EnySection();
        $form = $this->createForm(EnySectionType::class, $enySection);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($enySection);
            $entityManager->flush();

            return $this->redirectToRoute('eny_section_index');
        }

        return $this->render('eny_section/new.html.twig', [
            'eny_section' => $enySection,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="eny_section_show", methods={"GET"})
     */
    public function show(EnySection $enySection): Response
    {
        return $this->render('eny_section/show.html.twig', [
            'eny_section' => $enySection,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="eny_section_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, EnySection $enySection): Response
    {
        $form = $this->createForm(EnySectionType::class, $enySection);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('eny_section_index');
        }

        return $this->render('eny_section/edit.html.twig', [
            'eny_section' => $enySection,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="eny_section_delete", methods={"DELETE"})
     */
    public function delete(Request $request, EnySection $enySection): Response
    {
        if ($this->isCsrfTokenValid('delete'.$enySection->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($enySection);
            $entityManager->flush();
        }

        return $this->redirectToRoute('eny_section_index');
    }
}
