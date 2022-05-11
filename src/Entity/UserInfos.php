<?php

namespace App\Entity;

use App\Repository\UserInfosRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=UserInfosRepository::class)
 */
class UserInfos
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("param:read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("param:read")
     */
    private $logo;

    /**
     * @Groups("param:read")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nomEntreprise;

    /**
     * @Groups("param:read")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $emailEntreprise;

    /**
     * @Groups("param:read")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $numSiret;

    /**
     * @Groups("param:read")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $numTVA;

    /**
     * @Groups("param:read")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $statJuridique;

    /**
     * @Groups("param:read")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $rcs;

    /**
     * @Groups("param:read")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $TVADefault;

    /**
     * @Groups("param:read")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pays;
    /**
     * @Groups("param:read")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adresse;

    /**
     * @Groups("param:read")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $codePostal;

    /**
     * @Groups("param:read")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ville;

    /**
     * @Groups("param:read")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $siteWeb;

    /**
     * @Groups("param:read")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $interPrenom;

    /**
     * @Groups("param:read")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $interNom;

    /**
     * @Groups("param:read")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $interEmail;

    /**
     * @Groups("param:read")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $interPortable;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="userInfos")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $user;



    public function getId(): ?int
    {
        return $this->id;
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

    public function getNomEntreprise(): ?string
    {
        return $this->nomEntreprise;
    }

    public function setNomEntreprise(?string $nomEntreprise): self
    {
        $this->nomEntreprise = $nomEntreprise;

        return $this;
    }

    public function getEmailEntreprise(): ?string
    {
        return $this->emailEntreprise;
    }

    public function setEmailEntreprise(?string $emailEntreprise): self
    {
        $this->emailEntreprise = $emailEntreprise;

        return $this;
    }

    public function getNumSiret(): ?string
    {
        return $this->numSiret;
    }

    public function setNumSiret(?string $numSiret): self
    {
        $this->numSiret = $numSiret;

        return $this;
    }

    public function getNumTVA(): ?string
    {
        return $this->numTVA;
    }

    public function setNumTVA(?string $numTVA): self
    {
        $this->numTVA = $numTVA;

        return $this;
    }

    public function getStatJuridique(): ?string
    {
        return $this->statJuridique;
    }

    public function setStatJuridique(?string $statJuridique): self
    {
        $this->statJuridique = $statJuridique;

        return $this;
    }

    public function getRcs(): ?string
    {
        return $this->rcs;
    }

    public function setRcs(?string $rcs): self
    {
        $this->rcs = $rcs;

        return $this;
    }

    public function getTVADefault(): ?string
    {
        return $this->TVADefault;
    }

    public function setTVADefault(?string $TVADefault): self
    {
        $this->TVADefault = $TVADefault;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(?string $pays): self
    {
        $this->pays = $pays;

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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(?string $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getSiteWeb(): ?string
    {
        return $this->siteWeb;
    }

    public function setSiteWeb(?string $siteWeb): self
    {
        $this->siteWeb = $siteWeb;

        return $this;
    }

    public function getInterPrenom(): ?string
    {
        return $this->interPrenom;
    }

    public function setInterPrenom(?string $interPrenom): self
    {
        $this->interPrenom = $interPrenom;

        return $this;
    }

    public function getInterNom(): ?string
    {
        return $this->interNom;
    }

    public function setInterNom(?string $interNom): self
    {
        $this->interNom = $interNom;

        return $this;
    }

    public function getInterEmail(): ?string
    {
        return $this->interEmail;
    }

    public function setInterEmail(?string $interEmail): self
    {
        $this->interEmail = $interEmail;

        return $this;
    }

    public function getInterPortable(): ?string
    {
        return $this->interPortable;
    }

    public function setInterPortable(?string $interPortable): self
    {
        $this->interPortable = $interPortable;

        return $this;
    }
}