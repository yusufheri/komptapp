<?php

namespace App\Entity;

use App\Repository\EnyPaysRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EnyPaysRepository::class)
 */
class EnyPays
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue()     
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
     * @ORM\Column(type="string", length=15)
     */
    private $sigle;

    /**
     * @ORM\OneToMany(targetEntity=EnyEtab::class, mappedBy="num_eny_pays")
     */
    private $enyEtabs;

    public function __construct()
    {
        $this->enyEtabs = new ArrayCollection();
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

    public function getSigle(): ?string
    {
        return $this->sigle;
    }

    public function setSigle(string $sigle): self
    {
        $this->sigle = $sigle;

        return $this;
    }

    /**
     * @return Collection|EnyEtab[]
     */
    public function getEnyEtabs(): Collection
    {
        return $this->enyEtabs;
    }

    public function addEnyEtab(EnyEtab $enyEtab): self
    {
        if (!$this->enyEtabs->contains($enyEtab)) {
            $this->enyEtabs[] = $enyEtab;
            $enyEtab->setNumEnyPays($this);
        }

        return $this;
    }

    public function removeEnyEtab(EnyEtab $enyEtab): self
    {
        if ($this->enyEtabs->contains($enyEtab)) {
            $this->enyEtabs->removeElement($enyEtab);
            // set the owning side to null (unless already changed)
            if ($enyEtab->getNumEnyPays() === $this) {
                $enyEtab->setNumEnyPays(null);
            }
        }

        return $this;
    }
}
