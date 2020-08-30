<?php

namespace App\Entity;

use App\Repository\EnyDepartementRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EnyDepartementRepository::class)
 */
class EnyDepartement
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
    private $lib;

    /**
     * @ORM\Column(type="integer")
     */
    private $num_fac;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $num_eny_etab;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deleted;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $code;

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

    public function getLib(): ?string
    {
        return $this->lib;
    }

    public function setLib(string $lib): self
    {
        $this->lib = $lib;

        return $this;
    }

    public function getNumFac(): ?int
    {
        return $this->num_fac;
    }

    public function setNumFac(int $num_fac): self
    {
        $this->num_fac = $num_fac;

        return $this;
    }

    public function getNumEnyEtab(): ?int
    {
        return $this->num_eny_etab;
    }

    public function setNumEnyEtab(?int $num_eny_etab): self
    {
        $this->num_eny_etab = $num_eny_etab;

        return $this;
    }

    public function getDeleted(): ?\DateTimeInterface
    {
        return $this->deleted;
    }

    public function setDeleted(?\DateTimeInterface $deleted): self
    {
        $this->deleted = $deleted;

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
}
