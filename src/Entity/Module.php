<?php

namespace App\Entity;

use App\Repository\ModuleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ModuleRepository::class)]
class Module
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'modules')]
    private ?Category $moduleCategory = null;

    #[ORM\OneToMany(mappedBy: 'module', targetEntity: Programme::class)]
    private Collection $programmeModule;

    public function __construct()
    {
        $this->programmeModule = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getModuleCategory(): ?Category
    {
        return $this->moduleCategory;
    }

    public function setModuleCategory(?Category $moduleCategory): static
    {
        $this->moduleCategory = $moduleCategory;

        return $this;
    }

    /**
     * @return Collection<int, Programme>
     */
    public function getProgrammeModule(): Collection
    {
        return $this->programmeModule;
    }

    public function addProgrammeModule(Programme $programmeModule): static
    {
        if (!$this->programmeModule->contains($programmeModule)) {
            $this->programmeModule->add($programmeModule);
            $programmeModule->setModule($this);
        }

        return $this;
    }

    public function removeProgrammeModule(Programme $programmeModule): static
    {
        if ($this->programmeModule->removeElement($programmeModule)) {
            // set the owning side to null (unless already changed)
            if ($programmeModule->getModule() === $this) {
                $programmeModule->setModule(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }
}
