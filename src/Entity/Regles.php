<?php

namespace App\Entity;

use App\Repository\ReglesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReglesRepository::class)
 */
class Regles
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
    private $nom;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbr_postulation;

    /**
     * @ORM\Column(type="integer")
     */
    private $duree_expiration;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="regles")
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }
    
    public function getNbrPostulation(): ?int
    {
        return $this->nbr_postulation;
    }

    public function setNbrPostulation(int $nbr_postulation): self
    {
        $this->nbr_postulation = $nbr_postulation;

        return $this;
    }

    public function getDureeExpiration(): ?int
    {
        return $this->duree_expiration;
    }

    public function setDureeExpiration(int $duree_expiration): self
    {
        $this->duree_expiration = $duree_expiration;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setRegles($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getRegles() === $this) {
                $user->setRegles(null);
            }
        }

        return $this;
    }

    public function __toString(){
        if (is_null($this->nom)) {
            return 'NULL';
        } else {
            return $this->nom;    
        }
    }
}
