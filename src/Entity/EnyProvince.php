<?php

namespace App\Entity;

use App\Repository\EnyProvinceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EnyProvinceRepository::class)
 */
class EnyProvince
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
    private $created_at;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lib;

    /**
     * @ORM\OneToMany(targetEntity=EnyEtab::class, mappedBy="num_eny_province")
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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

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
            $enyEtab->setNumEnyProvince($this);
        }

        return $this;
    }

    public function removeEnyEtab(EnyEtab $enyEtab): self
    {
        if ($this->enyEtabs->contains($enyEtab)) {
            $this->enyEtabs->removeElement($enyEtab);
            // set the owning side to null (unless already changed)
            if ($enyEtab->getNumEnyProvince() === $this) {
                $enyEtab->setNumEnyProvince(null);
            }
        }

        return $this;
    }
}
