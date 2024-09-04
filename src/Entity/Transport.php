<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\TransportRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource()]
#[ORM\Entity(repositoryClass: TransportRepository::class)]
class Transport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Employee>
     */
    #[ORM\OneToMany(targetEntity: Employee::class, mappedBy: 'transport')]
    private Collection $employees;

    /**
     * @var Collection<int, CompensationRule>
     */
    #[ORM\OneToMany(targetEntity: CompensationRule::class, mappedBy: 'transport', orphanRemoval: true)]
    private Collection $compensationRules;

    public function __construct()
    {
        $this->employees = new ArrayCollection();
        $this->compensationRules = new ArrayCollection();
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

    /**
     * @return Collection<int, Employee>
     */
    public function getEmployees(): Collection
    {
        return $this->employees;
    }

    public function addEmployee(Employee $employee): static
    {
        if (!$this->employees->contains($employee)) {
            $this->employees->add($employee);
            $employee->setTransport($this);
        }

        return $this;
    }

    public function removeEmployee(Employee $employee): static
    {
        if ($this->employees->removeElement($employee)) {
            // set the owning side to null (unless already changed)
            if ($employee->getTransport() === $this) {
                $employee->setTransport(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CompensationRule>
     */
    public function getCompensationRules(): Collection
    {
        return $this->compensationRules;
    }

    public function addCompensationRule(CompensationRule $compensationRule): static
    {
        if (!$this->compensationRules->contains($compensationRule)) {
            $this->compensationRules->add($compensationRule);
            $compensationRule->setTransport($this);
        }

        return $this;
    }

    public function removeCompensationRule(CompensationRule $compensationRule): static
    {
        if ($this->compensationRules->removeElement($compensationRule)) {
            // set the owning side to null (unless already changed)
            if ($compensationRule->getTransport() === $this) {
                $compensationRule->setTransport(null);
            }
        }

        return $this;
    }
}
