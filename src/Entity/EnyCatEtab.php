<?php

namespace App\Entity;

use App\Repository\EnyCatEtabRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EnyCatEtabRepository::class)
 */
class EnyCatEtab
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
     * @ORM\OneToMany(targetEntity=EnyEtab::class, mappedBy="num_eny_cat_etab")
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
            $enyEtab->setNumEnyCatEtab($this);
        }

        return $this;
    }

    public function removeEnyEtab(EnyEtab $enyEtab): self
    {
        if ($this->enyEtabs->contains($enyEtab)) {
            $this->enyEtabs->removeElement($enyEtab);
            // set the owning side to null (unless already changed)
            if ($enyEtab->getNumEnyCatEtab() === $this) {
                $enyEtab->setNumEnyCatEtab(null);
            }
        }

        return $this;
    }
}
