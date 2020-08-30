<?php

namespace App\Entity;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Repository\EnyBankRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EnyBankRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(
 *      fields={"name"},
 *     message="Il existe déjà un motif portant ce libelllé."
 * 
 * )
 */
class EnyBank
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
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tel;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $website;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $address;

    /**
     * @ORM\OneToMany(targetEntity=EnyBankingInfo::class, mappedBy="bank")
     */
    private $enyBankingInfos;

    public function __construct()
    {
        $this->enyBankingInfos = new ArrayCollection();
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

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(?string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): self
    {
        $this->website = $website;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return Collection|EnyBankingInfo[]
     */
    public function getEnyBankingInfos(): Collection
    {
        return $this->enyBankingInfos;
    }

    public function addEnyBankingInfo(EnyBankingInfo $enyBankingInfo): self
    {
        if (!$this->enyBankingInfos->contains($enyBankingInfo)) {
            $this->enyBankingInfos[] = $enyBankingInfo;
            $enyBankingInfo->setBank($this);
        }

        return $this;
    }

    public function removeEnyBankingInfo(EnyBankingInfo $enyBankingInfo): self
    {
        if ($this->enyBankingInfos->contains($enyBankingInfo)) {
            $this->enyBankingInfos->removeElement($enyBankingInfo);
            // set the owning side to null (unless already changed)
            if ($enyBankingInfo->getBank() === $this) {
                $enyBankingInfo->setBank(null);
            }
        }

        return $this;
    }
}
