<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ImportFilesRepository;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=ImportFilesRepository::class)
 * @Vich\Uploadable
 * @ORM\HasLifecycleCallbacks()
 */
class ImportFiles
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $account_bank_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $account_bank_number;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fromAt;

    /**
     * @ORM\Column(type="datetime")
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
     */
    private $error;

    /**
     * @ORM\OneToMany(targetEntity=DetailImport::class, mappedBy="importFile")
     */
    private $detailImports;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $displayName;

    public function __construct()
    {
        $this->detailImports = new ArrayCollection();
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

    public function getAccountBankName(): ?string
    {
        return $this->account_bank_name;
    }

    public function setAccountBankName(?string $account_bank_name): self
    {
        $this->account_bank_name = $account_bank_name;

        return $this;
    }

    public function getAccountBankNumber(): ?string
    {
        return $this->account_bank_number;
    }

    public function setAccountBankNumber(string $account_bank_number): self
    {
        $this->account_bank_number = $account_bank_number;

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

    public function getError(): ?bool
    {
        return $this->error;
    }

    public function setError(?bool $error): self
    {
        $this->error = $error;

        return $this;
    }

    /**
     * @return Collection|DetailImport[]
     */
    public function getDetailImports(): Collection
    {
        return $this->detailImports;
    }

    public function addDetailImport(DetailImport $detailImport): self
    {
        if (!$this->detailImports->contains($detailImport)) {
            $this->detailImports[] = $detailImport;
            $detailImport->setImportFile($this);
        }

        return $this;
    }

    public function removeDetailImport(DetailImport $detailImport): self
    {
        if ($this->detailImports->contains($detailImport)) {
            $this->detailImports->removeElement($detailImport);
            // set the owning side to null (unless already changed)
            if ($detailImport->getImportFile() === $this) {
                $detailImport->setImportFile(null);
            }
        }

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
}
