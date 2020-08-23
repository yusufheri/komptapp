<?php

namespace App\Controller\Admin;

use App\Entity\Compte;
use App\Entity\SousRubrique;
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
 * @Route("/admin/sous-rubrique/", name="admin_sous_rubrique") 
 */
class SousRubriqueController extends AbstractController
{
    
    /**
     * @Route("", name="")
     */
    public function index()
    {
        return $this->render('admin/sous_rubrique/index.html.twig', [
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
            
            dump($request);

            $token = $request->request->get("token");
            
            if (!$this->isCsrfTokenValid('security', $token)) {

                $logger->info("CSRF failure");

                return new Response("Operation not allowed", Response::HTTP_OK,
                    ['content-type' => 'text/plain']);
            }

            $code = $request->request->get("code");
            $name = $request->request->get("name");
            $content = $request->request->get("content");

            $input = ['code' => trim($code), 'name' => trim($name)];

            $constraints = new Assert\Collection([
                'code' => [new Assert\Length(['min' => 2]), new Assert\NotBlank],
                'name' => [new Assert\Length(['min' => 5]), new Assert\notBlank]
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
                $sous_rubrique = new SousRubrique();

                $sous_rubrique->setCode($code);
                $sous_rubrique->setName($name);
                $sous_rubrique->setContent($content);

                $manager->persist($sous_rubrique);
                $manager->flush();

                return new Response("La nouvelle sous-rubrique a été créée avec succès", Response::HTTP_OK,
                    ['content-type' => 'text/plain']);
            }

        } else {
            return new Response("Operation not allowed", Response::HTTP_BAD_REQUEST,
            ['content-type' => 'text/plain']);
        }        
        
    }

    /**
     * Retourne la liste des sous rubriques créés
     * @Route("api", name="api")
     * @return json
     */
    public function datatable()
    {
        $repo = $this->getDoctrine()->getManager()->getRepository(SousRubrique::class);
        return  $this->json($repo->findBy(["deletedAt" => null], ["createdAt" => "DESC"]), 200, [], ['groups' => 'rubrique:read']);
    }

    
}
