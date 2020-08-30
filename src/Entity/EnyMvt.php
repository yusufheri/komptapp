<?php

namespace App\Entity;

use App\Repository\EnyMvtRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EnyMvtRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class EnyMvt
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
     * @ORM\ManyToOne(targetEntity=EnyRubrique::class, inversedBy="enyMvts")
     * @ORM\JoinColumn(nullable=true)
     */
    private $rubrique;

    /**
     * @ORM\ManyToOne(targetEntity=EnyInscription::class, inversedBy="enyMvts")
     * @ORM\JoinColumn(nullable=true)
     */
    private $student;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $idEtudiant;

    /**
     * @ORM\ManyToOne(targetEntity=EnyRubriqueCpt::class, inversedBy="enyMvts")
     */
    private $compte;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\OneToMany(targetEntity=EnyDispatch::class, mappedBy="mvt")
     */
    private $enyDispatches;

    /**
     * @ORM\ManyToOne(targetEntity=EnyImport::class, inversedBy="enyMvts")
     */
    private $import;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $error;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $success;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $error_message;

    /**
     * @ORM\Column(type="datetime")
     */
    private $paidAt;

    /**
     * @ORM\ManyToOne(targetEntity=EnyTypeMvt::class, inversedBy="enyMvts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $typeMvt;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * @ORM\ManyToOne(targetEntity=Devise::class, inversedBy="enyMvts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $devise;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $amount_letter;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $fromBank;

    public function __construct()
    {
        $this->enyDispatches = new ArrayCollection();
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

    public function getRubrique(): ?EnyRubrique
    {
        return $this->rubrique;
    }

    public function setRubrique(?EnyRubrique $rubrique): self
    {
        $this->rubrique = $rubrique;

        return $this;
    }

    public function getStudent(): ?EnyInscription
    {
        return $this->student;
    }

    public function setStudent(?EnyInscription $student): self
    {
        $this->student = $student;

        return $this;
    }

    public function getIdEtudiant(): ?string
    {
        return $this->idEtudiant;
    }

    public function setIdEtudiant(string $idEtudiant): self
    {
        $this->idEtudiant = $idEtudiant;

        return $this;
    }

    public function getCompte(): ?EnyRubriqueCpt
    {
        return $this->compte;
    }

    public function setCompte(?EnyRubriqueCpt $compte): self
    {
        $this->compte = $compte;

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

    /**
     * @return Collection|EnyDispatch[]
     */
    public function getEnyDispatches(): Collection
    {
        return $this->enyDispatches;
    }

    public function addEnyDispatch(EnyDispatch $enyDispatch): self
    {
        if (!$this->enyDispatches->contains($enyDispatch)) {
            $this->enyDispatches[] = $enyDispatch;
            $enyDispatch->setMvt($this);
        }

        return $this;
    }

    public function removeEnyDispatch(EnyDispatch $enyDispatch): self
    {
        if ($this->enyDispatches->contains($enyDispatch)) {
            $this->enyDispatches->removeElement($enyDispatch);
            // set the owning side to null (unless already changed)
            if ($enyDispatch->getMvt() === $this) {
                $enyDispatch->setMvt(null);
            }
        }

        return $this;
    }

    public function getImport(): ?EnyImport
    {
        return $this->import;
    }

    public function setImport(?EnyImport $import): self
    {
        $this->import = $import;

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

    public function getSuccess(): ?bool
    {
        return $this->success;
    }

    public function setSuccess(?bool $success): self
    {
        $this->success = $success;

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

    public function getPaidAt(): ?\DateTimeInterface
    {
        return $this->paidAt;
    }

    public function setPaidAt(\DateTimeInterface $paidAt): self
    {
        $this->paidAt = $paidAt;

        return $this;
    }

    public function getTypeMvt(): ?EnyTypeMvt
    {
        return $this->typeMvt;
    }

    public function setTypeMvt(?EnyTypeMvt $typeMvt): self
    {
        $this->typeMvt = $typeMvt;

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

    public function getAmountLetter(): ?string
    {
        return $this->amount_letter;
    }

    public function setAmountLetter(string $amount_letter): self
    {
        $this->amount_letter = $amount_letter;

        return $this;
    }

    public function getFromBank(): ?bool
    {
        return $this->fromBank;
    }

    public function setFromBank(?bool $fromBank): self
    {
        $this->fromBank = $fromBank;

        return $this;
    }

    public function getEtudiant():?string
    {
        return (!is_null($this->student)) ? $this->getStudent()->getNumEnyEtudiant()->getNames(): null;
        
    }
}
