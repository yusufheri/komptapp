<?php

namespace App\Controller;

use Exception;
use App\Form\ImportType;
use App\Entity\ImportFiles;
use App\Entity\DetailImport;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ImportFilesRepository;
use App\Repository\DetailImportRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Vich\UploaderBundle\Handler\DownloadHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;

/* use Omines\DataTablesBundle\Adapter\ArrayAdapter;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\DataTableFactory; 
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Symfony\Component\Validator\Constraints\Json;*/

class ImportController extends AbstractController
{
    private $manager;

    private $noFile = '<div class="alert alert-dismissible alert-danger"> 
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <h4 class="alert-heading">Attention !</h4>
                        <p class="mb-0"> Prière de sélectionner un fichier (CSV, XLS, XLSX) </p>                   
                    </div>';

    private $headers = [
        "csv" =>"text/csv",
        "xls" => "application/vnd.ms-excel",
        "xlsx" => "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
    ];

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Route("/import", name="import_index")
     */
    public function index(ImportFilesRepository $importFilesRepository)
    {
        return $this->render('import/index.html.twig', [
            'data' => $importFilesRepository->findAll(),
        ]);
    }

    /**
     * Undocumented function
     * @Route("/import/{id}/datatable", name="datatable")
     * @param ImportFiles $importFile
     */
    public function dataTable(ImportFiles $importFile)
    {
        $repo = $this->getDoctrine()->getManager()->getRepository(DetailImport::class);
        return  $this->json($repo->findBy(['importFile' => $importFile]), 200, [], ['groups' => 'detailImport:read']);
    }

    /**
     * Detail d'un fichier 
     * @Route("/import/{id<\d+>}/details", name="import_detail")
     * @param ImportFilesRepository $importFilesRepository
     * @return Response
     */
    public function detailImport(ImportFiles $importFile)
    {
        return $this->render('import/detailImportation.html.twig', [
            'importFile' => $importFile
        ]);
    }
    

    /**
     * @ROute("/import/preview", name="import_preview")
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
     * Permet d'importer le fichier Excel
     * @Route("/import/import-excel", name="import_excel")
     * @return Response|string
     */
    public function excel(Request $request)
    {
        $data = $request->files->get('import');

        $importFile = new ImportFiles();

        $form = $this->createForm(ImportType::class, $importFile);
        $form->handleRequest($request);
        
        if($form->isSubmitted())
        {
            if($form->isValid())
            {            
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
                        $to = trim($dateFromTo[2]);
                        $form = trim($dateFromTo[3]);
                        
                        $importFile ->setAccountBankName(trim(explode(":",$data[1][0])[1]))
                                    ->setAccountBankNumber(trim(explode(":",$data[0][0])[1]))
                                    ->setToAt(DetailImport::formatDate($to))
                                    ->setFromAt(DetailImport::formatDate($form))
                                    ->setDisplayName($fileName);
                
                        $this->manager->persist($importFile);

                        $counter = 0;
                        foreach($data as $row) {
                            if ($counter > 3) {
                                $detail = new DetailImport($row);
                                $detail->setImportFile($importFile);
                                $this->manager->persist($detail);
                            }
                            $counter ++;
                        }
                        $message = '<div class="alert alert-dismissible alert-success">
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        <h4 class="alert-heading">Félicitations !</h4>
                                        <p class="mb-0">
                                            Le fichier a été importé avec succès :)
                                        </p>                 
                                    </div>
                        ';
                    } else {
                        $message = '<div class="alert alert-dismissible alert-info"> 
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        <h4 class="alert-heading">Attention !</h4>
                                        <p class="mb-0">
                                            Seules les extensions suivantes sont prises en charge (CSV, XLS, XLSX)
                                        </p>                   
                                    </div>';
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
        return $this->render('import/import-excel.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Permet d'importer le fichier CSV
     * @Route("/import/{id}/download/", name="download_file")
     * 
     */
    public function download(DownloadHandler $downloadHandler, ImportFilesRepository $importFilesRepository, ImportFiles $importFile)
    {
        try{
            return $downloadHandler->downloadObject($importFile, 'excelFile', ImportFiles::class, null);
        } catch(Exception $e){
            $array = array (
                'status' => $e->getMessage(),
                'message' => 'Download error' 
            );
            $response = new JsonResponse ( $array, 400 );
            return $response;
        }
    }
}
