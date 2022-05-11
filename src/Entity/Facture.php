<?php

namespace App\Entity;

use App\Repository\FactureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=FactureRepository::class)
 */
class Facture
{
    /**
     * @Groups("invoice:read")
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups("invoice:read")
     * @ORM\Column(type="string", length=255)
     */
    private $ref;

    /**
     * @Groups("invoice:read")
     * @ORM\Column(type="string")
     */
    private $date;

    /**
     * @Groups("invoice:read")
     * @ORM\Column(type="string", length=255)
     */
    private $conditionDePayment;

    /**
     * @Groups("invoice:read")
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="factures")
     */
    private $clent;

    /**
     * @Groups("invoice:read")
     * @ORM\OneToMany(targetEntity=LigneFacture::class, mappedBy="facture", orphanRemoval=true, cascade={"persist"})
     */
    private $ligneFacture;

    /**
     * @Groups("invoice:read")
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $echeance;

    /**
     * @Groups("invoice:read")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $num;

    /**
     * @Groups("invoice:read")
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="factures")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @Groups("invoice:read")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $note;

    /**
     * @Groups("invoice:read")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $etat;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $paye;



    public function __construct()
    {
        $this->ligneFacture = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRef(): ?string
    {
        return $this->ref;
    }

    public function setRef(string $ref): self
    {
        $this->ref = $ref;

        return $this;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(string $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getConditionDePayment(): ?string
    {
        return $this->conditionDePayment;
    }

    public function setConditionDePayment(string $conditionDePayment): self
    {
        $this->conditionDePayment = $conditionDePayment;

        return $this;
    }

    public function getClent(): ?Client
    {
        return $this->clent;
    }

    public function setClent(?Client $clent): self
    {
        $this->clent = $clent;

        return $this;
    }

    /**
     * @return Collection|LigneFacture[]
     */
    public function getLigneFacture(): Collection
    {
        return $this->ligneFacture;
    }

    public function addLigneFacture(LigneFacture $ligneFacture): self
    {
        if (!$this->ligneFacture->contains($ligneFacture)) {
            $this->ligneFacture[] = $ligneFacture;
            $ligneFacture->setFacture($this);
        }

        return $this;
    }

    public function removeLigneFacture(LigneFacture $ligneFacture): self
    {
        if ($this->ligneFacture->removeElement($ligneFacture)) {
            // set the owning side to null (unless already changed)
            if ($ligneFacture->getFacture() === $this) {
                $ligneFacture->setFacture(null);
            }
        }

        return $this;
    }

    public function getEcheance(): ?string
    {
        return $this->echeance;
    }

    public function setEcheance(?string $echeance): self
    {
        $this->echeance = $echeance;

        return $this;
    }

    public function getNum(): ?string
    {
        return $this->num;
    }

    public function setNum(?string $num): self
    {
        $this->num = $num;

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

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(?string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getPaye(): ?bool
    {
        return $this->paye;
    }

    public function setPaye(?bool $paye): self
    {
        $this->paye = $paye;

        return $this;
    }
}