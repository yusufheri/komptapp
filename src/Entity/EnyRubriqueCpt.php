<?php

namespace App\Entity;

use App\Repository\EnyRubriqueCptRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EnyRubriqueCptRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class EnyRubriqueCpt
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("rubrique:read")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("rubrique:read")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups("rubrique:read")
     */
    private $percent;

    /**
     * @ORM\Column(type="float")
     * @Groups("rubrique:read")
     */
    private $amount;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups("rubrique:read")
     */
    private $srubrique;

    private $nameSrubrique;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity=EnyCompte::class, inversedBy="enyRubriqueCpts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $compte;

    /**
     * @ORM\ManyToOne(targetEntity=EnyRubrique::class, inversedBy="enyRubriqueCpts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $rubrique;

    /**
     * @ORM\ManyToOne(targetEntity=Devise::class, inversedBy="enyRubriqueCpts")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("rubrique:read")
     */
    private $devise;

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

    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeInterface $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    public function getPercent(): ?float
    {
        return $this->percent;
    }

    public function setPercent(?float $percent): self
    {
        $this->percent = $percent;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getSrubrique(): ?int
    {
        return $this->srubrique;
    }

    public function setSrubrique(?int $srubrique): self
    {
        $this->srubrique = $srubrique;

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

    public function getCompte(): ?EnyCompte
    {
        return $this->compte;
    }

    public function setCompte(?EnyCompte $compte): self
    {
        $this->compte = $compte;

        return $this;
    }

    public function getRubrique(): ?EnyRubrique
    {
        return $this->rubrique;
    }

    public function setRubrique(?EnyRubrique $rubrique): self
    {
        $this->rubrique = $rubrique;

        return $this;
    }

    public function getDevise(): ?Devise
    {
        return $this->devise;
    }

    public function setDevise(?Devise $devise): self
    {
        $this->devise = $devise;

        return $this;
    }

    public function getNameSrubrique()
    {
        foreach($this->rubrique->getSousRubriques() as $key => $obj){
            if($obj->getId() == $this->srubrique) return $obj->getName();
        }
        return $this->srubrique;
    }

}
