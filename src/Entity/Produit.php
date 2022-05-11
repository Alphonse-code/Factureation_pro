<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ProduitRepository::class)
 */
class Produit
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("produit:read")
     */
    private $id;

    /**
     * @Groups("produit:read")
     * @ORM\Column(type="integer")
     */
    private $prixUHT;

    /**
     * @Groups("produit:read")
     * @ORM\Column(type="integer")
     */
    private $prixUTTC;

    /**
     * @Groups("produit:read")
     * @ORM\Column(type="string", length=255)
     */
    private $nomProduit;

    /**
     * @Groups("produit:read")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $comment;

    /**
     * @Groups("produit:read")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $prixBase;

    /**
     * @Groups("produit:read")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ref;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="produits")
     */
    private $user;

    /**
     * @Groups("produit:read")
     * @ORM\Column(type="integer", nullable=true)
     */
    private $tva;


    public function __construct()
    {
        $this->tva = 0;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrixUHT(): ?int
    {
        return $this->prixUHT;
    }

    public function setPrixUHT(int $prixUHT): self
    {
        $this->prixUHT = $prixUHT;

        return $this;
    }

    public function getPrixUTTC(): ?int
    {
        return $this->prixUTTC;
    }

    public function setPrixUTTC(int $prixUTTC): self
    {
        $this->prixUTTC = $prixUTTC;

        return $this;
    }

    public function getNomProduit(): ?string
    {
        return $this->nomProduit;
    }

    public function setNomProduit(string $nomProduit): self
    {
        $this->nomProduit = $nomProduit;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getPrixBase(): ?string
    {
        return $this->prixBase;
    }

    public function setPrixBase(?string $prixBase): self
    {
        $this->prixBase = $prixBase;

        return $this;
    }


    public function getRef(): ?string
    {
        return $this->ref;
    }

    public function setRef(?string $ref): self
    {
        $this->ref = $ref;

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

    public function getTva(): ?int
    {
        return $this->tva;
    }

    public function setTva(?int $tva): self
    {
        $this->tva = $tva;

        return $this;
    }
}