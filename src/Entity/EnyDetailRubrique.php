<?php

namespace App\Entity;

use App\Repository\EnyDetailRubriqueRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EnyDetailRubriqueRepository::class)
 */
class EnyDetailRubrique
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
    private $deletedAt;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $amount;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $tranche_one;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $tranche_two;

    /**
     * @ORM\ManyToOne(targetEntity=Devise::class, inversedBy="enyDetailRubriques")
     * @ORM\JoinColumn(nullable=false)
     */
    private $devise;

    /**
     * @ORM\ManyToOne(targetEntity=EnyRubrique::class, inversedBy="enyDetailRubriques")
     * @ORM\JoinColumn(nullable=false)
     */
    private $rubrique;

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

    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeInterface $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(?float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getTrancheOne(): ?float
    {
        return $this->tranche_one;
    }

    public function setTrancheOne(?float $tranche_one): self
    {
        $this->tranche_one = $tranche_one;

        return $this;
    }

    public function getTrancheTwo(): ?float
    {
        return $this->tranche_two;
    }

    public function setTrancheTwo(?float $tranche_two): self
    {
        $this->tranche_two = $tranche_two;

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

    public function getRubrique(): ?EnyRubrique
    {
        return $this->rubrique;
    }

    public function setRubrique(?EnyRubrique $rubrique): self
    {
        $this->rubrique = $rubrique;

        return $this;
    }
}
