<?php

namespace App\Controller\Params;

use App\Entity\EnyCompte;
use Psr\Log\LoggerInterface;
use App\Entity\EnySousRubrique;
use App\Entity\SousRubrique;
use App\Form\EnySousRubriqueType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/srubrique/", name="admin_srubrique") 
 */
class EnySousRubriqueController extends AbstractController
{
    /**
     * @Route("", name="_index")
     */
    public function index()
    {
        return $this->render('params/eny_sous_rubrique/index.html.twig', [
            'controller_name' => 'EnySousRubriqueController',
        ]);
    }

    /**
     * @Route("create_form", name="_create_form")
     */
    public function create()
    {
        $cpte = new EnySousRubrique();
        $form = $this->createForm(EnySousRubriqueType::class, $cpte);

        /*$form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            return new Response("Success", 200);
        }*/

        return $this->render("params/partials/new.html.twig", [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("{id}/edit_form", name="_edit_form")
     */
    public function editForm(EnySousRubrique $obj, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(EnySousRubriqueType::class, $obj);
        /*
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($obj);
            $manager->flush();
            return $this->redirectToRoute("admin_srubrique_index");
        }*/

        if($request->isXmlHttpRequest()) 
        {
            return $this->render("params/partials/new.html.twig", [
                "form" => $form->createView(),
                'compte' => $obj
            ]);
        } else {
            return new Response("denied access !!!");
        }
        
    }

    /**
     * @Route("{id}/edit_sous_rubrique", name="_edit_sous_rubrique")
     */
    public function editSousRubrique(Request $request, EnySousRubrique $obj, ValidatorInterface $validator, LoggerInterface $logger, EntityManagerInterface $manager): Response
    {
        //dd($request);
        if($request->isXmlHttpRequest()) {
            
            $eny_compte = $request->request->get('eny_sous_rubrique');
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
                
                $obj->setCode($code);
                $obj->setName($name);
                $obj->setContent($content);
                //dd($enyCompte);
                $manager->persist($obj);
                $manager->flush();

                return new Response("La sous rubrique a été modifiée avec succès", Response::HTTP_OK,
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
            
            $eny_compte = $request->request->get('eny_sous_rubrique');
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
                $compte = new EnySousRubrique();
                $compte->setCode($code);
                $compte->setName($name);
                $compte->setContent($content);

                
                $manager->persist($compte);
                $manager->flush();

                return new Response("La nouvelle sous rubrique a été créée avec succès", Response::HTTP_OK,
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
    public function delete(EnySousRubrique $enyCompte,Request $request, ValidatorInterface $validator, LoggerInterface $logger, EntityManagerInterface $manager): Response
    {
        
        if($request->isXmlHttpRequest()) {
            
                $enyCompte->setDeletedAt(new \DateTime());
                $manager->persist($enyCompte);
                $manager->flush();

                return new Response("La sous rubrique a été supprimée avec succès", Response::HTTP_OK,
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
        $repo = $this->getDoctrine()->getManager()->getRepository(EnySousRubrique::class);
        return  $this->json($repo->findBy(["deletedAt" => null], ["createdAt" => "DESC",]), 200, [], ['groups' => 'cpte:read']);
    }
}
