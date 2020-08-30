<?php

namespace App\Controller;

use App\Entity\EnyBank;
use App\Form\EnyBankType;
use App\Repository\EnyBankRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/partenrs")
 */
class EnyBankController extends AbstractController
{
    /**
     * @Route("/", name="eny_bank_index", methods={"GET"})
     */
    public function index(EnyBankRepository $enyBankRepository): Response
    {
        return $this->render('eny_bank/index.html.twig', [
            'eny_banks' => $enyBankRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="eny_bank_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $enyBank = new EnyBank();
        $form = $this->createForm(EnyBankType::class, $enyBank);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($enyBank);
            $entityManager->flush();

            return $this->redirectToRoute('eny_bank_index');
        }

        return $this->render('eny_bank/new.html.twig', [
            'eny_bank' => $enyBank,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="eny_bank_show", methods={"GET"})
     */
    public function show(EnyBank $enyBank): Response
    {
        return $this->render('eny_bank/show.html.twig', [
            'eny_bank' => $enyBank,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="eny_bank_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, EnyBank $enyBank): Response
    {
        $form = $this->createForm(EnyBankType::class, $enyBank);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('eny_bank_index');
        }

        return $this->render('eny_bank/edit.html.twig', [
            'eny_bank' => $enyBank,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="eny_bank_delete", methods={"DELETE"})
     */
    public function delete(Request $request, EnyBank $enyBank): Response
    {
        if ($this->isCsrfTokenValid('delete'.$enyBank->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($enyBank);
            $entityManager->flush();
        }

        return $this->redirectToRoute('eny_bank_index');
    }
}
