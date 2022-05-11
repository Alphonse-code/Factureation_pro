<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 */
class Client
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("client:read")
     */
    private $id;

    /**
     * @Groups("client:read")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nomClient;

    /**
     * @Groups("client:read")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $prenomClient;

    /**
     * @Groups("client:read")
     * @ORM\Column(type="string", length=255, nullable=true, unique=true)
     */
    private $tel;

    /**
     * @Groups("client:read")
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @Groups("client:read")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $codePostalClient;

    /**
     * @Groups("client:read")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $villeClient;

    /**
     * @Groups("client:read")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nomRueClient;

    /**
     * @Groups("client:read")
     * @ORM\Column(type="integer", nullable=true)
     */
    private $numRueClient;

    /**
     * @Groups("client:read")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adresseFactureClient;

    /**
     * @Groups("client:read")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $numeroDeSerieClient;

    /**
     * @Groups("client:read")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $paysClient;


    /**
     * @Groups("client:read")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $titreEntrepriseClient;

    /**
     * @ORM\OneToMany(targetEntity=Facture::class, mappedBy="clent")
     */
    private $factures;

    /**
     * @Groups("client:read")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $coditionDePaiement;

    /**
     * @Groups("client:read")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nomSociete;

    /**
     * @Groups("client:read")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tel2;

    /**
     * @Groups("client:read")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fixe;

    /**
     * @Groups("client:read")
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="clients")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @Groups("client:read")
     * @ORM\Column(type="string", length=255, nullable=true,unique=true)
     */
    private $ref;

    public function __construct()
    {
        $this->factures = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomClient(): ?string
    {
        return $this->nomClient;
    }

    public function setNomClient(?string $nomClient): self
    {
        $this->nomClient = $nomClient;

        return $this;
    }

    public function getPrenomClient(): ?string
    {
        return $this->prenomClient;
    }

    public function setPrenomClient(?string $prenomClient): self
    {
        $this->prenomClient = $prenomClient;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(?string $tel): self
    {
        $this->tel = $tel;

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

    public function getCodePostalClient(): ?string
    {
        return $this->codePostalClient;
    }

    public function setCodePostalClient(?string $codePostalClient): self
    {
        $this->codePostalClient = $codePostalClient;

        return $this;
    }

    public function getVilleClient(): ?string
    {
        return $this->villeClient;
    }

    public function setVilleClient(?string $villeClient): self
    {
        $this->villeClient = $villeClient;

        return $this;
    }

    public function getNomRueClient(): ?string
    {
        return $this->nomRueClient;
    }

    public function setNomRueClient(?string $nomRueClient): self
    {
        $this->nomRueClient = $nomRueClient;

        return $this;
    }

    public function getNumRueClient(): ?int
    {
        return $this->numRueClient;
    }

    public function setNumRueClient(?int $numRueClient): self
    {
        $this->numRueClient = $numRueClient;

        return $this;
    }

    public function getAdresseFactureClient(): ?string
    {
        return $this->adresseFactureClient;
    }

    public function setAdresseFactureClient(?string $adresseFactureClient): self
    {
        $this->adresseFactureClient = $adresseFactureClient;

        return $this;
    }

    public function getNumeroDeSerieClient(): ?string
    {
        return $this->numeroDeSerieClient;
    }

    public function setNumeroDeSerieClient(?string $numeroDeSerieClient): self
    {
        $this->numeroDeSerieClient = $numeroDeSerieClient;

        return $this;
    }

    public function getPaysClient(): ?string
    {
        return $this->paysClient;
    }

    public function setPaysClient(?string $paysClient): self
    {
        $this->paysClient = $paysClient;

        return $this;
    }

    public function getTitreEntrepriseClient(): ?string
    {
        return $this->titreEntrepriseClient;
    }

    public function setTitreEntrepriseClient(?string $titreEntrepriseClient): self
    {
        $this->titreEntrepriseClient = $titreEntrepriseClient;

        return $this;
    }

    /**
     * @return Collection|Facture[]
     */
    public function getFactures(): Collection
    {
        return $this->factures;
    }

    public function addFacture(Facture $facture): self
    {
        if (!$this->factures->contains($facture)) {
            $this->factures[] = $facture;
            $facture->setClent($this);
        }

        return $this;
    }

    public function removeFacture(Facture $facture): self
    {
        if ($this->factures->removeElement($facture)) {
            // set the owning side to null (unless already changed)
            if ($facture->getClent() === $this) {
                $facture->setClent(null);
            }
        }

        return $this;
    }

    public function getCoditionDePaiement(): ?string
    {
        return $this->coditionDePaiement;
    }

    public function setCoditionDePaiement(?string $coditionDePaiement): self
    {
        $this->coditionDePaiement = $coditionDePaiement;

        return $this;
    }

    public function getNomSociete(): ?string
    {
        return $this->nomSociete;
    }

    public function setNomSociete(?string $nomSociete): self
    {
        $this->nomSociete = $nomSociete;

        return $this;
    }

    public function getTel2(): ?string
    {
        return $this->tel2;
    }

    public function setTel2(?string $tel2): self
    {
        $this->tel2 = $tel2;

        return $this;
    }

    public function getFixe(): ?string
    {
        return $this->fixe;
    }

    public function setFixe(?string $fixe): self
    {
        $this->fixe = $fixe;

        return $this;
    }

    public function getType(): ?bool
    {
        return $this->type;
    }

    public function setType(?bool $type): self
    {
        $this->type = $type;

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

    public function getRef(): ?string
    {
        return $this->ref;
    }

    public function setRef(?string $ref): self
    {
        $this->ref = $ref;

        return $this;
    }
}