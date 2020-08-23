<?php

namespace App\Controller\Admin;

use App\Entity\Devise;
use App\Entity\Rubrique;
use App\Form\RubriqueType;
use Psr\Log\LoggerInterface;
use App\Entity\DetailRubrique;
use App\Entity\RubriqueCompte;
use App\Entity\SousRubrique;
use App\Form\DetailRubriqueType;
use App\Repository\CompteRepository;
use App\Repository\DeviseRepository;
use App\Repository\RubriqueRepository;
use App\Repository\SousRubriqueRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * @Route("/admin/rubrique/", name="admin_rubrique") 
 */
class RubriqueController extends AbstractController
{
    /**
     * @Route("", name="")
     */
    public function index()
    {
        return $this->render('admin/rubrique/index.html.twig');
    }

    /**
     * @Route("new", name="_create")
     */
    public function new(Request $request, ValidatorInterface $validator, 
    LoggerInterface $logger, EntityManagerInterface $manager, 
    DeviseRepository $deviseRepository, SousRubriqueRepository $sousRubriqueRepository): Response
    {
        
        if($request->isXmlHttpRequest()) {            

            $token = $request->request->get("token");
            
            if (!$this->isCsrfTokenValid('security', $token)) {
                $logger->info("CSRF failure");

                return new Response("Operation not allowed :)", Response::HTTP_OK,
                    ['content-type' => 'text/plain']);
            }

            $code = $request->request->get("code");
            $name = $request->request->get("name");
            $devise = $request->request->get("devise");
            $amount = $request->request->get("montant");
            $content = $request->request->get("content");
            $sousRubriques = $request->request->get("sousRubriques");

            $tranche_one = $request->request->get("tranche_one");
            $tranche_two = $request->request->get("tranche_two");

            //$tranche_one = (empty())

            $input = [
                'name' => trim($name), 
                'devise' => trim($devise), 
                'amount' => trim($amount)
            ];

            $constraints = new Assert\Collection([
                'name' => [new Assert\Length(['min' => 5]), new Assert\NotBlank],
                'devise' => [new Assert\NotBlank, new Assert\Positive(), new Assert\NotNull()],
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

                $rubrique = new Rubrique();

                $rubrique->setCode($code);
                $rubrique->setName($name);
                $rubrique->setContent($content);

                for ($i=0; $i < count($sousRubriques)-1; $i++) {                     
                    $sousRubrique = $sousRubriqueRepository->find($sousRubriques[$i]);
                    if(! is_null($sousRubrique)) {
                        $rubrique->addSousRubrique($sousRubrique);
                    }                    
                }               

                $detailRubrique = new DetailRubrique();

                $detailRubrique->setRubrique($rubrique);
                $detailRubrique->setDevise($deviseRepository->find((int) $devise));
                $detailRubrique->setAmount($amount);
                $detailRubrique->setTrancheOne(empty($tranche_one)?null:$tranche_one);
                $detailRubrique->setTrancheTwo(empty($tranche_two)?null:$tranche_two);

                //$manager->persist($rubrique);
                $manager->persist($detailRubrique);
                $manager->flush();

                return new Response("La nouvelle rubrique a été créée avec succès", Response::HTTP_OK,
                    ['content-type' => 'text/plain']);
            }

        } else {
            return new Response("Operation not allowed", Response::HTTP_BAD_REQUEST,
            ['content-type' => 'text/plain']);
        }        
        
    }

    /**
     * Details sur la rubrique sélectionnée
     *
     * @Route("{id}/view", name="_view")
     * @param int $id
     * @return Response
     */
    function view(Rubrique $rubrique)
    {
        return $this->render("admin/rubrique/view.html.twig", [
            'rubrique' => $rubrique
        ]);
    }

    /**
     * Supprime  une rubrique
     *
     * @Route("{id}/delete", name="_delete")
     * @param int $id
     * @return Response
     */
    function delete(Rubrique $rubrique, EntityManagerInterface $manager)
    {
        $rubrique->setDeletedAt(new DateTime());
        $manager->persist($rubrique);
        $manager->flush();

        //return $this->redirectToRoute("admin_rubrique");
        return new Response("/admin/rubrique", Response::HTTP_OK,
        ['content-type' => 'text/plain']);
    }

    /**
     * Supprime  une rubrique
     *
     * @Route("rubriqueComptes/{id}/delete", name="_rubriqueComptes_delete")
     * @param int $id
     * @return Response
     */
    function delete_rubriqueComptes(RubriqueCompte $rubriqueCompte, EntityManagerInterface $manager)
    {
        $rubriqueCompte->setDeletedAt(new DateTime());
        $manager->persist($rubriqueCompte);
        $manager->flush();

        return new Response("success", Response::HTTP_OK,
        ['content-type' => 'text/plain']);
    }

    /**
     *Interface de création d'une rubrique
     * @Route("create", name="_create")
     * @return Response
     */
    function create_from_rubrique(Request $request, EntityManagerInterface $manager,
    DeviseRepository $deviseRepository, SousRubriqueRepository $sousRubriqueRepository)
    {
        $rubrique = new Rubrique();
        $form = $this->createForm(RubriqueType::class, $rubrique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $manager->persist($rubrique);
            $manager->flush();

            $this->addFlash("success", 
            "<h1>Félicitations !</h1><br>La rubrique a été créée avec succès !!");
        }

        return $this->render("admin/rubrique/last_new.html.twig", [
            'devises' => $deviseRepository->findBy(["deletedAt" => null], ["name" => "ASC"]),
            'sous_rubriques' => $sousRubriqueRepository->findBy(["deletedAt" => null], ["name" => "ASC"])
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
    Rubrique $rubrique, CompteRepository $compteRepository)
    {
        if($request->isXmlHttpRequest()) {
            
            $token = $request->request->get("token");
            if(is_null($token)){
                return $this->render("admin/rubrique/new_compte_rubrique.html.twig", [
                    'rubrique' => $rubrique,
                    'comptes' =>  $compteRepository->findBy(["deletedAt" => null], ["name" => "ASC"])
                ]);
            }
            
            if (!$this->isCsrfTokenValid('security', $token)) {
                $logger->info("CSRF failure");

                return new Response("Operation not allowed :)", Response::HTTP_OK,
                    ['content-type' => 'text/plain']);
            }

            //dd($request->get("rubrique"));
            $rubriqueSave = $request->get("rubrique");
            $sous_rubrique = $request->request->get("sous_rubrique");
            $compte = $request->request->get("compte");
            $percent = $request->request->get("percent");
            $amount = $request->request->get("amount");
            $content = $request->request->get("content");

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

                $compte_rubrique = new RubriqueCompte();

                $compte_rubrique->setCompte($compteRepository->find($compte));
                $compte_rubrique->setRubrique($rubriqueSave);
                $compte_rubrique->setAmount($amount);
                $compte_rubrique->setPercent(empty($percent)?null:$percent);
                $compte_rubrique->setSousRubrique($sous_rubrique);
                $compte_rubrique->setContent($content);

                if(!($rubrique->MayBeAddRubriqueCompte($compte_rubrique)))
                {
                    $manager->persist($compte_rubrique);
                    $manager->flush();

                    return new Response("Un compte a été ajouté à cette rubrique avec succès", Response::HTTP_OK,
                        ['content-type' => 'text/plain']);
                } else {
                    $solde = 0;
                    $amount = $rubrique->getDetailRubriques()->last()->getAmount();
                    $devise = $rubrique->getDetailRubriques()->last()->getDevise()->getName();
                    foreach($rubrique->getRubriqueComptes() as $cpt){
                        $solde += $cpt->getAmount();
                    }
                    $diff = $amount - $solde;
                    return new Response(
                        '<div class="alert alert-warning">
                            <h4>La somme des montants répartis ne peuvent pas être supérieur au solde de la rubrique (<b>'
                            .$amount.' '.$devise.
                            '</b> ), il y a déjà (<b>'.$solde.' '.$devise.'</b>) répartis dans d autres comptes et il ne reste que (<b>'.$diff.' '.$devise .'</b>) à répartir.</h4></div>', 
                        Response::HTTP_OK,
                    ['content-type' => 'text/plain']);
                }


                
            }
        }

        return $this->render("admin/rubrique/new_compte_rubrique.html.twig", [
            'rubrique' => $rubrique,
            'comptes' =>  $compteRepository->findBy(["deletedAt" => null], ["name" => "ASC"])
        ]);

    } 

    /**
     * Permet de créer un compte pour une rubrique
     *
     * @Route("view_comptes/{id}", name="_view_comptes")
     * @param int $id
     * @return Response
     */
    function view_comptes(Rubrique $rubrique)
    {
        return $this->render("admin/rubrique/comptes.html.twig", [
            'rubrique' => $rubrique
        ]);
    }

    /**
     * Retourne la liste des comptes créés
     * @Route("api", name="api")
     * @return json
     */
    public function datatable()
    {
        $repo = $this->getDoctrine()->getManager()->getRepository(Rubrique::class);
        return  $this->json($repo->findBy(["deletedAt" => null], ["createdAt" => "DESC"]), 200, [], ['groups' => 'rubrique:read']);
    }

    /**
     * Retourne la liste des comptes créés
     * @Route("{id}/details/api", name="_details_rubrique")
     * @return Response
     */
    public function datatable_details_rubrique(Rubrique $rubrique)
    {
        return $this->render("admin/rubrique/partials/_edit_comptes.html.twig", [
            'rubrique' => $rubrique
        ]);
    }

}
