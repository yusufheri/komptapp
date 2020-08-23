<?php

namespace App\Entity;

use App\Repository\EnySousRubriqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EnySousRubriqueRepository::class)
 */
class EnySousRubrique
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
     * @ORM\ManyToMany(targetEntity=EnyRubrique::class, mappedBy="sousRubriques")
     */
    private $enyRubriques;

    public function __construct()
    {
        $this->enyRubriques = new ArrayCollection();
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

    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeInterface $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

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

    /**
     * @return Collection|EnyRubrique[]
     */
    public function getEnyRubriques(): Collection
    {
        return $this->enyRubriques;
    }

    public function addEnyRubrique(EnyRubrique $enyRubrique): self
    {
        if (!$this->enyRubriques->contains($enyRubrique)) {
            $this->enyRubriques[] = $enyRubrique;
            $enyRubrique->addSousRubrique($this);
        }

        return $this;
    }

    public function removeEnyRubrique(EnyRubrique $enyRubrique): self
    {
        if ($this->enyRubriques->contains($enyRubrique)) {
            $this->enyRubriques->removeElement($enyRubrique);
            $enyRubrique->removeSousRubrique($this);
        }

        return $this;
    }
}
