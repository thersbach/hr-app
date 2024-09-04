<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CompensationRuleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompensationRuleRepository::class)]
#[ApiResource]
class CompensationRule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'compensationRules')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Transport $transport = null;

    #[ORM\Column]
    private ?int $distanceFrom = null;

    #[ORM\Column(nullable: true)]
    private ?int $distanceTill = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $compensation = null;

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

    public function getDistanceFrom(): ?int
    {
        return $this->distanceFrom;
    }

    public function setDistanceFrom(int $distanceFrom): static
    {
        $this->distanceFrom = $distanceFrom;

        return $this;
    }

    public function getDistanceTill(): ?int
    {
        return $this->distanceTill;
    }

    public function setDistanceTill(?int $distanceTill): static
    {
        $this->distanceTill = $distanceTill;

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
