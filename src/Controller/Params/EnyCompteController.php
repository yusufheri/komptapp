<?php

namespace App\Controller\Params;

use App\Entity\Compte;
use App\Entity\EnyCompte;
use App\Form\EnyCompteType;
use DateTime;
use Psr\Log\LoggerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/cpte/", name="admin_cpt") 
 */
class EnyCompteController extends AbstractController
{
    /**
     * @Route("", name="_index")
     */
    public function index()
    {
        return $this->render('params/eny_compte/index.html.twig', [
            'controller_name' => 'EnyCompteController',
        ]);
    }

    /**
     * @Route("create_form", name="_create_form")
     */
    public function create(Request $request, EntityManagerInterface $manager)
    {
        $cpte = new EnyCompte();
        $form = $this->createForm(EnyCompteType::class, $cpte);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            return new Response("Success", 200);
        }

        return $this->render("params/eny_compte/new.html.twig", [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("{id}/edit_form", name="_edit_form")
     */
    public function editForm(EnyCompte $cpte, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(EnyCompteType::class, $cpte);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($cpte);
            $manager->flush();
            return $this->redirectToRoute("admin_cpte_index");
        }

        if($request->isXmlHttpRequest()) 
        {
            return $this->render("params/eny_compte/new.html.twig", [
                "form" => $form->createView(),
                'compte' => $cpte
            ]);
        } else {
            return new Response("denied access !!!");
        }
        
    }

    /**
     * @Route("{id}/edit", name="_edit")
     */
    public function edit(EnyCompte $enyCompte,Request $request, ValidatorInterface $validator, LoggerInterface $logger, EntityManagerInterface $manager): Response
    {
        
        if($request->isXmlHttpRequest()) {
            
            $eny_compte = $request->request->get('eny_compte');
            $token =$eny_compte["_token"];
            $code = $eny_compte["code"];
            $name = $eny_compte["name"];
            $content = $eny_compte["content"];

            $input = ['name' => $name];

            $constraints = new Assert\Collection([
                'name' => [new Assert\NotBlank],
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

                $enyCompte->setCode($code);
                $enyCompte->setName($name);
                $enyCompte->setContent($content);
                //dd($enyCompte);
                $manager->persist($enyCompte);
                $manager->flush();

                return new Response("Le compte a été modifié avec succès", Response::HTTP_OK,
                    ['content-type' => 'text/plain']);
            }

        } else {
            return new Response("Operation not allowed", Response::HTTP_BAD_REQUEST,
            ['content-type' => 'text/plain']);
        }        
        
    }

    /**
     * @Route("new", name="_create")
     */
    public function new(Request $request, ValidatorInterface $validator, LoggerInterface $logger, EntityManagerInterface $manager): Response
    {
        
        if($request->isXmlHttpRequest()) {
            
            $eny_compte = $request->request->get('eny_compte');
            $token =$eny_compte["_token"];
            $code = $eny_compte["code"];
            $name = $eny_compte["name"];
            $content = $eny_compte["content"];

            $input = ['name' => $name];

            $constraints = new Assert\Collection([
                'name' => [new Assert\NotBlank],
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
                $compte = new EnyCompte();
                $compte->setCode($code);
                $compte->setName($name);
                $compte->setContent($content);

                
                $manager->persist($compte);
                $manager->flush();

                return new Response("Le nouveau compte a été créé avec succès", Response::HTTP_OK,
                    ['content-type' => 'text/plain']);
            }

        } else {
            return new Response("Operation not allowed", Response::HTTP_BAD_REQUEST,
            ['content-type' => 'text/plain']);
        }        
        
    }

    /**
     * @Route("{id}/delete", name="_edit")
     */
    public function delete(EnyCompte $enyCompte,Request $request, ValidatorInterface $validator, LoggerInterface $logger, EntityManagerInterface $manager): Response
    {
        
        if($request->isXmlHttpRequest()) {
            
                $enyCompte->setDeletedAt(new DateTime());
                $manager->persist($enyCompte);
                $manager->flush();

                return new Response("Le compte a été supprimé avec succès", Response::HTTP_OK,
                    ['content-type' => 'text/plain']);

        } else {
            return new Response("Operation not allowed", Response::HTTP_BAD_REQUEST,
            ['content-type' => 'text/plain']);
        }        
        
    }

    /**
     * Retourne la liste des comptes créés
     * @Route("api", name="api")
     * @return json
     */
    public function datatable()
    {
        $repo = $this->getDoctrine()->getManager()->getRepository(EnyCompte::class);
        return  $this->json($repo->findBy(["deletedAt" => null], ["createdAt" => "DESC",]), 200, [], ['groups' => 'cpte:read']);
    }
}
