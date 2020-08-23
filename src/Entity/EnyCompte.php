<?php

namespace App\Entity;

use App\Repository\EnyCompteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EnyCompteRepository::class)
 */
class EnyCompte
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
     * @ORM\OneToMany(targetEntity=EnyRubriqueCpt::class, mappedBy="compte")
     */
    private $enyRubriqueCpts;

    public function __construct()
    {
        $this->enyRubriqueCpts = new ArrayCollection();
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
            $enyRubriqueCpt->setCompte($this);
        }

        return $this;
    }

    public function removeEnyRubriqueCpt(EnyRubriqueCpt $enyRubriqueCpt): self
    {
        if ($this->enyRubriqueCpts->contains($enyRubriqueCpt)) {
            $this->enyRubriqueCpts->removeElement($enyRubriqueCpt);
            // set the owning side to null (unless already changed)
            if ($enyRubriqueCpt->getCompte() === $this) {
                $enyRubriqueCpt->setCompte(null);
            }
        }

        return $this;
    }
}
