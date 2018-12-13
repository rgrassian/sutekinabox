<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProduitRepository")
 */
class Produit
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $nom;

    /**
     * @ORM\Column(type="float")
     */
    private $prix;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Fournisseur",
     *     inversedBy="produits")
     */
    private $fournisseur;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $statut;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Box", inversedBy="produits")
     */
    private $box;

    public function __construct()
    {
        $this->box = new ArrayCollection();
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

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getFournisseur()
    {
        return $this->fournisseur;
    }

    public function setFournisseur(int $fournisseur): self
    {
        $this->fournisseur = $fournisseur;

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

    /**
     * @return Collection|Box[]
     */
    public function getBox(): Collection
    {
        return $this->box;
    }

    public function addBox(Box $box): self
    {
        if (!$this->box->contains($box)) {
            $this->box[] = $box;
        }

        return $this;
    }

    public function removeBox(Box $box): self
    {
        if ($this->box->contains($box)) {
            $this->box->removeElement($box);
        }

        return $this;
    }
}
