<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CompensationCalculationLineRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompensationCalculationLineRepository::class)]
#[ApiResource]
class CompensationCalculationLine
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'compensationCalculationLines')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Employee $employee = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $workDate = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?CompensationRule $compensationRule = null;

    #[ORM\Column(length: 10)]
    private ?string $direction = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $distance = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $compensation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmployee(): ?Employee
    {
        return $this->employee;
    }

    public function setEmployee(?Employee $employee): static
    {
        $this->employee = $employee;

        return $this;
    }

    public function getWorkDate(): ?\DateTimeInterface
    {
        return $this->workDate;
    }

    public function setWorkDate(\DateTimeInterface $workDate): static
    {
        $this->workDate = $workDate;

        return $this;
    }

    public function getCompensationRule(): ?CompensationRule
    {
        return $this->compensationRule;
    }

    public function setCompensationRule(?CompensationRule $compensationRule): static
    {
        $this->compensationRule = $compensationRule;

        return $this;
    }

    public function getDirection(): ?string
    {
        return $this->direction;
    }

    public function setDirection(string $direction): static
    {
        $this->direction = $direction;

        return $this;
    }

    public function getDistance(): ?string
    {
        return $this->distance;
    }

    public function setDistance(string $distance): static
    {
        $this->distance = $distance;

        return $this;
    }
    public function getCompensation(): ?string
    {
        return $this->compensation;
    }

    public function setCompensation(string $compensation): static
    {
        $this->compensation = $compensation;

        return $this;
    }
}
