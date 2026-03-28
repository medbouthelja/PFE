<?php

namespace App\Entity;

use App\Repository\CloudConsumptionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CloudConsumptionRepository::class)]
#[ORM\Table(name: 'cloud_consumptions')]
class CloudConsumption
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Project $project = null;

    #[ORM\Column(length: 32)]
    private string $month = '';

    #[ORM\Column(type: Types::FLOAT)]
    private float $cpu = 0;

    #[ORM\Column(type: Types::FLOAT)]
    private float $storage = 0;

    #[ORM\Column(type: Types::FLOAT)]
    private float $network = 0;

    #[ORM\Column(type: Types::FLOAT)]
    private float $cost = 0;

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

    public function getMonth(): string
    {
        return $this->month;
    }

    public function setMonth(string $month): static
    {
        $this->month = $month;

        return $this;
    }

    public function getCpu(): float
    {
        return $this->cpu;
    }

    public function setCpu(float $cpu): static
    {
        $this->cpu = $cpu;

        return $this;
    }

    public function getStorage(): float
    {
        return $this->storage;
    }

    public function setStorage(float $storage): static
    {
        $this->storage = $storage;

        return $this;
    }

    public function getNetwork(): float
    {
        return $this->network;
    }

    public function setNetwork(float $network): static
    {
        $this->network = $network;

        return $this;
    }

    public function getCost(): float
    {
        return $this->cost;
    }

    public function setCost(float $cost): static
    {
        $this->cost = $cost;

        return $this;
    }
}
