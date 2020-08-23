<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RubriqueCompte
 *
 * @ORM\Table(name="rubrique_compte", indexes={@ORM\Index(name="IDX_A9FC14F3BD38833", columns={"rubrique_id"}), @ORM\Index(name="IDX_A9FC14FF2C56620", columns={"compte_id"})})
 * @ORM\Entity
 */
class RubriqueCompte
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
     * @var \DateTime|null
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * @var float
     *
     * @ORM\Column(name="amount", type="float", precision=10, scale=0, nullable=false)
     */
    private $amount;

    /**
     * @var float|null
     *
     * @ORM\Column(name="percent", type="float", precision=10, scale=0, nullable=true)
     */
    private $percent;

    /**
     * @var int|null
     *
     * @ORM\Column(name="sous_rubrique", type="integer", nullable=true)
     */
    private $sousRubrique;

    /**
     * @var string|null
     *
     * @ORM\Column(name="content", type="text", length=0, nullable=true)
     */
    private $content;

    /**
     * @var \Rubrique
     *
     * @ORM\ManyToOne(targetEntity="Rubrique", inversedBy="rubriqueComptes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="rubrique_id", referencedColumnName="id")
     * })
     */
    private $rubrique;

    /**
     * @var \Compte
     *
     * @ORM\ManyToOne(targetEntity="Compte")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="compte_id", referencedColumnName="id")
     * })
     */
    private $compte;



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
     * Get the value of updatedAt
     *
     * @return  \DateTime|null
     */ 
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set the value of updatedAt
     *
     * @param  \DateTime|null  $updatedAt
     *
     * @return  self
     */ 
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

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
     * Get the value of amount
     *
     * @return  float
     */ 
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set the value of amount
     *
     * @param  float  $amount
     *
     * @return  self
     */ 
    public function setAmount(float $amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get the value of percent
     *
     * @return  float|null
     */ 
    public function getPercent()
    {
        return $this->percent;
    }

    /**
     * Set the value of percent
     *
     * @param  float|null  $percent
     *
     * @return  self
     */ 
    public function setPercent($percent)
    {
        $this->percent = $percent;

        return $this;
    }

    /**
     * Get the value of sousRubrique
     *
     * @return  int|null
     */ 
    public function getSousRubrique()
    {
        return $this->sousRubrique;
    }

    /**
     * Set the value of sousRubrique
     *
     * @param  int|null  $sousRubrique
     *
     * @return  self
     */ 
    public function setSousRubrique($sousRubrique)
    {
        $this->sousRubrique = $sousRubrique;

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
     * Get the value of rubrique
     *
     * @return  \Rubrique
     */ 
    public function getRubrique()
    {
        return $this->rubrique;
    }

    /**
     * Set the value of rubrique
     *
     * @param  null|Rubrique  $rubrique
     *
     * @return  self
     */ 
    public function setRubrique(?Rubrique $rubrique)
    {
        $this->rubrique = $rubrique;

        return $this;
    }

    /**
     * Get the value of compte
     *
     * @return  \Compte
     */ 
    public function getCompte()
    {
        return $this->compte;
    }

    /**
     * Set the value of compte
     *
     * @param  \Compte  $compte
     *
     * @return  self
     */ 
    public function setCompte(Compte $compte)
    {
        $this->compte = $compte;

        return $this;
    }
}
