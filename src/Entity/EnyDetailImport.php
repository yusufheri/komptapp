<?php

namespace App\Entity;

use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EnyDetailImportRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class EnyDetailImport
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @Groups("detail:read")
     * @Groups("import:read")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("detail:read")
     * @Groups("import:read")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups("detail:read")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups("detail:read")
     */
    private $deletedAt;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("detail:read")
     * @Groups("import:read")
     */
    private $datePaid;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("detail:read")
     * @Groups("import:read")
     */
    private $eventNo;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("detail:read")
     * @Groups("import:read")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("detail:read")
     * @Groups("import:read")
     */
    private $matricule;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("detail:read")
     * @Groups("import:read")
     */
    private $section;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("detail:read")
     * @Groups("import:read")
     */
    private $orientation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("detail:read")
     * @Groups("import:read")
     */
    private $promotion;

    /**
     * @ORM\Column(type="float")
     * @Groups("detail:read")
     * @Groups("import:read")
     */
    private $amount;

    /**
     * @ORM\ManyToOne(targetEntity=Devise::class, inversedBy="enyDetailImports")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("detail:read")
     * @Groups("import:read")
     */
    private $devise;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("detail:read")
     * @Groups("import:read")
     */
    private $sexe;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("detail:read")
     * @Groups("import:read")
     */
    private $categorie;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("detail:read")
     * @Groups("import:read")
     */
    private $tranche;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("detail:read")
     * @Groups("import:read")
     */
    private $motif;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups("detail:read")
     * @Groups("import:read")
     */
    private $error;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("detail:read")
     * @Groups("import:read")
     */
    private $error_message;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups("detail:read")
     * @Groups("import:read")
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity=EnyEtudiant::class, inversedBy="enyDetailImports")
     * @Groups("detail:read")
     */
    private $enyEtudiant;

    /**
     * @ORM\ManyToOne(targetEntity=EnyImport::class, inversedBy="enyDetailImports")
     * @ORM\JoinColumn(nullable=false)
     */
    private $enyImport;

    /**
     * @ORM\ManyToOne(targetEntity=EnyRubrique::class, inversedBy="enyDetailImports")
     */
    private $enyRubrique;

    private $idDevise;

    public function __construct(array $array) {

        $step = 0;
        if (count($array) > 8) {
            $this->matricule    = $array[2];
            $step = 1;
        }

        $section_orientation_promo = explode("/", trim($array[3 + $step])) ;
        $sexe_cat_tranche =  explode("/",trim($array[6 + $step]));

        $this->datePaid         = DetailImport::formatDate(trim($array[0]));
        $this->eventNo          = trim($array[1]);
        $this->name             = trim($array[2 + $step]);
        $this->section          = $section_orientation_promo[0];
        $this->orientation      = $section_orientation_promo[1];
        $this->promotion        = $section_orientation_promo[2];
        $this->amount          = explode(".",trim($array[4 + $step]))[0];
        $this->idDevise           = trim($array[5 + $step]);
        
        $this->motif            = trim($array[7 + $step]);

        $this->sexe = $sexe_cat_tranche[0];
        $this->categorie = $sexe_cat_tranche[1];
        $this->tranche = $sexe_cat_tranche[2];
        
        $this->amount = (float) str_replace([" ", ","], "", $this->amount);
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

    public static function formatDate(string $date)
    {
        $d = explode("/", explode(" ",$date)[0]);
        
        return \DateTime::createFromFormat('Ymd', $d[2].$d[1].$d[0]);
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

    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeInterface $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

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
        return $this->eventNo;
    }

    public function setEventNo(string $eventNo): self
    {
        $this->eventNo = $eventNo;

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

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getDevise(): ?Devise
    {
        return $this->devise;
    }

    public function setDevise(?Devise $devise): self
    {
        $this->devise = $devise;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(?string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(?string $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getTranche(): ?string
    {
        return $this->tranche;
    }

    public function setTranche(?string $tranche): self
    {
        $this->tranche = $tranche;

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
        return $this->error_message;
    }

    public function setErrorMessage(?string $error_message): self
    {
        $this->error_message = $error_message;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getEnyEtudiant(): ?EnyEtudiant
    {
        return $this->enyEtudiant;
    }

    public function setEnyEtudiant(?EnyEtudiant $enyEtudiant): self
    {
        $this->enyEtudiant = $enyEtudiant;

        return $this;
    }

    public function getEnyImport(): ?EnyImport
    {
        return $this->enyImport;
    }

    public function setEnyImport(?EnyImport $enyImport): self
    {
        $this->enyImport = $enyImport;

        return $this;
    }

    public function getEnyRubrique(): ?EnyRubrique
    {
        return $this->enyRubrique;
    }

    public function setEnyRubrique(?EnyRubrique $enyRubrique): self
    {
        $this->enyRubrique = $enyRubrique;

        return $this;
    }

    /**
     * Get the value of idDevise
     */ 
    public function getIdDevise()
    {
        return $this->idDevise;
    }

    /**
     * Set the value of idDevise
     *
     * @return  self
     */ 
    public function setIdDevise($idDevise)
    {
        $this->idDevise = $idDevise;

        return $this;
    }
}
