<?php

namespace App\Controller;

use App\Entity\Orientation;
use App\Form\OrientationType;
use App\Repository\OrientationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/orientation")
 */
class OrientationController extends AbstractController
{
    /**
     * @Route("/", name="orientation_index", methods={"GET"})
     */
    public function index(OrientationRepository $orientationRepository): Response
    {
        return $this->render('orientation/index.html.twig', [
            'orientations' => $orientationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="orientation_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $orientation = new Orientation();
        $form = $this->createForm(OrientationType::class, $orientation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($orientation);
            $entityManager->flush();

            return $this->redirectToRoute('orientation_index');
        }

        return $this->render('orientation/new.html.twig', [
            'orientation' => $orientation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="orientation_show", methods={"GET"})
     */
    public function show(Orientation $orientation): Response
    {
        return $this->render('orientation/show.html.twig', [
            'orientation' => $orientation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="orientation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Orientation $orientation): Response
    {
        $form = $this->createForm(OrientationType::class, $orientation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('orientation_index');
        }

        return $this->render('orientation/edit.html.twig', [
            'orientation' => $orientation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="orientation_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Orientation $orientation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$orientation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($orientation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('orientation_index');
    }
}
