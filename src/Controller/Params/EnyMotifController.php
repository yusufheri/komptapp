<?php

namespace App\Controller\Params;

use App\Entity\EnyMotif;
use Psr\Log\LoggerInterface;
use App\Entity\EnySousRubrique;
use App\Form\EnyMotifType;
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
 * @Route("/admin/motif/", name="admin_motif") 
 */
class EnyMotifController extends AbstractController
{
    /**
     * @Route("", name="_index")
     */
    public function index()
    {
        return $this->render('params/eny_motif/index.html.twig', [
            'controller_name' => 'EnyMotifController',
        ]);
    }

    
    /**
     * @Route("create_form", name="_create_form")
     */
    public function create()
    {
        $motif = new EnyMotif();
        $form = $this->createForm(EnyMotifType::class, $motif);

        return $this->render("params/eny_motif/new.html.twig", [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("{id}/edit_form_motif", name="_edit_form_motif")
     */
    public function editForm(EnyMotif $obj, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(EnyMotifType::class, $obj);

        if($request->isXmlHttpRequest()) 
        {
            return $this->render("params/eny_motif/new.html.twig", [
                "form" => $form->createView(),
                'compte' => $obj
            ]);
        } else {
            return new Response("denied access !!!");
        }
        
    }

    /**
     * @Route("{id}/edit", name="_edit_motif")
     */
    public function editSousRubrique(Request $request, EnyMotif $obj, ValidatorInterface $validator, LoggerInterface $logger, EntityManagerInterface $manager): Response
    {
        //dd($request);
        if($request->isXmlHttpRequest()) {
            
            $eny_compte = $request->request->get('eny_motif');
            $token =$eny_compte["_token"];
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

            $eny_motif = $request->request->get('eny_motif');
            //$token =$eny_motif["_token"];
            $name = $eny_motif["name"];
            $content = $eny_motif["content"];

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
                $motif = new EnyMotif();
                $motif->setName($name);
                $motif->setContent($content);

                
                $manager->persist($motif);
                $manager->flush();

                return new Response("Le nouveau motif a été créé avec succès", Response::HTTP_OK,
                    ['content-type' => 'text/plain']);
            }

        } else {
            return new Response("Operation not allowed", Response::HTTP_BAD_REQUEST,
            ['content-type' => 'text/plain']);
        }        
        
    }

    /**
     * Suppression d'un motif
     * 
     * @Route("{id}/delete", name="_delete")
     */
    public function delete(EnyMotif $enyMotif, Request $request, ValidatorInterface $validator, LoggerInterface $logger, EntityManagerInterface $manager): Response
    {
        
        if($request->isXmlHttpRequest()) {
            
                $enyMotif->setDeletedAt(new \DateTime());
                $manager->persist($enyMotif);
                $manager->flush();

                return new Response("Le motif a été supprimé avec succès", Response::HTTP_OK,
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
        $repo = $this->getDoctrine()->getManager()->getRepository(EnyMotif::class);
        return  $this->json($repo->findBy(["deletedAt" => null], ["createdAt" => "DESC",]), 200, [], ['groups' => 'motif:read']);
    }
}
