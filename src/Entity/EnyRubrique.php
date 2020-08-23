<?php

namespace App\Entity;

use App\Repository\EnyRubriqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EnyRubriqueRepository::class)
 */
class EnyRubrique
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * @ORM\OneToMany(targetEntity=EnyRubriqueCpt::class, mappedBy="rubrique")
     */
    private $enyRubriqueCpts;

    /**
     * @ORM\ManyToMany(targetEntity=EnySousRubrique::class, inversedBy="enyRubriques")
     */
    private $sousRubriques;

    /**
     * @ORM\OneToMany(targetEntity=EnyDetailRubrique::class, mappedBy="rubrique")
     */
    private $enyDetailRubriques;

    /**
     * @ORM\OneToMany(targetEntity=EnyDetailImport::class, mappedBy="enyRubrique")
     */
    private $enyDetailImports;

    public function __construct()
    {
        $this->enyRubriqueCpts = new ArrayCollection();
        $this->sousRubriques = new ArrayCollection();
        $this->enyDetailRubriques = new ArrayCollection();
        $this->enyDetailImports = new ArrayCollection();
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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeInterface $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * @return Collection|EnyRubriqueCpt[]
     */
    public function getEnyRubriqueCpts(): Collection
    {
        return $this->enyRubriqueCpts;
    }

    public function addEnyRubriqueCpt(EnyRubriqueCpt $enyRubriqueCpt): self
    {
        if (!$this->enyRubriqueCpts->contains($enyRubriqueCpt)) {
            $this->enyRubriqueCpts[] = $enyRubriqueCpt;
            $enyRubriqueCpt->setRubrique($this);
        }

        return $this;
    }

    public function removeEnyRubriqueCpt(EnyRubriqueCpt $enyRubriqueCpt): self
    {
        if ($this->enyRubriqueCpts->contains($enyRubriqueCpt)) {
            $this->enyRubriqueCpts->removeElement($enyRubriqueCpt);
            // set the owning side to null (unless already changed)
            if ($enyRubriqueCpt->getRubrique() === $this) {
                $enyRubriqueCpt->setRubrique(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|EnySousRubrique[]
     */
    public function getSousRubriques(): Collection
    {
        return $this->sousRubriques;
    }

    public function addSousRubrique(EnySousRubrique $sousRubrique): self
    {
        if (!$this->sousRubriques->contains($sousRubrique)) {
            $this->sousRubriques[] = $sousRubrique;
        }

        return $this;
    }

    public function removeSousRubrique(EnySousRubrique $sousRubrique): self
    {
        if ($this->sousRubriques->contains($sousRubrique)) {
            $this->sousRubriques->removeElement($sousRubrique);
        }

        return $this;
    }

    /**
     * @return Collection|EnyDetailRubrique[]
     */
    public function getEnyDetailRubriques(): Collection
    {
        return $this->enyDetailRubriques;
    }

    public function addEnyDetailRubrique(EnyDetailRubrique $enyDetailRubrique): self
    {
        if (!$this->enyDetailRubriques->contains($enyDetailRubrique)) {
            $this->enyDetailRubriques[] = $enyDetailRubrique;
            $enyDetailRubrique->setRubrique($this);
        }

        return $this;
    }

    public function removeEnyDetailRubrique(EnyDetailRubrique $enyDetailRubrique): self
    {
        if ($this->enyDetailRubriques->contains($enyDetailRubrique)) {
            $this->enyDetailRubriques->removeElement($enyDetailRubrique);
            // set the owning side to null (unless already changed)
            if ($enyDetailRubrique->getRubrique() === $this) {
                $enyDetailRubrique->setRubrique(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|EnyDetailImport[]
     */
    public function getEnyDetailImports(): Collection
    {
        return $this->enyDetailImports;
    }

    public function addEnyDetailImport(EnyDetailImport $enyDetailImport): self
    {
        if (!$this->enyDetailImports->contains($enyDetailImport)) {
            $this->enyDetailImports[] = $enyDetailImport;
            $enyDetailImport->setEnyRubrique($this);
        }

        return $this;
    }

    public function removeEnyDetailImport(EnyDetailImport $enyDetailImport): self
    {
        if ($this->enyDetailImports->contains($enyDetailImport)) {
            $this->enyDetailImports->removeElement($enyDetailImport);
            // set the owning side to null (unless already changed)
            if ($enyDetailImport->getEnyRubrique() === $this) {
                $enyDetailImport->setEnyRubrique(null);
            }
        }

        return $this;
    }
}
