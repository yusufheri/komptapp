<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use App\Repository\EnyImportRepository;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass=EnyImportRepository::class)
 * @Vich\Uploadable
 * @ORM\HasLifecycleCallbacks()
 */
class EnyImport
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @Groups("import:read")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("import:read")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("import:read")
     */
    private $filename;

    /**
     * @ORM\Column(type="integer")
     * @Groups("import:read")
     */
    private $filesize;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("import:read")
     */
    private $fromAt;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("import:read")
     */
    private $toAt;

    /** 
     * @Vich\UploadableField(mapping="excel_file", fileNameProperty="filename", size="fileSize")
     * 
     * @var File|null
     */
    private $excelFile;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups("import:read")
     */
    private $error;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("import:read")
     */
    private $displayName;

    /**
     * @ORM\ManyToOne(targetEntity=EnyBankingInfo::class, inversedBy="enyImports")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("import:read")
     */
    private $bankInfo;

    /**
     * @ORM\Column(type="integer")
     * @Groups("import:read")
     */
    private $rows;

    /**
     * @ORM\OneToMany(targetEntity=EnyDetailImport::class, mappedBy="enyImport")
     * @Groups("import:read")
     */
    private $enyDetailImports;

    /**
     * @ORM\OneToMany(targetEntity=EnyMvt::class, mappedBy="import")
     * @Groups("import:read")
     */
    private $enyMvts;

    public function __construct()
    {
        $this->enyDetailImports = new ArrayCollection();
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
            $enyMvt->setImport($this);
        }

        return $this;
    }

    public function removeEnyMvt(EnyMvt $enyMvt): self
    {
        if ($this->enyMvts->contains($enyMvt)) {
            $this->enyMvts->removeElement($enyMvt);
            // set the owning side to null (unless already changed)
            if ($enyMvt->getImport() === $this) {
                $enyMvt->setImport(null);
            }
        }

        return $this;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $excelFile
     */
    public function setExcelFile(?File $excelFile = null): void
    {
        $this->excelFile = $excelFile;

        if (null !== $excelFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getExcelFile(): ?File
    {
        return $this->excelFile;
    }
}
