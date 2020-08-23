<?php

namespace App\Controller\Admin;

use App\Entity\Compte;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/compte/", name="admin_compte") 
 */
class CompteController extends AbstractController
{
    /**
     * @Route("", name="")
     */
    public function index()
    {
        return $this->render('admin/compte/index.html.twig', [
            'controller_name' => 'CompteController',
        ]);
    }

    /**
     * @Route("new", name="_create")
     */
    public function new(Request $request, ValidatorInterface $validator, 
    LoggerInterface $logger, EntityManagerInterface $manager): Response
    {
        
        if($request->isXmlHttpRequest()) {
            

            $token = $request->request->get("token");
            
            if (!$this->isCsrfTokenValid('security', $token)) {

                $logger->info("CSRF failure");

                return new Response("Operation not allowed", Response::HTTP_OK,
                    ['content-type' => 'text/plain']);
            }

            $code = $request->request->get("code");
            $name = $request->request->get("name");
            $content = $request->request->get("content");

            $input = ['code' => $code, 'name' => $name];

            $constraints = new Assert\Collection([
                'code' => [new Assert\Length(['min' => 2]), new Assert\NotBlank],
                'name' => [new Assert\notBlank],
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
                $compte = new Compte();

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
     * Retourne la liste des comptes créés
     * @Route("api", name="api")
     * @return json
     */
    public function datatable()
    {
        $repo = $this->getDoctrine()->getManager()->getRepository(Compte::class);
        return  $this->json($repo->findBy(["deletedAt" => null], ["createdAt" => "DESC"]), 200, [], ['groups' => 'compte:read']);
    }
}
