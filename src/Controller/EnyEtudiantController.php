<?php

namespace App\Controller;

use App\Entity\EnyEtudiant;
use App\Form\EnyEtudiantType;
use App\Repository\EnyEtudiantRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/students", name="eny_etudiant")
 */
class EnyEtudiantController extends AbstractController
{
    /**
     * @Route("/", name="_index")
     */
    public function index(EnyEtudiantRepository $repo)
    {
        return $this->render('eny_etudiant/index.html.twig', [
            'etudiants' => $repo->findBy(["deletedAt" => null], ["nom" => "ASC"]),
        ]);
    }

    /**
     * Permet de créer un nouvel étudiant
     * @Route("/create", name="_new")
     * @return Response
     */
    public function new(Request $request)
    {
        $student = new EnyEtudiant();
        
        $form = $this->createForm(EnyEtudiantType::class, $student);
        $form->handleRequest($request);

        return $this->render('eny_etudiant/new.html.twig', [
            'form' => $form->createView()
        ]);
        
    }
}
