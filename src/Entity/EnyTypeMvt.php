<?php

namespace App\Entity;

use App\Repository\EnyTypeMvtRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EnyTypeMvtRepository::class)
 */
class EnyTypeMvt
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $content;

    /**
     * @ORM\OneToMany(targetEntity=EnyMvt::class, mappedBy="typeMvt")
     */
    private $enyMvts;

    public function __construct()
    {
        $this->enyMvts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * @return Collection|EnyMvt[]
     */
    public function getEnyMvts(): Collection
    {
        return $this->enyMvts;
    }

    public function addEnyMvt(EnyMvt $enyMvt): self
    {
        if (!$this->enyMvts->contains($enyMvt)) {
            $this->enyMvts[] = $enyMvt;
            $enyMvt->setTypeMvt($this);
        }

        return $this;
    }

    public function removeEnyMvt(EnyMvt $enyMvt): self
    {
        if ($this->enyMvts->contains($enyMvt)) {
            $this->enyMvts->removeElement($enyMvt);
            // set the owning side to null (unless already changed)
            if ($enyMvt->getTypeMvt() === $this) {
                $enyMvt->setTypeMvt(null);
            }
        }

        return $this;
    }
}
