<?php

namespace App\Controller;

use App\Entity\Devise;
use App\Form\DeviseType;
use App\Repository\DeviseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/devise")
 */
class DeviseController extends AbstractController
{
    /**
     * @Route("/", name="devise_index", methods={"GET"})
     */
    public function index(DeviseRepository $deviseRepository): Response
    {
        return $this->render('devise/index.html.twig', [
            'devises' => $deviseRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="devise_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $devise = new Devise();
        $form = $this->createForm(DeviseType::class, $devise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($devise);
            $entityManager->flush();

            return $this->redirectToRoute('devise_index');
        }

        return $this->render('devise/new.html.twig', [
            'devise' => $devise,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="devise_show", methods={"GET"})
     */
    public function show(Devise $devise): Response
    {
        return $this->render('devise/show.html.twig', [
            'devise' => $devise,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="devise_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Devise $devise): Response
    {
        $form = $this->createForm(DeviseType::class, $devise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('devise_index');
        }

        return $this->render('devise/edit.html.twig', [
            'devise' => $devise,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="devise_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Devise $devise): Response
    {
        if ($this->isCsrfTokenValid('delete'.$devise->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($devise);
            $entityManager->flush();
        }

        return $this->redirectToRoute('devise_index');
    }
}
