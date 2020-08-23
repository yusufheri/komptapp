<?php

namespace App\Entity;

use App\Repository\EnyPromotionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EnyPromotionRepository::class)
 */
class EnyPromotion
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
     * @ORM\Column(type="string", length=255)
     */
    private $lib;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=EnyPromoOrganisee::class, mappedBy="num_eny_promotion")
     */
    private $enyPromoOrganisees;

    public function __construct()
    {
        $this->enyPromoOrganisees = new ArrayCollection();
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

    public function getLib(): ?string
    {
        return $this->lib;
    }

    public function setLib(string $lib): self
    {
        $this->lib = $lib;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|EnyPromoOrganisee[]
     */
    public function getEnyPromoOrganisees(): Collection
    {
        return $this->enyPromoOrganisees;
    }

    public function addEnyPromoOrganisee(EnyPromoOrganisee $enyPromoOrganisee): self
    {
        if (!$this->enyPromoOrganisees->contains($enyPromoOrganisee)) {
            $this->enyPromoOrganisees[] = $enyPromoOrganisee;
            $enyPromoOrganisee->setNumEnyPromotion($this);
        }

        return $this;
    }

    public function removeEnyPromoOrganisee(EnyPromoOrganisee $enyPromoOrganisee): self
    {
        if ($this->enyPromoOrganisees->contains($enyPromoOrganisee)) {
            $this->enyPromoOrganisees->removeElement($enyPromoOrganisee);
            // set the owning side to null (unless already changed)
            if ($enyPromoOrganisee->getNumEnyPromotion() === $this) {
                $enyPromoOrganisee->setNumEnyPromotion(null);
            }
        }

        return $this;
    }
}
