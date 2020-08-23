<?php

namespace App\Entity;

use App\Repository\EnyEtabRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EnyEtabRepository::class)
 */
class EnyEtab
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
    private $datecreate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sigle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lib;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $website;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $logo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $licence;

    /**
     * @ORM\ManyToOne(targetEntity=EnyCatEtab::class, inversedBy="enyEtabs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $num_eny_cat_etab;

    /**
     * @ORM\ManyToOne(targetEntity=EnyPays::class, inversedBy="enyEtabs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $num_eny_pays;

    /**
     * @ORM\ManyToOne(targetEntity=EnyProvince::class, inversedBy="enyEtabs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $num_eny_province;

    /**
     * @ORM\ManyToOne(targetEntity=EnyVille::class, inversedBy="enyEtabs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $num_eny_ville;

    /**
     * @ORM\ManyToOne(targetEntity=EnyCommune::class, inversedBy="enyEtabs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $num_eny_commune;

    /**
     * @ORM\OneToMany(targetEntity=EnyPromoOrganisee::class, mappedBy="num_eny_etab")
     */
    private $enyPromoOrganisees;

    /**
     * @ORM\OneToMany(targetEntity=EnyInscription::class, mappedBy="num_eny_etab")
     */
    private $enyInscriptions;

    public function __construct()
    {
        $this->enyPromoOrganisees = new ArrayCollection();
        $this->enyInscriptions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatecreate(): ?\DateTimeInterface
    {
        return $this->datecreate;
    }

    public function setDatecreate(\DateTimeInterface $datecreate): self
    {
        $this->datecreate = $datecreate;

        return $this;
    }

    public function getSigle(): ?string
    {
        return $this->sigle;
    }

    public function setSigle(string $sigle): self
    {
        $this->sigle = $sigle;

        return $this;
    }

    public function getLib(): ?string
    {
        return $this->lib;
    }

    public function setLib(string $lib): self
    {
        $this->lib = $lib;

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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getLicence(): ?string
    {
        return $this->licence;
    }

    public function setLicence(?string $licence): self
    {
        $this->licence = $licence;

        return $this;
    }

    public function getNumEnyCatEtab(): ?EnyCatEtab
    {
        return $this->num_eny_cat_etab;
    }

    public function setNumEnyCatEtab(?EnyCatEtab $num_eny_cat_etab): self
    {
        $this->num_eny_cat_etab = $num_eny_cat_etab;

        return $this;
    }

    public function getNumEnyPays(): ?EnyPays
    {
        return $this->num_eny_pays;
    }

    public function setNumEnyPays(?EnyPays $num_eny_pays): self
    {
        $this->num_eny_pays = $num_eny_pays;

        return $this;
    }

    public function getNumEnyProvince(): ?EnyProvince
    {
        return $this->num_eny_province;
    }

    public function setNumEnyProvince(?EnyProvince $num_eny_province): self
    {
        $this->num_eny_province = $num_eny_province;

        return $this;
    }

    public function getNumEnyVille(): ?EnyVille
    {
        return $this->num_eny_ville;
    }

    public function setNumEnyVille(?EnyVille $num_eny_ville): self
    {
        $this->num_eny_ville = $num_eny_ville;

        return $this;
    }

    public function getNumEnyCommune(): ?EnyCommune
    {
        return $this->num_eny_commune;
    }

    public function setNumEnyCommune(?EnyCommune $num_eny_commune): self
    {
        $this->num_eny_commune = $num_eny_commune;

        return $this;
    }

    /**
     * @return Collection|EnyPromoOrganisee[]
     */
    public function getEnyPromoOrganisees(): Collection
    {
        return $this->enyPromoOrganisees;
    }

    public function addEnyPromoOrganisee(EnyPromoOrganisee $enyPromoOrganisee): self
    {
        if (!$this->enyPromoOrganisees->contains($enyPromoOrganisee)) {
            $this->enyPromoOrganisees[] = $enyPromoOrganisee;
            $enyPromoOrganisee->setNumEnyEtab($this);
        }

        return $this;
    }

    public function removeEnyPromoOrganisee(EnyPromoOrganisee $enyPromoOrganisee): self
    {
        if ($this->enyPromoOrganisees->contains($enyPromoOrganisee)) {
            $this->enyPromoOrganisees->removeElement($enyPromoOrganisee);
            // set the owning side to null (unless already changed)
            if ($enyPromoOrganisee->getNumEnyEtab() === $this) {
                $enyPromoOrganisee->setNumEnyEtab(null);
            }
        }

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
            $enyInscription->setNumEnyEtab($this);
        }

        return $this;
    }

    public function removeEnyInscription(EnyInscription $enyInscription): self
    {
        if ($this->enyInscriptions->contains($enyInscription)) {
            $this->enyInscriptions->removeElement($enyInscription);
            // set the owning side to null (unless already changed)
            if ($enyInscription->getNumEnyEtab() === $this) {
                $enyInscription->setNumEnyEtab(null);
            }
        }

        return $this;
    }
}
