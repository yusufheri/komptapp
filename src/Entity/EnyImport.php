<?php

namespace App\Entity;

use App\Repository\EnyImportRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EnyImportRepository::class)
 */
class EnyImport
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
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $filename;

    /**
     * @ORM\Column(type="integer")
     */
    private $filesize;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fromAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $toAt;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $error;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $displayName;

    /**
     * @ORM\ManyToOne(targetEntity=EnyBankingInfo::class, inversedBy="enyImports")
     * @ORM\JoinColumn(nullable=false)
     */
    private $bankInfo;

    /**
     * @ORM\Column(type="integer")
     */
    private $rows;

    /**
     * @ORM\OneToMany(targetEntity=EnyDetailImport::class, mappedBy="enyImport")
     */
    private $enyDetailImports;

    public function __construct()
    {
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

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    public function getFilesize(): ?int
    {
        return $this->filesize;
    }

    public function setFilesize(int $filesize): self
    {
        $this->filesize = $filesize;

        return $this;
    }

    public function getFromAt(): ?\DateTimeInterface
    {
        return $this->fromAt;
    }

    public function setFromAt(\DateTimeInterface $fromAt): self
    {
        $this->fromAt = $fromAt;

        return $this;
    }

    public function getToAt(): ?\DateTimeInterface
    {
        return $this->toAt;
    }

    public function setToAt(\DateTimeInterface $toAt): self
    {
        $this->toAt = $toAt;

        return $this;
    }

    public function getError(): ?bool
    {
        return $this->error;
    }

    public function setError(?bool $error): self
    {
        $this->error = $error;

        return $this;
    }

    public function getDisplayName(): ?string
    {
        return $this->displayName;
    }

    public function setDisplayName(string $displayName): self
    {
        $this->displayName = $displayName;

        return $this;
    }

    public function getBankInfo(): ?EnyBankingInfo
    {
        return $this->bankInfo;
    }

    public function setBankInfo(?EnyBankingInfo $bankInfo): self
    {
        $this->bankInfo = $bankInfo;

        return $this;
    }

    public function getRows(): ?int
    {
        return $this->rows;
    }

    public function setRows(int $rows): self
    {
        $this->rows = $rows;

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
            $enyDetailImport->setEnyImport($this);
        }

        return $this;
    }

    public function removeEnyDetailImport(EnyDetailImport $enyDetailImport): self
    {
        if ($this->enyDetailImports->contains($enyDetailImport)) {
            $this->enyDetailImports->removeElement($enyDetailImport);
            // set the owning side to null (unless already changed)
            if ($enyDetailImport->getEnyImport() === $this) {
                $enyDetailImport->setEnyImport(null);
            }
        }

        return $this;
    }
}
