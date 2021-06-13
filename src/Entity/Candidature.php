<?php

namespace App\Entity;

use App\Repository\CandidatureRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CandidatureRepository::class)
 */
class Candidature
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $Date_Creation;

    /**
     * @ORM\ManyToOne(targetEntity=OffreEmploi::class, inversedBy="candidatures")
     * @ORM\JoinColumn(nullable=false)
     */
    private $OffreEmploi;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="candidatures")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="boolean")
     */
    private $etatCandidature;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $RendezVousDateTime;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $RendezVousComment;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $RendezVousEnligne;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $RendezVousPlaceLink;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->Date_Creation;
    }

    public function setDateCreation(\DateTimeInterface $Date_Creation): self
    {
        $this->Date_Creation = $Date_Creation;

        return $this;
    }

    public function getEtatCandidature(): ?int
    {
        return $this->etatCandidature;
    }

    public function setEtatCandidature(int $etatCandidature): self
    {
        $this->etatCandidature = $etatCandidature;

        return $this;
    }

    public function getOffreEmploi(): ?OffreEmploi
    {
        return $this->OffreEmploi;
    }

    public function setOffreEmploi(?OffreEmploi $OffreEmploi): self
    {
        $this->OffreEmploi = $OffreEmploi;

        return $this;
    }

    public function getRendezVous(): ?RendezVous
    {
        return $this->Rendez_vous;
    }

    public function setRendezVous(RendezVous $Rendez_vous): self
    {
        $this->Rendez_vous = $Rendez_vous;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getRendezVousDateTime(): ?\DateTimeInterface
    {
        return $this->RendezVousDateTime;
    }

    public function setRendezVousDateTime(?\DateTimeInterface $RendezVousDateTime): self
    {
        $this->RendezVousDateTime = $RendezVousDateTime;

        return $this;
    }

    public function getRendezVousComment(): ?string
    {
        return $this->RendezVousComment;
    }

    public function setRendezVousComment(?string $RendezVousComment): self
    {
        $this->RendezVousComment = $RendezVousComment;

        return $this;
    }

    public function getRendezVousEnligne(): ?bool
    {
        return $this->RendezVousEnligne;
    }

    public function setRendezVousEnligne(?bool $RendezVousEnligne): self
    {
        $this->RendezVousEnligne = $RendezVousEnligne;

        return $this;
    }

    public function getRendezVousPlaceLink(): ?string
    {
        return $this->RendezVousPlaceLink;
    }

    public function setRendezVousPlaceLink(?string $RendezVousPlaceLink): self
    {
        $this->RendezVousPlaceLink = $RendezVousPlaceLink;

        return $this;
    }
}
