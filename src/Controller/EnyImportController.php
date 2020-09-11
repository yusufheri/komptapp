<?php

namespace App\Controller;

use Exception;
use App\Entity\Devise;
use App\Entity\EnyMvt;
use App\Form\ImportType;
use App\Entity\EnyImport;
use App\Entity\EnySection;
use App\Entity\EnyTypeMvt;
use App\Entity\EnyDispatch;
use App\Entity\EnyEtudiant;
use App\Entity\EnyRubrique;
use App\Form\EnyImportType;
use App\Entity\DetailImport;
use App\Entity\EnyAnneeAcad;
use App\Entity\EnyPromotion;
use App\Entity\EnyBankingInfo;
use App\Entity\EnyDepartement;
use App\Entity\EnyInscription;
use App\Entity\EnyRubriqueCpt;
use App\Entity\EnyDetailImport;
use App\Entity\EnyPromoOrganisee;
use App\Entity\EnyTranche;
use App\Repository\EnyImportRepository;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\EnyEtudiantRepository;
use App\Repository\EnyRubriqueRepository;
use App\Repository\EnyBankingInfoRepository;
use App\Repository\EnyDetailImportRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Vich\UploaderBundle\Handler\DownloadHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

/**
 * @Route("/importation/", name="admin_importation")
 */
class EnyImportController extends AbstractController
{
    private $manager;

    private $numberAccountNotAvailable = '<div class="alert alert-dismissible alert-danger"> 
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <h4 class="alert-heading">Attention !</h4>
                        <p class="mb-0"> Le numéro de compte rattaché à ce fichier ne correspond à aucun numéro de compte enregistré </p>                   
                    </div>';
    private $noFile = '<div class="alert alert-dismissible alert-danger"> 
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <h4 class="alert-heading">Attention !</h4>
                        <p class="mb-0"> Prière de sélectionner un fichier (CSV, XLS, XLSX) </p>                   
                    </div>';
    private $message01 = '<div class="alert alert-dismissible alert-success">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <h4 class="alert-heading">Félicitations !</h4>
                            <p class="mb-0">
                                Le fichier a été importé avec succès :)
                            </p>                 
                        </div>';
    private $message02 = '<div class="alert alert-dismissible alert-info"> 
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <h4 class="alert-heading">Attention !</h4>
                            <p class="mb-0">
                                Seules les extensions suivantes sont prises en charge (CSV, XLS, XLSX)
                            </p>                   
                        </div>';
    private $message03 = '<div class="alert alert-dismissible alert-success">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <h4 class="alert-heading">Félicitations !</h4>
                            <p class="mb-0">
                                Le fichier a été importé avec succès :)
                            </p>                 
                        </div>';
    private $message04 = '<div class="alert alert-dismissible alert-info"> 0
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <h4 class="alert-heading">Attention !</h4>
                            <p class="mb-0">
                                Seules les extensions suivantes sont prises en charge (CSV, XLS, XLSX)
                            </p>                   
                        </div>';    
    /**
     * Constructeur de la classe
     *
     * @param EntityManagerInterface $manager
     */
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Route("", name="_index")
     */
    public function index()
    {
        return $this->render('eny_import/index.html.twig', [
            'controller_name' => 'EnyImportController',
        ]);
    }

    /**
     * Detaillez le contenu d'un fichier  excel
     * @Route("{id<\d+>}/view", name="_detail")
     * @param EnyImport $importFile
     * @return Response
     */
    public function view(EnyImport $importFile)
    {
        return $this->render('eny_import/detailImportation.html.twig', [
            'importFile' => $importFile
        ]);
    }

    /**
     * Permet d'importer le fichier Excel dans la base de données
     * @Route("new", name="_new")
     * @return Response|string
     */
    public function new_single_file(Request $request, EnyBankingInfoRepository $enyBankingInfoRepository, 
                                    EnyRubriqueRepository $enyRubriqueRepository, 
                                    EnyEtudiantRepository $enyEtudiantRepository)
    {
        $data = $request->files->get('eny_import');

        $importFile = new EnyImport();

        $form = $this->createForm(EnyImportType::class, $importFile);
        $form->handleRequest($request);
        
        if($form->isSubmitted())
        {
            if($form->isValid())
            {            
                $rubriques = $enyRubriqueRepository->findBy(["deletedAt" => null]);
                $etudiants = $enyEtudiantRepository->findBy(["deletedAt" => null]);
                $file = $data['excelFile']; 

                if(is_null($file)) return new Response($this->noFile);                

                $fileName = $file->getClientOriginalName();
                $fileExtension = $file->getClientOriginalExtension(); 
                $inputFileName = $file->getRealPath();
                $size = $file->getSize(); 

                if( $fileName!= '') {
                    $allowed_extension = array('csv', 'xls', 'xlsx');

                    if(in_array($fileExtension, $allowed_extension))
                    {

                        $file_Type = IOFactory::identify($inputFileName);
                        $reader = IOFactory::createReader($file_Type);
                        $spreadsheet = $reader->load($inputFileName);
                        $data = $spreadsheet->getActiveSheet()->toArray();

                        $dateFromTo = explode(":", $data[2][0]);
                        $to = trim($dateFromTo[3]);
                        $form = trim($dateFromTo[2]);
                        
                        /** Permet de retrouver le numéro du cpte bancaire associé à ce fichier*/
                        $account_number = trim(trim(trim(explode(":",$data[0][0])[1], '-CDF'),'-USD'));
                        
                        $bankingInfos = $enyBankingInfoRepository->findBy(["account_number" => $account_number]);
                        
                        if(count($bankingInfos) < 1) {
                            return new Response($this->numberAccountNotAvailable);
                        }

                        $importFile //->setAccountBankName(trim(explode(":",$data[1][0])[1]))
                                    //->setAccountBankNumber(trim(explode(":",$data[0][0])[1]))
                                    ->setToAt(EnyDetailImport::formatDate($to))
                                    ->setFromAt(EnyDetailImport::formatDate($form))
                                    ->setFilesize($size)
                                    ->setRows(count($data) - 4)
                                    ->setDisplayName($fileName)
                                    ->setBankInfo($bankingInfos[0]);

                        $this->manager->persist($importFile);

                        $counter = 0;
                        foreach($data as $row) {
                            if ($counter > 3) {

                                $detail = new EnyDetailImport($row);

                                $rubrique = $this->getRubrique($rubriques, trim($detail->getMotif()), $detail->getCategorie(), $detail->getPromotion(), $detail->getSection());
                                $etudiant = $this->getEtudiant($etudiants,$detail->getName());
                                $devise = $this->getDoctrine()->getManager()->getRepository(Devise::class)->findBy(["name" => $detail->getIdDevise()])[0];
                                $inscription = $this->getIdInscription($etudiants, $detail->getName(), $detail->getMotif(), $detail->getPromotion(), $detail->getSection(), $detail->getOrientation());
                                
                                //dump($etudiant);
                                //dump($rubrique);

                                $mvt = new EnyMvt();
                                $mvt->setDetailImport($detail);
                                $mvt->setRubrique($rubrique);
                                $mvt->setIdEtudiant((is_null($etudiant))?'': $etudiant->getId());
                                $mvt->setPaidAt($detail->getDatePaid());
                                $mvt->setTypeMvt($this->getDoctrine()->getManager()->getRepository(EnyTypeMvt::class)->find(1));
                                $mvt->setDevise($devise);
                                $mvt->setAmount($detail->getAmount());
                                $mvt->setAmountLetter(base64_encode($detail->getAmount()));
                                $mvt->setFromBank(true);
                                $mvt->setStudent($inscription);
                                $mvt->setTranche($this->getDoctrine()->getManager()->getRepository(EnyTranche::class)->find($detail->getTranche()));;                               
                                
                                if (is_null($rubrique) && is_null($inscription))
                                {
                                    $mvt->setError(true);
                                    $mvt->setErrorMessage("Le nom et le motif attachés à cette opération sont introuvables");
                                } else if (is_null($rubrique) && ! (is_null($inscription)))
                                {
                                    $mvt->setError(true);
                                    $mvt->setErrorMessage("Le motif attaché avec cette information n'est pas trouvé dans la base de données");
                                } else if (!is_null($rubrique) &&  (is_null($inscription)))
                                {
                                    $mvt->setError(true);
                                    $mvt->setErrorMessage("Le nom de l'étudiant ne correspond à aucun nom dans la base de données");
                                } else {
                                    $mvt->setSuccess(true);
                                }
                                
                                $detail->setEnyImport($importFile);
                                $detail->setDevise($devise);
                                $detail->setEnyRubrique($rubrique);
                                $detail->setEnyEtudiant((is_null($etudiant))? ( (is_null($inscription))? $etudiant : $inscription->getNumEnyEtudiant() )  : $etudiant);
                                
                                if (is_null($mvt->getManual())) $mvt->setManual(false);
                                $this->manager->persist($mvt);
                                $this->manager->persist($detail);

                            }
                            $counter ++;
                        }
                        $message = $this->message03;
                    } else {
                        $message = $this->message04;
                    }

                } else {
                    $message = $this->noFile;
                }
                $this->manager->flush();
            } else {    
                $errors = "";
                foreach ($form->getErrors(true, true) as $error) { $errors = $error->getMessage()."<br>";}            
                $message = '
                    <div class="alert alert-dismissible alert-warning"> 
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <h4 class="alert-heading">Attention !</h4><p class="mb-0">'.$errors.'</p>                   
                    </div>';
            }
            return new Response($message);
        }
        return $this->render('eny_import/import-excel.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Permet de téléverser plusieurs fichiers sumultanément
     * @Route("upload-multi-files", name="_multi_files")
     * @return Response
     */
    public function new_multi_files()
    {
        return $this->render('eny_import/upload-multi-files.html.twig', [
        
        ]);
    }

    /**
     * @ROute("preview", name="_preview")
     */
    public function preview(Request $request)
    {
        if($request->isXmlHttpRequest()) {

            $file = $request->files->get("excelFile");

            if(is_null($file)) return new Response($this->noFile);

            $fileName = $file->getClientOriginalName();
            $fileExtension = $file->getClientOriginalExtension(); 
            $inputFileName = $file->getRealPath();

            if( $fileName!= '') {
                $allowed_extension = array('csv', 'xls', 'xlsx');

                if(in_array($fileExtension, $allowed_extension))
                {
                    $file_Type = IOFactory::identify($inputFileName);
                    $reader = IOFactory::createReader($file_Type);

                    //$reader = IOFactory::createReader('Csv');                
                    $spreadsheet = $reader->load($inputFileName);
                    $write = IOFactory::createWriter($spreadsheet, 'Html');
                    $message = $write->save('php://output');
                } else {
                    $message = '<div class="alert alert-dismissible alert-danger">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <h4 class="alert-heading">Attention !</h4>
                                    Seules les extensions suivantes sont prises en charge (CSV, XLS, XLSX)
                                </div>';
                }

            } else {
                $message = $this->noFile;
            }
        }

        return new Response($message);
    }

    /**
     * Téléverserment des fichiers via Ajax
     *
     * @Route("ajax_file_upload_handler", name="ajax_file_upload_handler")
     * @return Response|string
     */
    public function files_ajax(Request $request)
    {
        
        $file = $request->files->get("file");

        $importFile = new EnyImport();

        if(is_null($file)) return new Response($this->noFile);                

        $fileName = $file->getClientOriginalName();
        $fileExtension = $file->getClientOriginalExtension(); 
        $inputFileName = $file->getRealPath();
        $size = $file->getSize(); 

        if( $fileName!= '') {
            $allowed_extension = array('csv', 'xls', 'xlsx');

            if(in_array($fileExtension, $allowed_extension))
            {

                $file_Type = IOFactory::identify($inputFileName);
                $reader = IOFactory::createReader($file_Type);
                $spreadsheet = $reader->load($inputFileName);
                $data = $spreadsheet->getActiveSheet()->toArray();

                $newFileName = uniqid("multi_").".".$fileExtension;

                $dateFromTo = explode(":", $data[2][0]);
                $to = trim($dateFromTo[3]);
                $form = trim($dateFromTo[2]);
                
                $importFile //->setAccountBankName(trim(explode(":",$data[1][0])[1]))
                            //->setAccountBankNumber(trim(explode(":",$data[0][0])[1]))
                            //->setToAt(DetailImport::formatDate($to))
                            //->setFromAt(DetailImport::formatDate($form))
                            ->setDisplayName($fileName)
                            ->setFilename($newFileName)
                            ->setFilesize($size);
        
                $this->manager->persist($importFile);

                $counter = 0;
                foreach($data as $row) {
                    if ($counter > 3) {
                        $detail = new EnyDetailImport($row);
                        $detail->setEnyImport($importFile);
                        $this->manager->persist($detail);
                    }
                    $counter ++;
                }

                try {
                    $file->move(
                        $this->getParameter('multi_uploads_files'),
                        $newFileName
                    );
                } catch (FileException $e) {
                    return new Response($e->getMessage());
                }

                $message = $this->message01;
                
            } else {
                $message = $this->message02;
            }

        } else {
            $message = $this->noFile;
        }
        $this->manager->flush();

        return new Response($message);
    }

    /**
     * Permet d'exporter le fichier CSV
     * @Route("{id}/download/", name="_download")
     * 
     */
    public function download(DownloadHandler $downloadHandler,  EnyImport $importFile)
    {
        try{
            return $downloadHandler->downloadObject($importFile, 'excelFile', EnyImport::class, null);
        } catch(Exception $e){
            $array = array (
                'status' => $e->getMessage(),
                'message' => 'Download error' 
            );
            $response = new JsonResponse ( $array, 400 );
            return $response;
        }
    }

    /**
     * retourner tous les fichiers importés 
     * @Route("api/datatable", name="datatableFilesUploaded")
     * @param ImportFiles $importFile
     */
    public function dataTableFiles(EnyImportRepository $repo)
    {
        return  $this->json($repo->findBy([], ["createdAt" => "DESC"]), 200, [], ['groups' => 'import:read']);
    }

    /**
     * Retourner toutes les lignes du fichier passé en argument
     * @Route("api/{id}/datatable", name="datatable")
     * @param ImportFiles $importFile
     */
    public function dataTable(EnyImport $importFile, EnyDetailImportRepository $repo)
    {
        //$repo = $this->getDoctrine()->getManager()->getRepository(EnyDetailImport::class);
        return  $this->json($repo->findBy(['enyImport' => $importFile]), 200, [], ['groups' => 'detail:read']);
    }

    /**
     * Undocumented function
     *
     * @param EnyRubrique[] $rubriques
     * @param string $motif
     * @return EnyRubrique|null
     */
    public function getRubrique($rubriques, string $motif, string $categorie, string $promotion , string $section):?EnyRubrique
    {
        for ($i=0; $i < count($rubriques); $i++) { 
            $rubrique = $rubriques[$i];
            foreach ($rubrique->getMotifs() as $key => $objMotif) {
                if (trim($objMotif->getName()) == $motif) 
                {
                    //dump("Externe : " . $categorie);
                    if ((!$rubrique->getClasseMontante() && !$rubrique->getClasseRecrutement()) || 
                    ($rubrique->getClasseMontante() && $categorie == 2 && $promotion != 'G1') || 
                    ($rubrique->getClasseRecrutement() && $categorie == 1 && ($promotion == 'G1' || $promotion == 'L1' || ($promotion =='G2' && $section =='SI')) )) {
                        //dump($categorie);
                        return $rubriques[$i];
                    }
                    
                }
            }
        }        
        return null;
    }

    public function getEtudiant(array $etudiants, string $names): ?EnyEtudiant
    {
        $tab = explode(" ", $names);
    
        $nom = (count($tab) > 0) ? $tab[0]: '';
        $postnom =  (count($tab) > 1) ? $tab[1]: '';
        $prenom = (count($tab) > 2) ? $tab[2]: '';

        $studentFind = [];

        foreach ($etudiants as $key => $etudiant) {
            if (
                ($etudiant->getNom() == trim($nom) && $etudiant->getPostnom() == trim($postnom) ) || 
                ($etudiant->getNom() == trim($nom) && $etudiant->getPostnom() == trim($postnom) && $etudiant->getPrenom() == trim($prenom)))
            {
                $studentFind [] = $etudiant;
            }
        }

        $count = count($studentFind);
        if ($count == 1) {
            return $studentFind[0];
        } else if  (count($studentFind) > 1) {
            //dump("Etudiant : " . $count);
        }
        return null;
    }

    public function getIdInscription(array $etudiants, string $names, string $motif, string $promotion, string $section, string $orientation):?EnyInscription
    {
        $manager = $this->getDoctrine()->getManager();

        $motifs = explode(" ", trim($motif));
        $motif = (count($motifs) == 3)?$motifs[2]:null;

        $fac = $manager->getRepository(EnySection::class)->findOneBy(["code" => $section]);
        $dept = $manager->getRepository(EnyDepartement::class)->findOneBy(["code" => $orientation]);
        $promo = $manager->getRepository(EnyPromotion::class)->findOneBy(["lib" => $promotion]);
        $anneeAcad = $manager->getRepository(EnyAnneeAcad::class)->findOneBy(["lib" => $motif]) ;

        $promo_organisee = $manager ->getRepository(EnyPromoOrganisee::class)
                                    ->findOneBy([
                                        "num_eny_promotion" => $promo,
                                        "num_faculte" => $fac->getId(),
                                        "num_eny_departement" => (is_null($dept))?0:$dept->getId(),
                                        "num_eny_annee_acad" =>  (is_null($anneeAcad))?null:$anneeAcad->getId(),
                                        ]);
        
        //dump($promo_organisee);

        if ($promo_organisee instanceof EnyPromoOrganisee)
        {
            $tab = explode(" ", $names);
    
            $nom = (count($tab) > 0) ? $tab[0]: '';
            $postnom =  (count($tab) > 1) ? $tab[1]: '';
            $prenom = (count($tab) > 2) ? $tab[2]: '';

            $inscriptions = [];
            foreach ($etudiants as $key => $etudiant) {
                if (
                    ($etudiant->getNom() == trim($nom) && $etudiant->getPostnom() == trim($postnom) ) || 
                    ($etudiant->getNom() == trim($nom) && $etudiant->getPostnom() == trim($postnom) && $etudiant->getPrenom() == trim($prenom)))
                {
                    $inscription = $manager->getRepository(EnyInscription::class)->findOneBy([
                        "num_eny_promo_organisee" => $promo_organisee,
                        "num_eny_etudiant" => $etudiant
                    ]);
                    $inscriptions [] = $inscription;
                }
            }
            $count = count($inscriptions);
            if ( $count == 1)
            {
                return $inscriptions[0];
            } else if ($count > 1){
                //dump("Inscription : ".$count);
            }
        }
        
        return null;
    }
}
