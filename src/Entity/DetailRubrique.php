<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DetailRubrique
 *
 * @ORM\Table(name="detail_rubrique", indexes={@ORM\Index(name="IDX_797AE0A73BD38833", columns={"rubrique_id"}), @ORM\Index(name="IDX_797AE0A7F4445056", columns={"devise_id"})})
 * @ORM\Entity
 */
class DetailRubrique
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
     * @var float|null
     *
     * @ORM\Column(name="amount", type="float", precision=10, scale=0, nullable=true)
     */
    private $amount;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * @var float|null
     *
     * @ORM\Column(name="tranche_one", type="float", precision=10, scale=0, nullable=true)
     */
    private $trancheOne;

    /**
     * @var float|null
     *
     * @ORM\Column(name="tranche_two", type="float", precision=10, scale=0, nullable=true)
     */
    private $trancheTwo;

    /**
     * @var \Rubrique
     *
     * @ORM\ManyToOne(targetEntity="Rubrique", inversedBy="detailRubriques")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="rubrique_id", referencedColumnName="id")
     * })
     */
    private $rubrique;

    /**
     * @var \Devise
     *
     * @ORM\ManyToOne(targetEntity="Devise")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="devise_id", referencedColumnName="id")
     * })
     */
    private $devise;



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
     * @return  float|null
     */ 
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set the value of amount
     *
     * @param  float|null  $amount
     *
     * @return  self
     */ 
    public function setAmount($amount)
    {
        $this->amount = $amount;

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
     * Get the value of trancheOne
     *
     * @return  float|null
     */ 
    public function getTrancheOne()
    {
        return $this->trancheOne;
    }

    /**
     * Set the value of trancheOne
     *
     * @param  float|null  $trancheOne
     *
     * @return  self
     */ 
    public function setTrancheOne($trancheOne)
    {
        $this->trancheOne = $trancheOne;

        return $this;
    }

    /**
     * Get the value of trancheTwo
     *
     * @return  float|null
     */ 
    public function getTrancheTwo()
    {
        return $this->trancheTwo;
    }

    /**
     * Set the value of trancheTwo
     *
     * @param  float|null  $trancheTwo
     *
     * @return  self
     */ 
    public function setTrancheTwo($trancheTwo)
    {
        $this->trancheTwo = $trancheTwo;

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
     * Get the value of devise
     *
     * @return  \Devise
     */ 
    public function getDevise()
    {
        return $this->devise;
    }

    /**
     * Set the value of devise
     *
     * @param  \Devise  $devise
     *
     * @return  self
     */ 
    public function setDevise(Devise $devise)
    {
        $this->devise = $devise;

        return $this;
    }
}
