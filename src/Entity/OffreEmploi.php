<?php

namespace App\Entity;

use App\Repository\OffreEmploiRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OffreEmploiRepository::class)
 */
class OffreEmploi
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Nom_offre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Description;

    /**
     * @ORM\Column(type="date")
     */
    private $Date_Debut;

    /**
     * @ORM\Column(type="date")
     */
    private $Date_Fin;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Exigences;

    /**
     * @ORM\Column(type="integer")
     */
    private $Nbr_Places;

    /**
     * @ORM\ManyToOne(targetEntity=CategorieOffre::class, inversedBy="offreEmplois")
     * @ORM\JoinColumn(nullable=false)
     */
    private $CategorieOffre;

    /**
     * @ORM\OneToMany(targetEntity=Candidature::class, mappedBy="OffreEmploi")
     */
    private $candidatures;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="offreEmplois")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_recruteur;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $responsabilites;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $benefices;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $statut;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $location;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $salaire;

    public function __construct()
    {
        $this->candidatures = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomOffre(): ?string
    {
        return $this->Nom_offre;
    }

    public function setNomOffre(string $Nom_offre): self
    {
        $this->Nom_offre = $Nom_offre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->Date_Debut;
    }

    public function setDateDebut(\DateTimeInterface $Date_Debut): self
    {
        $this->Date_Debut = $Date_Debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->Date_Fin;
    }

    public function setDateFin(\DateTimeInterface $Date_Fin): self
    {
        $this->Date_Fin = $Date_Fin;

        return $this;
    }

    public function getExigences(): ?string
    {
        return $this->Exigences;
    }

    public function setExigences(string $Exigences): self
    {
        $this->Exigences = $Exigences;

        return $this;
    }

    public function getNbrPlaces(): ?int
    {
        return $this->Nbr_Places;
    }

    public function setNbrPlaces(int $Nbr_Places): self
    {
        $this->Nbr_Places = $Nbr_Places;

        return $this;
    }

    public function getCategorieOffre(): ?CategorieOffre
    {
        return $this->CategorieOffre;
    }

    public function setCategorieOffre(?CategorieOffre $CategorieOffre): self
    {
        $this->CategorieOffre = $CategorieOffre;

        return $this;
    }

    /**
     * @return Collection|Candidature[]
     */
    public function getCandidatures(): Collection
    {
        return $this->candidatures;
    }

    public function addCandidature(Candidature $candidature): self
    {
        if (!$this->candidatures->contains($candidature)) {
            $this->candidatures[] = $candidature;
            $candidature->setOffreEmploi($this);
        }

        return $this;
    }

    public function removeCandidature(Candidature $candidature): self
    {
        if ($this->candidatures->removeElement($candidature)) {
            // set the owning side to null (unless already changed)
            if ($candidature->getOffreEmploi() === $this) {
                $candidature->setOffreEmploi(null);
            }
        }

        return $this;
    }

    public function getIdRecruteur(): ?User
    {
        return $this->id_recruteur;
    }

    public function setIdRecruteur(?User $id_recruteur): self
    {
        $this->id_recruteur = $id_recruteur;

        return $this;
    }

    public function getResponsabilites(): ?string
    {
        return $this->responsabilites;
    }

    public function setResponsabilites(?string $responsabilites): self
    {
        $this->responsabilites = $responsabilites;

        return $this;
    }

    public function getBenefices(): ?string
    {
        return $this->benefices;
    }

    public function setBenefices(?string $benefices): self
    {
        $this->benefices = $benefices;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getSalaire(): ?string
    {
        return $this->salaire;
    }

    public function setSalaire(string $salaire): self
    {
        $this->salaire = $salaire;

        return $this;
    }


}
