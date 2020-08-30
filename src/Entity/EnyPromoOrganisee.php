<?php

namespace App\Entity;

use App\Repository\EnyPromoOrganiseeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EnyPromoOrganiseeRepository::class)
 */
class EnyPromoOrganisee
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
    private $datecreate;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $num_eny_departement;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $num_faculte;

    /**
     * @ORM\ManyToOne(targetEntity=EnyEtab::class, inversedBy="enyPromoOrganisees")
     * @ORM\JoinColumn(nullable=false)
     */
    private $num_eny_etab;

    /**
     * @ORM\ManyToOne(targetEntity=EnyPromotion::class, inversedBy="enyPromoOrganisees")
     * @ORM\JoinColumn(nullable=false)
     */
    private $num_eny_promotion;

    /**
     * @ORM\Column(type="integer")
     */
    private $num_eny_annee_acad;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $salle;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deleted;

    private $nameSection;
    private $nameOrientation;

    /**
     * @ORM\OneToMany(targetEntity=EnyInscription::class, mappedBy="num_eny_promo_organisee")
     */
    private $enyInscriptions;

    public function __construct()
    {
        $this->enyInscriptions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatecreate(): ?\DateTimeInterface
    {
        return $this->datecreate;
    }

    public function setDatecreate(\DateTimeInterface $datecreate): self
    {
        $this->datecreate = $datecreate;

        return $this;
    }

    public function getNumEnyDepartement(): ?int
    {
        return $this->num_eny_departement;
    }

    public function setNumEnyDepartement(?int $num_eny_departement): self
    {
        $this->num_eny_departement = $num_eny_departement;

        return $this;
    }

    public function getNumFaculte(): ?int
    {
        return $this->num_faculte;
    }

    public function setNumFaculte(?int $num_faculte): self
    {
        $this->num_faculte = $num_faculte;

        return $this;
    }

    public function getNumEnyEtab(): ?EnyEtab
    {
        return $this->num_eny_etab;
    }

    public function setNumEnyEtab(?EnyEtab $num_eny_etab): self
    {
        $this->num_eny_etab = $num_eny_etab;

        return $this;
    }

    public function getNumEnyPromotion(): ?EnyPromotion
    {
        return $this->num_eny_promotion;
    }

    public function setNumEnyPromotion(?EnyPromotion $num_eny_promotion): self
    {
        $this->num_eny_promotion = $num_eny_promotion;

        return $this;
    }

    public function getNumEnyAnneeAcad(): ?int
    {
        return $this->num_eny_annee_acad;
    }

    public function setNumEnyAnneeAcad(int $num_eny_annee_acad): self
    {
        $this->num_eny_annee_acad = $num_eny_annee_acad;

        return $this;
    }

    public function getSalle(): ?string
    {
        return $this->salle;
    }

    public function setSalle(?string $salle): self
    {
        $this->salle = $salle;

        return $this;
    }

    public function getDeleted(): ?\DateTimeInterface
    {
        return $this->deleted;
    }

    public function setDeleted(?\DateTimeInterface $deleted): self
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * @return Collection|EnyInscription[]
     */
    public function getEnyInscriptions(): Collection
    {
        return $this->enyInscriptions;
    }

    public function addEnyInscription(EnyInscription $enyInscription): self
    {
        if (!$this->enyInscriptions->contains($enyInscription)) {
            $this->enyInscriptions[] = $enyInscription;
            $enyInscription->setNumEnyPromoOrganisee($this);
        }

        return $this;
    }

    public function removeEnyInscription(EnyInscription $enyInscription): self
    {
        if ($this->enyInscriptions->contains($enyInscription)) {
            $this->enyInscriptions->removeElement($enyInscription);
            // set the owning side to null (unless already changed)
            if ($enyInscription->getNumEnyPromoOrganisee() === $this) {
                $enyInscription->setNumEnyPromoOrganisee(null);
            }
        }

        return $this;
    }

    /**
     * Get the value of nameSection
     */ 
    public function getNameSection()
    {
        return $this->nameSection;
    }

    /**
     * Set the value of nameSection
     *
     * @return  self
     */ 
    public function setNameSection($nameSection)
    {
        $this->nameSection = $nameSection;

        return $this;
    }

    /**
     * Get the value of nameOrientation
     */ 
    public function getNameOrientation()
    {
        return $this->nameOrientation;
    }

    /**
     * Set the value of nameOrientation
     *
     * @return  self
     */ 
    public function setNameOrientation($nameOrientation)
    {
        $this->nameOrientation = $nameOrientation;

        return $this;
    }
}
