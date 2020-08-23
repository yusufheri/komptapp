<?php

namespace App\Entity;

use App\Repository\EnyAnneeAcadRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EnyAnneeAcadRepository::class)
 */
class EnyAnneeAcad
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=EnyInscription::class, mappedBy="num_eny_annee_acad")
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
            $enyInscription->setNumEnyAnneeAcad($this);
        }

        return $this;
    }

    public function removeEnyInscription(EnyInscription $enyInscription): self
    {
        if ($this->enyInscriptions->contains($enyInscription)) {
            $this->enyInscriptions->removeElement($enyInscription);
            // set the owning side to null (unless already changed)
            if ($enyInscription->getNumEnyAnneeAcad() === $this) {
                $enyInscription->setNumEnyAnneeAcad(null);
            }
        }

        return $this;
    }
}
