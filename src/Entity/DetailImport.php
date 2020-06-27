<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\DetailImportRepository;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=DetailImportRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class DetailImport
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("detailImport:read")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     * 
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("detailImport:read")
     */
    private $datePaid;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("detailImport:read")
     */
    private $event_no;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("detailImport:read")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("detailImport:read")
     */
    private $matricule;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("detailImport:read")
     */
    private $section;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("detailImport:read")
     */
    private $orientation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("detailImport:read")
     */
    private $promotion;

    /**
     * @ORM\Column(type="float")
     * @Groups("detailImport:read")
     */
    private $montant;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("detailImport:read")
     */
    private $devise;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("detailImport:read")
     */
    private $sexe_cat_tranche;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("detailImport:read")
     */
    private $motif;

    /**
     * @ORM\ManyToOne(targetEntity=ImportFiles::class, inversedBy="detailImports")
     * @ORM\JoinColumn(nullable=false)
     */
    private $importFile;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups("detailImport:read")
     */
    private $error;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("detailImport:read")
     */
    private $errorMessage;

    public static function formatDate(string $date)
    {
        $d = explode("/", explode(" ",$date)[0]);
        
        return \DateTime::createFromFormat('Ymd', $d[2].$d[1].$d[0]);
    }

    public function __construct(array $array) {

        $step = 0;
        if (count($array) > 8) {
            $this->matricule    = $array[2];
            $step = 1;
        }

        $section_orientation_promo = explode("/", trim($array[3 + $step])) ;

        $this->datePaid         = DetailImport::formatDate(trim($array[0]));
        $this->event_no         = trim($array[1]);
        $this->name             = trim($array[2 + $step]);
        $this->section          = $section_orientation_promo[0];
        $this->orientation      = $section_orientation_promo[1];
        $this->promotion        = $section_orientation_promo[2];
        $this->montant          = explode(".",trim($array[4 + $step]))[0];
        $this->devise           = trim($array[5 + $step]);
        $this->sexe_cat_tranche = trim($array[6 + $step]);
        $this->motif            = trim($array[7 + $step]);
        
        $this->montant = (float) str_replace([" ", ","], "", $this->montant);
        //dd($th)
    }

    /**
     * @ORM\PrePersist
     *
     * @return void
     */
    public function setCreatedAtValue() {
        $date = new \DateTime();
        $this->createdAt = $date;       
    }

    /**
     * @ORM\PrePersist
     *
     * @return void
     */
    public function setErrorBeforePersist() {
        if (empty($this->event_no) || empty($this->name) || empty($this->montant) || empty($this->devise) || empty($this->motif)) {
            $this->error = true;
            $this->errorMessage = "Il y a des cellules vides sur cette ligne";
        } else {
            if(!is_numeric($this->montant)){
                $this->error = true;
                $this->errorMessage = "La colonne Montant ne peut contenir que les valeurs entières";
            }
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getDatePaid(): ?\DateTimeInterface
    {
        return $this->datePaid;
    }

    public function setDatePaid(\DateTimeInterface $datePaid): self
    {
        $this->datePaid = $datePaid;

        return $this;
    }

    public function getEventNo(): ?string
    {
        return $this->event_no;
    }

    public function setEventNo(string $event_no): self
    {
        $this->event_no = $event_no;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(?string $matricule): self
    {
        $this->matricule = $matricule;

        return $this;
    }

    public function getSection(): ?string
    {
        return $this->section;
    }

    public function setSection(string $section): self
    {
        $this->section = $section;

        return $this;
    }

    public function getOrientation(): ?string
    {
        return $this->orientation;
    }

    public function setOrientation(?string $orientation): self
    {
        $this->orientation = $orientation;

        return $this;
    }

    public function getPromotion(): ?string
    {
        return $this->promotion;
    }

    public function setPromotion(?string $promotion): self
    {
        $this->promotion = $promotion;

        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getDevise(): ?string
    {
        return $this->devise;
    }

    public function setDevise(string $devise): self
    {
        $this->devise = $devise;

        return $this;
    }

    public function getSexeCatTranche(): ?string
    {
        return $this->sexe_cat_tranche;
    }

    public function setSexeCatTranche(string $sexe_cat_tranche): self
    {
        $this->sexe_cat_tranche = $sexe_cat_tranche;

        return $this;
    }

    public function getMotif(): ?string
    {
        return $this->motif;
    }

    public function setMotif(string $motif): self
    {
        $this->motif = $motif;

        return $this;
    }

    public function getImportFile(): ?ImportFiles
    {
        return $this->importFile;
    }

    public function setImportFile(?ImportFiles $importFile): self
    {
        $this->importFile = $importFile;

        return $this;
    }

    public function getError(): ?bool
    {
        return $this->error;
    }

    public function setError(?bool $error): self
    {
        $this->error = $error;

        return $this;
    }

    public function getErrorMessage(): ?string
    {
        return $this->errorMessage;
    }

    public function setErrorMessage(?string $errorMessage): self
    {
        $this->errorMessage = $errorMessage;

        return $this;
    }
}
