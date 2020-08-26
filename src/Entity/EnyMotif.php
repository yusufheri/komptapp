<?php

namespace App\Entity;

use App\Repository\EnyMotifRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EnyMotifRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(
 *      fields={"name"},
 *     message="Il existe déjà un motif portant ce libelllé."
 * 
 * )
 */
class EnyMotif
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("motif:read")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("motif:read")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups("motif:read")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Groups("motif:read")
     */
    private $name;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups("motif:read")
     */
    private $deletedAt;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups("motif:read")
     */
    private $content;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $idDetailRubrique;

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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getIdDetailRubrique(): ?int
    {
        return $this->idDetailRubrique;
    }

    public function setIdDetailRubrique(?int $idDetailRubrique): self
    {
        $this->idDetailRubrique = $idDetailRubrique;

        return $this;
    }
}
