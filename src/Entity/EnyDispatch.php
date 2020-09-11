<?php

namespace App\Entity;

use App\Repository\EnyDispatchRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EnyDispatchRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class EnyDispatch
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
     * @ORM\ManyToOne(targetEntity=EnyRubriqueCpt::class, inversedBy="enyDispatches")
     * @ORM\JoinColumn(nullable=false)
     */
    private $compte;

    /**
     * @ORM\ManyToOne(targetEntity=EnyMvt::class, inversedBy="enyDispatches")
     * @ORM\JoinColumn(nullable=false)
     */
    private $mvt;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * @ORM\Column(type="text")
     */
    private $amount_letter;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $symbol;

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

    public function getCompte(): ?EnyRubriqueCpt
    {
        return $this->compte;
    }

    public function setCompte(?EnyRubriqueCpt $compte): self
    {
        $this->compte = $compte;

        return $this;
    }

    public function getMvt(): ?EnyMvt
    {
        return $this->mvt;
    }

    public function setMvt(?EnyMvt $mvt): self
    {
        $this->mvt = $mvt;

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

    public function getAmountLetter(): ?string
    {
        return $this->amount_letter;
    }

    public function setAmountLetter(string $amount_letter): self
    {
        $this->amount_letter = $amount_letter;

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

    public function getSymbol(): ?bool
    {
        return $this->symbol;
    }

    public function setSymbol(?bool $symbol): self
    {
        $this->symbol = $symbol;

        return $this;
    }
}
