<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\EnyCompteRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=EnyCompteRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(
 *      fields={"name"},
 *     message="Il existe déjà un compte portant ce libelllé."
 * 
 * )
 */
class EnyCompte
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("cpte:read")
     * @Groups("rubrique:read")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("cpte:read")
     * @Groups("rubrique:read")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("cpte:read")
     * @Groups("rubrique:read")
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Groups("cpte:read")
     * @Groups("rubrique:read")
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups("cpte:read")
     * @Groups("rubrique:read")
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

    public function getSoldeEntree():?float
    {
        $solde = 0.0;

        /**@var EnyRubriqueCpt $rubriqueCpt */
        foreach ($this->enyRubriqueCpts as $k => $rubriqueCpt) {
            if (is_null($rubriqueCpt->getDeletedAt()))
            {
                /**@var EnyDispatch $dispatch */
                foreach ($rubriqueCpt->getEnyDispatches() as $key => $dispatch) {
                    $solde += $dispatch->getAmount();
                }
            }
        }
        //$returnSolde []=number_format($solde, 2,',','.')." ".$deviseName;
        
        return $solde;
    }


    public function getSoldeSortie():?float
    {
        $solde = 0.0;

        /**@var EnyRubriqueCpt $rubriqueCpt */
        foreach ($this->enyRubriqueCpts as $k => $rubriqueCpt) {
            if (is_null($rubriqueCpt->getDeletedAt()))
            {
                /**@var EnyMvt $enyMvt */
                foreach ($rubriqueCpt->getEnyMvts() as $key => $enyMvt) {
                    if (is_null($enyMvt->getError()) && is_null($enyMvt->getDeletedAt())){
                        $solde += $enyMvt->getAmount();
                    }
                }
            }
        }
        //$returnSolde []=number_format($solde, 2,',','.')." ".$deviseName;
        
        return $solde;
    }

    public function getSolde():?float
    {        
        return $this->getSoldeEntree() - $this->getSoldeSortie();
    }
}
