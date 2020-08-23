<?php

namespace App\Entity;

use App\Repository\EnyInscriptionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EnyInscriptionRepository::class)
 */
class EnyInscription
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=EnypromoOrganisee::class, inversedBy="enyInscriptions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $num_eny_promo_organisee;

    /**
     * @ORM\ManyToOne(targetEntity=EnyAnneeAcad::class, inversedBy="enyInscriptions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $num_eny_annee_acad;

    /**
     * @ORM\ManyToOne(targetEntity=EnyEtudiant::class, inversedBy="enyInscriptions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $num_eny_etudiant;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $num;

    /**
     * @ORM\Column(type="datetime")
     */
    private $datecreate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deleted;

    /**
     * @ORM\ManyToOne(targetEntity=EnyEtab::class, inversedBy="enyInscriptions")
     */
    private $num_eny_etab;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $orientation;

    /**
     * @ORM\Column(type="string", length=5, nullable=true)
     */
    private $groupe;

    /**
     * @ORM\Column(type="string", length=25, nullable=true)
     */
    private $s1;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $s2;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumEnyPromoOrganisee(): ?EnypromoOrganisee
    {
        return $this->num_eny_promo_organisee;
    }

    public function setNumEnyPromoOrganisee(?EnypromoOrganisee $num_eny_promo_organisee): self
    {
        $this->num_eny_promo_organisee = $num_eny_promo_organisee;

        return $this;
    }

    public function getNumEnyAnneeAcad(): ?EnyAnneeAcad
    {
        return $this->num_eny_annee_acad;
    }

    public function setNumEnyAnneeAcad(?EnyAnneeAcad $num_eny_annee_acad): self
    {
        $this->num_eny_annee_acad = $num_eny_annee_acad;

        return $this;
    }

    public function getNumEnyEtudiant(): ?EnyEtudiant
    {
        return $this->num_eny_etudiant;
    }

    public function setNumEnyEtudiant(?EnyEtudiant $num_eny_etudiant): self
    {
        $this->num_eny_etudiant = $num_eny_etudiant;

        return $this;
    }

    public function getNum(): ?string
    {
        return $this->num;
    }

    public function setNum(string $num): self
    {
        $this->num = $num;

        return $this;
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

    public function getDeleted(): ?\DateTimeInterface
    {
        return $this->deleted;
    }

    public function setDeleted(?\DateTimeInterface $deleted): self
    {
        $this->deleted = $deleted;

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

    public function getOrientation(): ?string
    {
        return $this->orientation;
    }

    public function setOrientation(?string $orientation): self
    {
        $this->orientation = $orientation;

        return $this;
    }

    public function getGroupe(): ?string
    {
        return $this->groupe;
    }

    public function setGroupe(?string $groupe): self
    {
        $this->groupe = $groupe;

        return $this;
    }

    public function getS1(): ?string
    {
        return $this->s1;
    }

    public function setS1(?string $s1): self
    {
        $this->s1 = $s1;

        return $this;
    }

    public function getS2(): ?string
    {
        return $this->s2;
    }

    public function setS2(?string $s2): self
    {
        $this->s2 = $s2;

        return $this;
    }
}
