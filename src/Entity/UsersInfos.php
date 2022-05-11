<?php

namespace App\Entity;

use App\Repository\UsersInfosRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UsersInfosRepository::class)
 */
class UsersInfos
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $codePostal;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $siteWeb;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $interPrenom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $interNom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $interEmail;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $interPortable;

    public function getId(): ?int
    {
        return $this->id;
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
