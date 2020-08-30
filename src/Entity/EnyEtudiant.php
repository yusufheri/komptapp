<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * EnyEtudiant
 *
 * @ORM\Table(name="eny_etudiant")
 * @ORM\Entity
 */
class EnyEtudiant
{
    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string", length=25, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datecreate", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $datecreate = 'CURRENT_TIMESTAMP';

    /**
     * @var string
     *
     * @ORM\Column(name="annee_acad", type="string", length=20, nullable=false)
     */
    private $anneeAcad;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nom", type="string", length=100, nullable=true)
     */
    private $nom;

    /**
     * @var string|null
     *
     * @ORM\Column(name="postnom", type="string", length=100, nullable=true)
     */
    private $postnom;

    /**
     * @var string|null
     *
     * @ORM\Column(name="prenom", type="string", length=100, nullable=true)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="sexe", type="string", length=10, nullable=false)
     */
    private $sexe;

    /**
     * @var string|null
     *
     * @ORM\Column(name="lieu_nais", type="string", length=100, nullable=true)
     */
    private $lieuNais;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_nais", type="string", length=15, nullable=true)
     */
    private $dateNais;

    /**
     * @var string|null
     *
     * @ORM\Column(name="date_nais_v", type="string", length=15, nullable=true)
     */
    private $dateNaisV;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nom_pere", type="string", length=100, nullable=true)
     */
    private $nomPere;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nom_mere", type="string", length=100, nullable=true)
     */
    private $nomMere;

    /**
     * @var string|null
     *
     * @ORM\Column(name="adresse", type="string", length=200, nullable=true)
     */
    private $adresse;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tel", type="string", length=20, nullable=true)
     */
    private $tel;

    /**
     * @var string|null
     *
     * @ORM\Column(name="premier_choix", type="string", length=100, nullable=true)
     */
    private $premierChoix;

    /**
     * @var string|null
     *
     * @ORM\Column(name="deuxieme_choix", type="string", length=100, nullable=true)
     */
    private $deuxiemeChoix;

    /**
     * @var string|null
     *
     * @ORM\Column(name="matricule", type="string", length=20, nullable=true)
     */
    private $matricule;

    /**
     * @var int|null
     *
     * @ORM\Column(name="province", type="integer", nullable=true)
     */
    private $province;

    /**
     * @var int|null
     *
     * @ORM\Column(name="num_eny_pays", type="integer", nullable=true, options={"default"="1"})
     */
    private $numEnyPays = '1';

    /**
     * @var int|null
     *
     * @ORM\Column(name="district", type="integer", nullable=true)
     */
    private $district;

    /**
     * @var int|null
     *
     * @ORM\Column(name="commune", type="integer", nullable=true)
     */
    private $commune;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="deleted_at", type="date", nullable=true)
     */
    private $deletedAt;

    /**
     * @ORM\OneToMany(targetEntity=EnyInscription::class, mappedBy="num_eny_etudiant")
     */
    private $enyInscriptions;

    /**
     * @ORM\OneToMany(targetEntity=EnyDetailImport::class, mappedBy="enyEtudiant")
     */
    private $enyDetailImports;

    public function __construct()
    {
        $this->enyInscriptions = new ArrayCollection();
        $this->enyDetailImports = new ArrayCollection();
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

    public function getId(): ?string
    {
        return $this->id;
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
     * Get the value of commune
     *
     * @return  int|null
     */ 
    public function getCommune()
    {
        return $this->commune;
    }

    /**
     * Set the value of commune
     *
     * @param  int|null  $commune
     *
     * @return  self
     */ 
    public function setCommune($commune)
    {
        $this->commune = $commune;

        return $this;
    }

    /**
     * Get the value of datecreate
     *
     * @return  \DateTime
     */ 
    public function getDatecreate()
    {
        return $this->datecreate;
    }

    /**
     * Set the value of datecreate
     *
     * @param  \DateTime  $datecreate
     *
     * @return  self
     */ 
    public function setDatecreate(\DateTime $datecreate)
    {
        $this->datecreate = $datecreate;

        return $this;
    }

    /**
     * Get the value of anneeAcad
     *
     * @return  string
     */ 
    public function getAnneeAcad()
    {
        return $this->anneeAcad;
    }

    /**
     * Set the value of anneeAcad
     *
     * @param  string  $anneeAcad
     *
     * @return  self
     */ 
    public function setAnneeAcad(string $anneeAcad)
    {
        $this->anneeAcad = $anneeAcad;

        return $this;
    }

    /**
     * Get the value of nom
     *
     * @return  string|null
     */ 
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set the value of nom
     *
     * @param  string|null  $nom
     *
     * @return  self
     */ 
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get the value of postnom
     *
     * @return  string|null
     */ 
    public function getPostnom()
    {
        return $this->postnom;
    }

    /**
     * Set the value of postnom
     *
     * @param  string|null  $postnom
     *
     * @return  self
     */ 
    public function setPostnom($postnom)
    {
        $this->postnom = $postnom;

        return $this;
    }

    /**
     * Get the value of prenom
     *
     * @return  string|null
     */ 
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set the value of prenom
     *
     * @param  string|null  $prenom
     *
     * @return  self
     */ 
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get the value of sexe
     *
     * @return  string
     */ 
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * Set the value of sexe
     *
     * @param  string  $sexe
     *
     * @return  self
     */ 
    public function setSexe(string $sexe)
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * Get the value of lieuNais
     *
     * @return  string|null
     */ 
    public function getLieuNais()
    {
        return $this->lieuNais;
    }

    /**
     * Set the value of lieuNais
     *
     * @param  string|null  $lieuNais
     *
     * @return  self
     */ 
    public function setLieuNais($lieuNais)
    {
        $this->lieuNais = $lieuNais;

        return $this;
    }

    /**
     * Get the value of dateNais
     *
     * @return  \DateTime|null
     */ 
    public function getDateNais()
    {
        return $this->dateNais;
    }

    /**
     * Set the value of dateNais
     *
     * @param  \DateTime|null  $dateNais
     *
     * @return  self
     */ 
    public function setDateNais($dateNais)
    {
        $this->dateNais = $dateNais;

        return $this;
    }

    /**
     * Get the value of dateNaisV
     *
     * @return  string|null
     */ 
    public function getDateNaisV()
    {
        return $this->dateNaisV;
    }

    /**
     * Set the value of dateNaisV
     *
     * @param  string|null  $dateNaisV
     *
     * @return  self
     */ 
    public function setDateNaisV($dateNaisV)
    {
        $this->dateNaisV = $dateNaisV;

        return $this;
    }

    /**
     * Get the value of nomPere
     *
     * @return  string|null
     */ 
    public function getNomPere()
    {
        return $this->nomPere;
    }

    /**
     * Set the value of nomPere
     *
     * @param  string|null  $nomPere
     *
     * @return  self
     */ 
    public function setNomPere($nomPere)
    {
        $this->nomPere = $nomPere;

        return $this;
    }

    /**
     * Get the value of nomMere
     *
     * @return  string|null
     */ 
    public function getNomMere()
    {
        return $this->nomMere;
    }

    /**
     * Set the value of nomMere
     *
     * @param  string|null  $nomMere
     *
     * @return  self
     */ 
    public function setNomMere($nomMere)
    {
        $this->nomMere = $nomMere;

        return $this;
    }

    /**
     * Get the value of adresse
     *
     * @return  string|null
     */ 
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set the value of adresse
     *
     * @param  string|null  $adresse
     *
     * @return  self
     */ 
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get the value of tel
     *
     * @return  string|null
     */ 
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Set the value of tel
     *
     * @param  string|null  $tel
     *
     * @return  self
     */ 
    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Get the value of premierChoix
     *
     * @return  string|null
     */ 
    public function getPremierChoix()
    {
        return $this->premierChoix;
    }

    /**
     * Set the value of premierChoix
     *
     * @param  string|null  $premierChoix
     *
     * @return  self
     */ 
    public function setPremierChoix($premierChoix)
    {
        $this->premierChoix = $premierChoix;

        return $this;
    }

    /**
     * Get the value of deuxiemeChoix
     *
     * @return  string|null
     */ 
    public function getDeuxiemeChoix()
    {
        return $this->deuxiemeChoix;
    }

    /**
     * Set the value of deuxiemeChoix
     *
     * @param  string|null  $deuxiemeChoix
     *
     * @return  self
     */ 
    public function setDeuxiemeChoix($deuxiemeChoix)
    {
        $this->deuxiemeChoix = $deuxiemeChoix;

        return $this;
    }

    /**
     * Get the value of matricule
     *
     * @return  string|null
     */ 
    public function getMatricule()
    {
        return $this->matricule;
    }

    /**
     * Set the value of matricule
     *
     * @param  string|null  $matricule
     *
     * @return  self
     */ 
    public function setMatricule($matricule)
    {
        $this->matricule = $matricule;

        return $this;
    }

    /**
     * Get the value of province
     *
     * @return  int|null
     */ 
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * Set the value of province
     *
     * @param  int|null  $province
     *
     * @return  self
     */ 
    public function setProvince($province)
    {
        $this->province = $province;

        return $this;
    }

    /**
     * Get the value of numEnyPays
     *
     * @return  int|null
     */ 
    public function getNumEnyPays()
    {
        return $this->numEnyPays;
    }

    /**
     * Set the value of numEnyPays
     *
     * @param  int|null  $numEnyPays
     *
     * @return  self
     */ 
    public function setNumEnyPays($numEnyPays)
    {
        $this->numEnyPays = $numEnyPays;

        return $this;
    }

    /**
     * Get the value of district
     *
     * @return  int|null
     */ 
    public function getDistrict()
    {
        return $this->district;
    }

    /**
     * Set the value of district
     *
     * @param  int|null  $district
     *
     * @return  self
     */ 
    public function setDistrict($district)
    {
        $this->district = $district;

        return $this;
    }

    /**
     * @return Collection|EnyInscription[]
     */
    public function getEnyInscriptions(): Collection
    {
        return $this->enyInscriptions;
    }

    public function addEnyInscription(EnyInscription $enyInscription): self
    {
        if (!$this->enyInscriptions->contains($enyInscription)) {
            $this->enyInscriptions[] = $enyInscription;
            $enyInscription->setNumEnyEtudiant($this);
        }

        return $this;
    }

    public function removeEnyInscription(EnyInscription $enyInscription): self
    {
        if ($this->enyInscriptions->contains($enyInscription)) {
            $this->enyInscriptions->removeElement($enyInscription);
            // set the owning side to null (unless already changed)
            if ($enyInscription->getNumEnyEtudiant() === $this) {
                $enyInscription->setNumEnyEtudiant(null);
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
            $enyDetailImport->setEnyEtudiant($this);
        }

        return $this;
    }

    public function removeEnyDetailImport(EnyDetailImport $enyDetailImport): self
    {
        if ($this->enyDetailImports->contains($enyDetailImport)) {
            $this->enyDetailImports->removeElement($enyDetailImport);
            // set the owning side to null (unless already changed)
            if ($enyDetailImport->getEnyEtudiant() === $this) {
                $enyDetailImport->setEnyEtudiant(null);
            }
        }

        return $this;
    }

    public function getNames():?string
    {
        return $this->nom." ".$this->postnom." ".$this->prenom;
    }
}
