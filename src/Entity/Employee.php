<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\EmployeeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource()]
#[ORM\Entity(repositoryClass: EmployeeRepository::class)]
class Employee
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'employees')]
    private ?Transport $transport = null;

    #[ORM\Column(nullable: true)]
    private ?float $distanceFromHome = null;

    #[ORM\Column]
    private ?float $workdays = null;

    /**
     * @var Collection<int, CompensationCalculationLine>
     */
    #[ORM\OneToMany(targetEntity: CompensationCalculationLine::class, mappedBy: 'employee', orphanRemoval: true)]
    private Collection $compensationCalculationLines;

    public function __construct()
    {
        $this->compensationCalculationLines = new ArrayCollection();
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

    public function getTransport(): ?Transport
    {
        return $this->transport;
    }

    public function setTransport(?Transport $transport): static
    {
        $this->transport = $transport;

        return $this;
    }

    public function getDistanceFromHome(): ?float
    {
        return $this->distanceFromHome;
    }

    public function setDistanceFromHome(?float $distanceFromHome): static
    {
        $this->distanceFromHome = $distanceFromHome;

        return $this;
    }

    public function getWorkdays(): ?float
    {
        return $this->workdays;
    }

    public function setWorkdays(float $workdays): static
    {
        $this->workdays = $workdays;

        return $this;
    }

    /**
     * @return Collection<int, CompensationCalculationLine>
     */
    public function getCompensationCalculationLines(): Collection
    {
        return $this->compensationCalculationLines;
    }

    public function addCompensationCalculationLine(CompensationCalculationLine $compensationCalculationLine): static
    {
        if (!$this->compensationCalculationLines->contains($compensationCalculationLine)) {
            $this->compensationCalculationLines->add($compensationCalculationLine);
            $compensationCalculationLine->setEmployee($this);
        }

        return $this;
    }

    public function removeCompensationCalculationLine(CompensationCalculationLine $compensationCalculationLine): static
    {
        if ($this->compensationCalculationLines->removeElement($compensationCalculationLine)) {
            // set the owning side to null (unless already changed)
            if ($compensationCalculationLine->getEmployee() === $this) {
                $compensationCalculationLine->setEmployee(null);
            }
        }

        return $this;
    }
}
