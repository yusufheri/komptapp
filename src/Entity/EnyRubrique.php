<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\EnyRubriqueRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=EnyRubriqueRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(
 *      fields={"name"},
 *     message="Il existe déjà une rubrique portant ce libellé."
 * 
 * )
 */
class EnyRubrique
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
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("rubrique:read")
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Groups("rubrique:read")
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups("rubrique:read")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups("rubrique:read")
     */
    private $deletedAt;

    /**
     * @ORM\OneToMany(targetEntity=EnyRubriqueCpt::class, mappedBy="rubrique")
     * @Groups("rubrique:read")
     */
    private $enyRubriqueCpts;

    /**
     * @ORM\ManyToMany(targetEntity=EnySousRubrique::class, inversedBy="enyRubriques")
     * @Groups("rubrique:read")
     */
    private $sousRubriques;

    /**
     * @ORM\OneToMany(targetEntity=EnyDetailRubrique::class, mappedBy="rubrique")
     * @Groups("rubrique:read")
     */
    private $enyDetailRubriques;

    /**
     * @ORM\OneToMany(targetEntity=EnyDetailImport::class, mappedBy="enyRubrique")
     */
    private $enyDetailImports;

    

    
    private $devise;
    private $amount;
    private $premier;
    private $deuxieme;

    /**
     * @ORM\OneToMany(targetEntity=EnyMvt::class, mappedBy="rubrique")
     */
    private $enyMvts;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $classe_recrutement;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $classe_montante;

    /**
     * @ORM\ManyToMany(targetEntity=EnyMotif::class, inversedBy="enyRubriques")
     */
    private $motifs;
    
    private $enyMotifs;



    public function __construct()
    {
        $this->enyRubriqueCpts = new ArrayCollection();
        $this->sousRubriques = new ArrayCollection();
        $this->enyDetailRubriques = new ArrayCollection();
        $this->enyDetailImports = new ArrayCollection();
        

        $this->enyMvts = new ArrayCollection();
        $this->motifs = new ArrayCollection();  
        $this->enyMotifs = new ArrayCollection();      
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
        return $this->enyRubriqueCpts->map(function(EnyRubriqueCpt $cpt) {
            if (is_null($cpt->getDeletedAt())) return $cpt;
        });
    }

    /**
     * @return Collection|EnyRubriqueCpt[]
     */
    public function getEnyRubriqueCptsDeuxiemeTranche(): Collection
    {        
        $cpts = new ArrayCollection();
        foreach ($this->enyRubriqueCpts as $k => $cpt) {
            if (is_null($cpt->getDeletedAt()) && (!is_null($cpt->getTrancheTwo()))) $cpts->add($cpt);
        }
        return $cpts;
    }

    /**
     * @return Collection|EnyRubriqueCpt[]
     */
    public function getEnyRubriqueCptsPremiereTranche(): Collection
    {
        $cpts = new ArrayCollection();
        //dump($this->enyRubriqueCpts->count());
        foreach ($this->enyRubriqueCpts as $k => $cpt) {
            if (is_null($cpt->getDeletedAt()) && (!is_null($cpt->getTrancheOne()))) $cpts->add($cpt);
        }
        return $cpts;
    }

    public function addEnyRubriqueCpt(EnyRubriqueCpt $enyRubriqueCpt): self
    {
        if (!$this->enyRubriqueCpts->contains($enyRubriqueCpt)) {
            $this->enyRubriqueCpts[] = $enyRubriqueCpt;
            $enyRubriqueCpt->setRubrique($this);
        }

        return $this;
    }

    public function removeEnyRubriqueCpt(EnyRubriqueCpt $enyRubriqueCpt): self
    {
        if ($this->enyRubriqueCpts->contains($enyRubriqueCpt)) {
            $this->enyRubriqueCpts->removeElement($enyRubriqueCpt);
            // set the owning side to null (unless already changed)
            if ($enyRubriqueCpt->getRubrique() === $this) {
                $enyRubriqueCpt->setRubrique(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|EnySousRubrique[]
     */
    public function getSousRubriques(): Collection
    {
        return $this->sousRubriques;
    }

    public function addSousRubrique(EnySousRubrique $sousRubrique): self
    {
        if (!$this->sousRubriques->contains($sousRubrique)) {
            $this->sousRubriques[] = $sousRubrique;
        }

        return $this;
    }

    public function removeSousRubrique(EnySousRubrique $sousRubrique): self
    {
        if ($this->sousRubriques->contains($sousRubrique)) {
            $this->sousRubriques->removeElement($sousRubrique);
        }

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
            $enyDetailRubrique->setRubrique($this);
        }

        return $this;
    }

    public function removeEnyDetailRubrique(EnyDetailRubrique $enyDetailRubrique): self
    {
        if ($this->enyDetailRubriques->contains($enyDetailRubrique)) {
            $this->enyDetailRubriques->removeElement($enyDetailRubrique);
            // set the owning side to null (unless already changed)
            if ($enyDetailRubrique->getRubrique() === $this) {
                $enyDetailRubrique->setRubrique(null);
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
            $enyDetailImport->setEnyRubrique($this);
        }

        return $this;
    }

    public function removeEnyDetailImport(EnyDetailImport $enyDetailImport): self
    {
        if ($this->enyDetailImports->contains($enyDetailImport)) {
            $this->enyDetailImports->removeElement($enyDetailImport);
            // set the owning side to null (unless already changed)
            if ($enyDetailImport->getEnyRubrique() === $this) {
                $enyDetailImport->setEnyRubrique(null);
            }
        }

        return $this;
    }
    

    /**
     * Get the value of devise
     */ 
    public function getDevise()
    {
        return $this->devise;
    }

    /**
     * Set the value of devise
     *
     * @return  self
     */ 
    public function setDevise($devise)
    {
        $this->devise = $devise;

        return $this;
    }

    /**
     * Get the value of amount
     */ 
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set the value of amount
     *
     * @return  self
     */ 
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get the value of premier
     */ 
    public function getPremier()
    {
        return $this->premier;
    }

    /**
     * Set the value of premier
     *
     * @return  self
     */ 
    public function setPremier($premier)
    {
        $this->premier = $premier;

        return $this;
    }

    /**
     * Get the value of deuxieme
     */ 
    public function getDeuxieme()
    {
        return $this->deuxieme;
    }

    /**
     * Set the value of deuxieme
     *
     * @return  self
     */ 
    public function setDeuxieme($deuxieme)
    {
        $this->deuxieme = $deuxieme;

        return $this;
    }

    public function getLastDetailsRubrique():?EnyDetailRubrique
    {
        return $this->enyDetailRubriques->last();
    }

    public function existRubriqueCompte(EnyRubriqueCpt $rubriqueCompte)
    {
        $compte = $rubriqueCompte->getCompte();
        /**@var EnyRubriqueCpt  $rubriqueCpt */
        foreach ($this->enyRubriqueCpts as $key => $rubriqueCpt) {
            if (($rubriqueCpt->getCompte() === $compte) && ($rubriqueCpt->getDeletedAt() == null )) return true;
        }
        return false;
    }

    public function MayBeAddRubriqueCompte(EnyRubriqueCpt $rubriqueCompte) 
    {        
        $somme = 0;
        /**@var EnyRubriqueCpt  $rubriqueCpt */
        foreach ($this->enyRubriqueCpts as $key => $rubriqueCpt) {
            $somme += $rubriqueCpt->getAmount();
        }

        $somme += $rubriqueCompte->getAmount();
        if ($this->getLastDetailsRubrique()->getAmount() >= $somme) return true;
        return false;
    }

    public function getDetailAmountRubrique()
    {
        $detail = $this->enyDetailRubriques->last();
        return $detail->getAmount()." ".$detail->getDevise()->getName();
    }

    public function getSoldeModel( $idType ):?string
    {
        $solde = 0.0;
        $deviseName = "";
        $returnSolde = [];
        $p = 0;
        /**@var EnyMvt $enyMvt */
        foreach ($this->enyMvts as $key => $enyMvt) {
            if ($enyMvt->getTypeMvt()->getId() == $idType)
            {
                if($deviseName != $enyMvt->getDevise()->getName()) 
                {
                    if ($solde > 0) $returnSolde []=number_format($solde, 2,',','.')." ".$deviseName;
                    $deviseName = $enyMvt->getDevise()->getName();
                    $solde  = $enyMvt->getAmount();
                } else {
                    $solde += $enyMvt->getAmount();
                }
                $p ++;
            }            
        }
        
        $returnSolde []=number_format($solde, 2,',','.')." ".$deviseName;
        
        return implode(" ", $returnSolde);
    }

    public function getSoldeEntree():?string
    {
        return $this->getSoldeModel(1);
    }

    public function getSoldeSortie():?string
    {
        return $this->getSoldeModel(2);
    }

    public function getSolde():?string
    {
        $soldeEntree = 0.0;
        $soldeSortie = 0.0;
        $deviseNameEntree = "";
        $deviseNameSortie = "";
        $returnSoldeEntree = [];
        $returnSoldeSortie = [];
        /**@var EnyMvt $enyMvt */
        foreach ($this->enyMvts as $key => $enyMvt) {
            if ($enyMvt->getTypeMvt()->getId() == 1)
            {
                if($deviseNameEntree != $enyMvt->getDevise()->getName()) 
                {
                    if (!empty($deviseNameEntree) && $soldeEntree > 0) 
                    {
                        $returnSoldeEntree [$deviseNameEntree]=$soldeEntree;
                    }
                    $deviseNameEntree = $enyMvt->getDevise()->getName();
                    $soldeEntree  = $enyMvt->getAmount();
                } else {
                    $soldeEntree += $enyMvt->getAmount();
                }
                
            }          
        }
        $returnSoldeEntree [$deviseNameEntree]=$soldeEntree;

        foreach ($this->enyMvts as $key => $enyMvt) {
            if ($enyMvt->getTypeMvt()->getId() == 2) {
                if($deviseNameSortie != $enyMvt->getDevise()->getName()) 
                {
                    if (!empty($deviseNameSortie) && $soldeSortie > 0) 
                    {
                        $returnSoldeSortie [$deviseNameSortie]=$soldeSortie;
                    }
                    $deviseNameSortie = $enyMvt->getDevise()->getName();
                    $soldeSortie  = $enyMvt->getAmount();
                } else {
                    $soldeSortie += $enyMvt->getAmount();
                }
            }
        }
        $returnSoldeSortie [$deviseNameSortie]=$soldeSortie;
        
        $returnSolde = [];
        $t = 0;
        foreach ($returnSoldeEntree as $k => $v) {
            $t = 0;
            foreach ($returnSoldeSortie as $k2 => $v2) {
                if ($k2 === $k) 
                {
                    $returnSolde [] = number_format($v - $v2,2,',','.' ).' '.$k;
                    $t ++;
                }
            }
            if ($t == 0) {$returnSolde [] = number_format($v,2,',','.' ).' '.$k;}
        }
        
        return implode(" ", $returnSolde);
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
            $enyMvt->setRubrique($this);
        }

        return $this;
    }

    public function removeEnyMvt(EnyMvt $enyMvt): self
    {
        if ($this->enyMvts->contains($enyMvt)) {
            $this->enyMvts->removeElement($enyMvt);
            // set the owning side to null (unless already changed)
            if ($enyMvt->getRubrique() === $this) {
                $enyMvt->setRubrique(null);
            }
        }

        return $this;
    }

    public function getClasseRecrutement(): ?bool
    {
        return $this->classe_recrutement;
    }

    public function setClasseRecrutement(?bool $classe_recrutement): self
    {
        $this->classe_recrutement = $classe_recrutement;

        return $this;
    }

    public function getClasseMontante(): ?bool
    {
        return $this->classe_montante;
    }

    public function setClasseMontante(?bool $classe_montante): self
    {
        $this->classe_montante = $classe_montante;

        return $this;
    }

    /**
     * @return Collection|EnyMotif[]
     */
    public function getMotifs(): Collection
    {
        return $this->motifs;
    }

    public function addMotif(EnyMotif $motif): self
    {
        if (!$this->motifs->contains($motif)) {
            $this->motifs[] = $motif;
        }

        return $this;
    }

    public function removeMotif(EnyMotif $motif): self
    {
        if ($this->motifs->contains($motif)) {
            $this->motifs->removeElement($motif);
        }

        return $this;
    }

    /**
     * Get liste des motifs
     *
     * @return Collection|EnyMotif[]
     */ 
    public function getEnyMotifs():Collection
    {
        return $this->enyMotifs;
    }

    /**
     * Set liste des motifs
     *
     * @param  EnyMotif[]  $enyMotifs  Liste des motifs
     *
     * @return  self
     */ 
    public function setEnyMotifs($enyMotifs)
    {
        $this->enyMotifs = $enyMotifs;

        return $this;
    }
}
