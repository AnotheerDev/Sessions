<?php

namespace App\Entity;

use App\Repository\SessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SessionRepository::class)]
class Session
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $sessionName = null;

    #[ORM\Column]
    private ?int $nbPlace = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $startSession = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $endSession = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'sessions')]
    private Collection $sessionUser;

    #[ORM\ManyToOne(cascade: ['persist', 'remove'])]
    private ?Formation $sessionFormation = null;

    #[ORM\OneToMany(mappedBy: 'session', targetEntity: Programme::class)]
    private Collection $sessionProgramme;

    #[ORM\ManyToOne(inversedBy: 'sessions')]
    private ?Formateur $formateur = null;

    public function __construct()
    {
        $this->sessionUser = new ArrayCollection();
        $this->sessionProgramme = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSessionName(): ?string
    {
        return $this->sessionName;
    }

    public function setSessionName(string $sessionName): static
    {
        $this->sessionName = $sessionName;

        return $this;
    }

    public function getNbPlace(): ?int
    {
        return $this->nbPlace;
    }

    public function setNbPlace(int $nbPlace): static
    {
        $this->nbPlace = $nbPlace;

        return $this;
    }

    public function getStartSession(): ?\DateTimeInterface
    {
        return $this->startSession;
    }

    public function setStartSession(\DateTimeInterface $startSession): static
    {
        $this->startSession = $startSession;

        return $this;
    }

    public function getEndSession(): ?\DateTimeInterface
    {
        return $this->endSession;
    }

    public function setEndSession(\DateTimeInterface $endSession): static
    {
        $this->endSession = $endSession;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getSessionUser(): Collection
    {
        return $this->sessionUser;
    }

    public function addSessionUser(User $sessionUser): static
    {
        if (!$this->sessionUser->contains($sessionUser)) {
            $this->sessionUser->add($sessionUser);
        }

        return $this;
    }

    public function removeSessionUser(User $sessionUser): static
    {
        $this->sessionUser->removeElement($sessionUser);

        return $this;
    }

    public function getSessionFormation(): ?Formation
    {
        return $this->sessionFormation;
    }

    public function setSessionFormation(?Formation $sessionFormation): static
    {
        $this->sessionFormation = $sessionFormation;

        return $this;
    }

    /**
     * @return Collection<int, Programme>
     */
    public function getSessionProgramme(): Collection
    {
        return $this->sessionProgramme;
    }

    public function addSessionProgramme(Programme $sessionProgramme): static
    {
        if (!$this->sessionProgramme->contains($sessionProgramme)) {
            $this->sessionProgramme->add($sessionProgramme);
            $sessionProgramme->setSession($this);
        }

        return $this;
    }

    public function removeSessionProgramme(Programme $sessionProgramme): static
    {
        if ($this->sessionProgramme->removeElement($sessionProgramme)) {
            // set the owning side to null (unless already changed)
            if ($sessionProgramme->getSession() === $this) {
                $sessionProgramme->setSession(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->sessionName;
    }

    public function getFormateur(): ?Formateur
    {
        return $this->formateur;
    }

    public function setFormateur(?Formateur $formateur): static
    {
        $this->formateur = $formateur;

        return $this;
    }
}
