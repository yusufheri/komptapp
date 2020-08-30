<?php

namespace App\Controller;

use App\Entity\EnyBankingInfo;
use App\Form\EnyBankingInfoType;
use App\Repository\EnyBankingInfoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/eny_banking_info")
 */
class EnyBankingInfoController extends AbstractController
{
    /**
     * @Route("/", name="eny_banking_info_index", methods={"GET"})
     */
    public function index(EnyBankingInfoRepository $enyBankingInfoRepository): Response
    {
        return $this->render('eny_banking_info/index.html.twig', [
            'eny_banking_infos' => $enyBankingInfoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="eny_banking_info_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $enyBankingInfo = new EnyBankingInfo();
        $form = $this->createForm(EnyBankingInfoType::class, $enyBankingInfo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($enyBankingInfo);
            $entityManager->flush();

            return $this->redirectToRoute('eny_banking_info_index');
        }

        return $this->render('eny_banking_info/new.html.twig', [
            'eny_banking_info' => $enyBankingInfo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="eny_banking_info_show", methods={"GET"})
     */
    public function show(EnyBankingInfo $enyBankingInfo): Response
    {
        return $this->render('eny_banking_info/show.html.twig', [
            'eny_banking_info' => $enyBankingInfo,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="eny_banking_info_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, EnyBankingInfo $enyBankingInfo): Response
    {
        $form = $this->createForm(EnyBankingInfoType::class, $enyBankingInfo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('eny_banking_info_index');
        }

        return $this->render('eny_banking_info/edit.html.twig', [
            'eny_banking_info' => $enyBankingInfo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="eny_banking_info_delete", methods={"DELETE"})
     */
    public function delete(Request $request, EnyBankingInfo $enyBankingInfo): Response
    {
        if ($this->isCsrfTokenValid('delete'.$enyBankingInfo->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($enyBankingInfo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('eny_banking_info_index');
    }
}
