<?php

namespace App\Entity;

use App\Repository\DeviseRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Devise
 *
 * @ORM\Table(name="devise")
 * @ORM\Entity
 */
class Devise
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups("rubrique:read")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     * @Groups("rubrique:read")
     */
    private $createdAt;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     * @Groups("rubrique:read")
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", length=0, nullable=true)
     * @Groups("rubrique:read")
     */
    private $description;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * @ORM\OneToMany(targetEntity=EnyDetailRubrique::class, mappedBy="devise")
     */
    private $enyDetailRubriques;

    /**
     * @ORM\OneToMany(targetEntity=EnyRubriqueCpt::class, mappedBy="devise")
     */
    private $enyRubriqueCpts;

    /**
     * @ORM\OneToMany(targetEntity=EnyDetailImport::class, mappedBy="devise")
     */
    private $enyDetailImports;

    public function __construct()
    {
        $this->enyDetailRubriques = new ArrayCollection();
        $this->enyRubriqueCpts = new ArrayCollection();
        $this->enyDetailImports = new ArrayCollection();
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of id
     *
     * @return  int
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @param  int  $id
     *
     * @return  self
     */ 
    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of deletedAt
     *
     * @return  \DateTime|null
     */ 
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * Set the value of deletedAt
     *
     * @param  \DateTime|null  $deletedAt
     *
     * @return  self
     */ 
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * @return Collection|EnyDetailRubrique[]
     */
    public function getEnyDetailRubriques(): Collection
    {
        return $this->enyDetailRubriques;
    }

    public function addEnyDetailRubrique(EnyDetailRubrique $enyDetailRubrique): self
    {
        if (!$this->enyDetailRubriques->contains($enyDetailRubrique)) {
            $this->enyDetailRubriques[] = $enyDetailRubrique;
            $enyDetailRubrique->setDevise($this);
        }

        return $this;
    }

    public function removeEnyDetailRubrique(EnyDetailRubrique $enyDetailRubrique): self
    {
        if ($this->enyDetailRubriques->contains($enyDetailRubrique)) {
            $this->enyDetailRubriques->removeElement($enyDetailRubrique);
            // set the owning side to null (unless already changed)
            if ($enyDetailRubrique->getDevise() === $this) {
                $enyDetailRubrique->setDevise(null);
            }
        }

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
            $enyRubriqueCpt->setDevise($this);
        }

        return $this;
    }

    public function removeEnyRubriqueCpt(EnyRubriqueCpt $enyRubriqueCpt): self
    {
        if ($this->enyRubriqueCpts->contains($enyRubriqueCpt)) {
            $this->enyRubriqueCpts->removeElement($enyRubriqueCpt);
            // set the owning side to null (unless already changed)
            if ($enyRubriqueCpt->getDevise() === $this) {
                $enyRubriqueCpt->setDevise(null);
            }
        }

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
            $enyDetailImport->setDevise($this);
        }

        return $this;
    }

    public function removeEnyDetailImport(EnyDetailImport $enyDetailImport): self
    {
        if ($this->enyDetailImports->contains($enyDetailImport)) {
            $this->enyDetailImports->removeElement($enyDetailImport);
            // set the owning side to null (unless already changed)
            if ($enyDetailImport->getDevise() === $this) {
                $enyDetailImport->setDevise(null);
            }
        }

        return $this;
    }
}
