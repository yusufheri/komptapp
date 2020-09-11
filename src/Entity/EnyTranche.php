<?php

namespace App\Entity;

use App\Repository\EnyTrancheRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EnyTrancheRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class EnyTranche
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
     * @ORM\Column(type="integer")
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=EnyMvt::class, mappedBy="tranche")
     */
    private $enyMvts;

    public function __construct()
    {
        $this->enyMvts = new ArrayCollection();
    }

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

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function setCode(int $code): self
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
            $enyMvt->setTranche($this);
        }

        return $this;
    }

    public function removeEnyMvt(EnyMvt $enyMvt): self
    {
        if ($this->enyMvts->contains($enyMvt)) {
            $this->enyMvts->removeElement($enyMvt);
            // set the owning side to null (unless already changed)
            if ($enyMvt->getTranche() === $this) {
                $enyMvt->setTranche(null);
            }
        }

        return $this;
    }
}
