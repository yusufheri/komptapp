<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Rubrique
 *
 * @ORM\Table(name="rubrique")
 * @ORM\Entity
 * @UniqueEntity(
 * fields={"name"},
 *     message="Cette rubrique a été déjà enregistrée!!"
 * )
 * @ORM\HasLifecycleCallbacks()
 */
class Rubrique
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var string|null
     *
     * @ORM\Column(name="code", type="string", length=255, nullable=true)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true, nullable=false)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="content", type="text", length=0, nullable=true)
     */
    private $content;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * @ORM\OneToMany(targetEntity=RubriqueCompte::class, mappedBy="rubrique")
     */
    private $rubriqueComptes;

    /**
     * @ORM\OneToMany(targetEntity=DetailRubrique::class, mappedBy="rubrique")
     */
    private $detailRubriques;

    /**
     * @ORM\OneToMany(targetEntity=SousRubrique::class, mappedBy="rubrique")
     */
    private $sousRubriques;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="SousRubrique", inversedBy="rubrique")
     * @ORM\JoinTable(name="rubrique_sous_rubrique",
     *   joinColumns={
     *     @ORM\JoinColumn(name="rubrique_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="sous_rubrique_id", referencedColumnName="id")
     *   }
     * )
     */
    private $sousRubrique;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->rubriqueComptes = new ArrayCollection();
        $this->detailRubriques = new ArrayCollection();
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
     * Get the value of createdAt
     *
     * @return  \DateTime
     */ 
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set the value of createdAt
     *
     * @param  \DateTime  $createdAt
     *
     * @return  self
     */ 
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get the value of code
     *
     * @return  string|null
     */ 
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set the value of code
     *
     * @param  string|null  $code
     *
     * @return  self
     */ 
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get the value of name
     *
     * @return  string
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @param  string  $name
     *
     * @return  self
     */ 
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of content
     *
     * @return  string|null
     */ 
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set the value of content
     *
     * @param  string|null  $content
     *
     * @return  self
     */ 
    public function setContent($content)
    {
        $this->content = $content;

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
     * @return Collection|DetailImport[]
     */
    public function getDetailRubriques(): Collection
    {
        return $this->detailRubriques;
    }

    public function addDetailRubrique(DetailRubrique $detailRubrique): self
    {
        if (!$this->detailRubriques->contains($detailRubrique)) {
            $this->detailRubriques[] = $detailRubrique;
            $detailRubrique->setRubrique($this);
        }

        return $this;
    }

    public function removeDetailRubrique(DetailRubrique $detailRubriques): self
    {
        if ($this->detailRubriques->contains($detailRubriques)) {
            $this->detailRubriques->removeElement($detailRubriques);
            // set the owning side to null (unless already changed)
            if ($detailRubriques->getRubrique() === $this) {
                $detailRubriques->setRubrique(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|RubriqueCompte[]
     */
    public function getRubriqueComptes(): Collection
    {
        return $this->rubriqueComptes;
    }

    public function addRubriqueCompte(RubriqueCompte $rubriqueCompte): self
    {
        if (!$this->rubriqueComptes->contains($rubriqueCompte)) {
            $this->rubriqueComptes[] = $rubriqueCompte;
            $rubriqueCompte->setRubrique($this);
        }

        return $this;
    }

    public function removeRubriqueCompte(RubriqueCompte $rubriqueCompte): self
    {
        if ($this->rubriqueComptes->contains($rubriqueCompte)) {
            $this->rubriqueComptes->removeElement($rubriqueCompte);
            // set the owning side to null (unless already changed)
            if ($rubriqueCompte->getRubrique() === $this) {
                $rubriqueCompte->setRubrique(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SousRubrique[]
     */
    public function getSousRubriques(): Collection
    {
        return $this->sousRubriques;
    }

    public function addSousRubrique(SousRubrique $sousRubrique): self
    {
        if (!$this->sousRubriques->contains($sousRubrique)) {
            $this->sousRubriques[] = $sousRubrique;
            $sousRubrique->setRubrique($this);
        }

        return $this;
    }

    public function removeSousRubrique(SousRubrique $sousRubrique): self
    {
        if ($this->sousRubriques->contains($sousRubrique)) {
            $this->sousRubriques->removeElement($sousRubrique);
            // set the owning side to null (unless already changed)
            if ($sousRubrique->getRubrique() === $this) {
                $sousRubrique->setRubrique(null);
            }
        }

        return $this;
    }

    public function MayBeAddRubriqueCompte(RubriqueCompte $rubriqueCompte) 
    {
        return $this->rubriqueComptes->contains($rubriqueCompte);
    }
}
