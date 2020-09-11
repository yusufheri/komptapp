<?php

namespace App\Controller\Params;

use App\Entity\EnyRubrique;
use Psr\Log\LoggerInterface;
use App\Form\EnyRubriqueType;
use App\Entity\DetailRubrique;
use App\Entity\EnyRubriqueCpt;
use App\Entity\RubriqueCompte;
use App\Entity\EnyDetailRubrique;
use App\Entity\EnyMotif;
use App\Repository\EnyCompteRepository;
use App\Repository\EnyRubriqueCptRepository;
use App\Repository\EnyRubriqueRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
     * @Route("/admin/rubriques/", name="admin_rubriques")
     */
class EnyRubriqueController extends AbstractController
{
    /**
     * Liste de toutes les rubriques 
     * @Route("", name="_index")
     * 
     * @return Response
     */
    public function index()
    {
        return $this->render('params/eny_rubrique/index.html.twig', [
            'controller_name' => 'EnyRubriqueController',
        ]);
    }

    /**
     * Création de l'entité Rubrique
     * @Route("new", name="_create")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function new(Request $request, EntityManagerInterface $manager)
    {
        $rubrique = new EnyRubrique();
        $form = $this->createForm(EnyRubriqueType::class, $rubrique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            if ($rubrique->getEnyMotifs()->count() > 0) {
                /**@var EnyMotif $motif */
                foreach ($rubrique->getEnyMotifs() as $key => $motif) {
                    //$motif->addEnyRubrique($rubrique);
                    //$motif->setRubrique($rubrique);
                    $rubrique->addMotif($motif);
                    //$manager->persist($motif);
                }
            }

            $detail = new EnyDetailRubrique();
            $detail->setRubrique($rubrique);
            $detail->setAmount($rubrique->getAmount());
            $detail->setDevise($rubrique->getDevise());
            $detail->setTrancheOne($rubrique->getPremier());
            $detail->setTrancheTwo($rubrique->getDeuxieme());
            $manager->persist($detail);

            $manager->persist($rubrique);
            $manager->flush();

            $this->addFlash("succes", 
                "La rubrique est créée avec succès"
            );
            return $this->redirectToRoute('admin_rubriques_index');
        }
        return $this->render('params/eny_rubrique/new.html.twig', [
            "form" => $form->createView()
        ]);
    }

    /**
     * Modidification de l'entité Rubrique
     * @Route("{id}/edit", name="_edit")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function edit(EnyRubrique $rubrique,Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(EnyRubriqueType::class, $rubrique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            if ($rubrique->getEnyMotifs()->count() > 0) {
                foreach ($rubrique->getEnyMotifs() as $key => $motif) {
                    $motif->setRubrique($rubrique);
                    $manager->persist($motif);
                }
            }

            $detail = new EnyDetailRubrique();
            $detail->setRubrique($rubrique);
            $detail->setAmount($rubrique->getAmount());
            $detail->setDevise($rubrique->getDevise());
            $detail->setTrancheOne($rubrique->getPremier());
            $detail->setTrancheTwo($rubrique->getDeuxieme());
            $manager->persist($detail);

            $manager->persist($rubrique);
            $manager->flush();

            $this->addFlash("succes", 
                "La rubrique est modifiée avec succès"
            );
            return $this->redirectToRoute('admin_rubriques_index');
        }
        return $this->render('params/eny_rubrique/new.html.twig', [
            "form" => $form->createView()
        ]);
    }

    /**
     * Details sur la rubrique sélectionnée
     *
     * @Route("{id}/view", name="_view")
     * @param int $id
     * @return Response
     */
    function view(EnyRubrique $rubrique)
    {
        return $this->render("params/eny_rubrique/view.html.twig", [
            'rubrique' => $rubrique
        ]);
    }

    /**
     * Permet de créer un compte pour une rubrique
     *
     * @Route("create_compte/{id}", name="_create_compte")
     * @param int $id
     * @return Response
     */
    function create_compte(Request $request, ValidatorInterface $validator, 
                            LoggerInterface $logger, EntityManagerInterface $manager,  
                            EnyRubrique $rubrique, EnyCompteRepository $compteRepository)
    {
        if($request->isXmlHttpRequest()) {
            
            $token = $request->request->get("token");
            if(is_null($token)){
                return $this->render("params/partials/new_compte_rubrique.html.twig", [
                    'rubrique' => $rubrique,
                    'comptes' =>  $compteRepository->findBy(["deletedAt" => null], ["name" => "ASC"])
                ]);
            }
            
            if (!$this->isCsrfTokenValid('security', $token)) {
                $logger->info("CSRF failure");

                return new Response("Operation not allowed :)", Response::HTTP_OK,
                    ['content-type' => 'text/plain']);
            }

            //  dd($request->request->get("tranche1"));
            $rubriqueSave = $request->get("rubrique");
            $sous_rubrique = $request->request->get("sous_rubrique");
            $compte = $request->request->get("compte");
            $percent = trim($request->request->get("percent"));
            $amount = trim($request->request->get("amount"));
            $content = trim($request->request->get("content"));

            $tranche1 = trim($request->request->get("tranche1"));
            $tranche2 = trim($request->request->get("tranche2"));

            $input = [
                'rubrique' => $rubriqueSave->getId(),
                'compte' => trim($compte), 
                'amount' => trim($amount), 
            ];

            $constraints = new Assert\Collection([
                'rubrique' => [new Assert\NotBlank, new Assert\Positive(), new Assert\NotNull()],
                'compte' => [new Assert\NotBlank, new Assert\Positive(), new Assert\NotNull()],
                'amount' => [new Assert\NotBlank, new Assert\Positive(), new Assert\NotNull()],
                
            ]);
    
            $violations = $validator->validate($input, $constraints);

            if (count($violations) > 0) {
    
                $accessor = PropertyAccess::createPropertyAccessor();
    
                $errorMessages = [];
    
                foreach ($violations as $violation) {
    
                    $accessor->setValue($errorMessages,
                        $violation->getPropertyPath(),
                        $violation->getMessage());
                }
    
                return $this->render('partials/forms/violations.html.twig',
                    ['errorMessages' => $errorMessages]);
            } else {

                $compte_rubrique = new EnyRubriqueCpt();

                $compte_rubrique->setCompte($compteRepository->find($compte));
                $compte_rubrique->setRubrique($rubriqueSave);
                $compte_rubrique->setAmount($amount);
                $compte_rubrique->setPercent(empty($percent)?null:$percent);
                $compte_rubrique->setSrubrique($sous_rubrique);
                $compte_rubrique->setContent($content);
                $compte_rubrique->setDevise($rubrique->getLastDetailsRubrique()->getDevise());
                $compte_rubrique->setTrancheOne( empty($tranche1)? null : $tranche1 );
                $compte_rubrique->setTrancheTwo( empty($tranche2)? null : $tranche2 );

                if ( !($rubrique->existRubriqueCompte($compte_rubrique)) )
                {
                    if(($rubrique->MayBeAddRubriqueCompte($compte_rubrique)))
                    {
                        $manager->persist($compte_rubrique);
                        $manager->persist($rubrique);
                        $manager->flush();

                        return new Response("Un compte a été ajouté à cette rubrique avec succès", Response::HTTP_OK,
                            ['content-type' => 'text/plain']); 
                    } else {
                        $solde = 0;
                        $amount = $rubrique->getLastDetailsRubrique()->getAmount();
                        $devise = $rubrique->getLastDetailsRubrique()->getDevise()->getName();
                        foreach($rubrique->getEnyRubriqueCpts() as $cpt){
                            $solde += $cpt->getAmount();
                        }
                        $diff = $amount - $solde;
                        return new Response(
                            '<div class="alert alert-warning">
                                <h4>La somme des montants répartis ne peuvent pas être supérieur au solde de la rubrique (<b>'
                                .$amount.' '.$devise. '</b> ), il y a déjà (<b>'.$solde.' '.$devise.'</b>) répartis dans d autres comptes et il ne reste que (<b>'.$diff.' '.$devise .'</b>) à répartir.</h4></div>', 
                            Response::HTTP_OK, ['content-type' => 'text/plain']);
                    }
                } else {
                    return new Response(
                        '<div class="alert alert-danger">
                            <h4>Ce compte est déjà rattraché à cette rubrique</h4>
                            <p>Prière de vérifier sur la liste ci-dessous</p>
                        </div>', 
                        Response::HTTP_OK,
                    ['content-type' => 'text/plain']);
                }
                
            }
        }

        return $this->render("params/partials/new_compte_rubrique.html.twig", [
            'rubrique' => $rubrique,
            'comptes' =>  $compteRepository->findBy(["deletedAt" => null], ["name" => "ASC"])
        ]);

    } 

    /**
     * Supprime  une rubrique
     *
     * @Route("{id}/delete", name="_delete")
     * @param int $id
     * @return Response
     */
    function delete(EnyRubrique $rubrique, EntityManagerInterface $manager)
    {
        $rubrique->setDeletedAt(new \DateTime());
        $manager->persist($rubrique);
        $manager->flush();

        //return $this->redirectToRoute("admin_rubrique");
        return new Response("/admin/rubriques/", Response::HTTP_OK,
        ['content-type' => 'text/plain']);
    }

    /**
     * Supprime  une rubrique
     *
     * @Route("rubriqueComptes/{id}/delete", name="_rubriqueComptes_delete")
     * @param int $id
     * @return Response
     */
    function delete_rubriqueComptes(EnyRubriqueCpt $rubriqueCompte, EntityManagerInterface $manager)
    {
        $rubriqueCompte->setDeletedAt(new \DateTime());
        $manager->persist($rubriqueCompte);
        $manager->flush();

        return new Response("success", Response::HTTP_OK,
        ['content-type' => 'text/plain']);
    }

    /**
     * Retourne la liste des rubriques créées
     * @Route("api", name="_api")
     * @return json
     */
    public function datatable()
    {
        $repo = $this->getDoctrine()->getManager()->getRepository(EnyRubrique::class);
        return  $this->json($repo->findBy(["deletedAt" => null], ["createdAt" => "DESC"]), 200, [], ['groups' => 'rubrique:read']);
    }

    /**
     * Retourne la liste des comptes créés
     * @Route("{id}/details/api", name="_details_rubrique")
     * @return Response
     */
    public function datatable_details_rubrique(EnyRubrique $rubrique)
    {
        return $this->render("params/rubriques/partials/_edit_comptes.html.twig", [
            'rubrique' => $rubrique
        ]);
    }
}
