<?php

namespace App\Entity;

use App\Repository\GreenMetricRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GreenMetricRepository::class)]
#[ORM\Table(name: 'green_metrics')]
#[ORM\UniqueConstraint(name: 'uniq_project_green', columns: ['project_id'])]
class GreenMetric
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Project $project = null;

    #[ORM\Column(type: Types::INTEGER)]
    private int $energyEfficiency = 0;

    #[ORM\Column(type: Types::INTEGER)]
    private int $renewableEnergy = 0;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): static
    {
        $this->project = $project;

        return $this;
    }

    public function getEnergyEfficiency(): int
    {
        return $this->energyEfficiency;
    }

    public function setEnergyEfficiency(int $energyEfficiency): static
    {
        $this->energyEfficiency = $energyEfficiency;

        return $this;
    }

    public function getRenewableEnergy(): int
    {
        return $this->renewableEnergy;
    }

    public function setRenewableEnergy(int $renewableEnergy): static
    {
        $this->renewableEnergy = $renewableEnergy;

        return $this;
    }
}
