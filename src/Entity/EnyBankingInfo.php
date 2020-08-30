<?php

namespace App\Entity;

use App\Repository\EnyBankingInfoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EnyBankingInfoRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(
 *      fields={"account_number"},
 *     message="Il existe déjà un numéro de compte pareil dans la base de données."
 * 
 * )
 */
class EnyBankingInfo
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
     * @ORM\Column(type="string", length=255)
     */
    private $account_name;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $account_number;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity=EnyBank::class, inversedBy="enyBankingInfos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $bank;

    /**
     * @ORM\OneToMany(targetEntity=EnyImport::class, mappedBy="bankInfo")
     */
    private $enyImports;

    public function __construct()
    {
        $this->enyImports = new ArrayCollection();
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

    public function getAccountName(): ?string
    {
        return $this->account_name;
    }

    public function setAccountName(string $account_name): self
    {
        $this->account_name = $account_name;

        return $this;
    }

    public function getAccountNumber(): ?string
    {
        return $this->account_number;
    }

    public function setAccountNumber(string $account_number): self
    {
        $this->account_number = $account_number;

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

    public function getBank(): ?EnyBank
    {
        return $this->bank;
    }

    public function setBank(?EnyBank $bank): self
    {
        $this->bank = $bank;

        return $this;
    }

    /**
     * @return Collection|EnyImport[]
     */
    public function getEnyImports(): Collection
    {
        return $this->enyImports;
    }

    public function addEnyImport(EnyImport $enyImport): self
    {
        if (!$this->enyImports->contains($enyImport)) {
            $this->enyImports[] = $enyImport;
            $enyImport->setBankInfo($this);
        }

        return $this;
    }

    public function removeEnyImport(EnyImport $enyImport): self
    {
        if ($this->enyImports->contains($enyImport)) {
            $this->enyImports->removeElement($enyImport);
            // set the owning side to null (unless already changed)
            if ($enyImport->getBankInfo() === $this) {
                $enyImport->setBankInfo(null);
            }
        }

        return $this;
    }
}
