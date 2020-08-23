<?php

namespace App\Entity;

use App\Repository\EnyDetailImportRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EnyDetailImportRepository::class)
 */
class EnyDetailImport
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $datePaid;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $eventNo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $matricule;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $section;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $orientation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $promotion;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * @ORM\ManyToOne(targetEntity=Devise::class, inversedBy="enyDetailImports")
     * @ORM\JoinColumn(nullable=false)
     */
    private $devise;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sexe;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $categorie;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tranche;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $motif;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $error;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $error_message;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity=EnyEtudiant::class, inversedBy="enyDetailImports")
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
}
