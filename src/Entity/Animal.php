<?php

namespace App\Entity;

use App\Repository\AnimalRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimalRepository::class)]
class Animal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $averageSize = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Country $country = null;

    #[ORM\Column]
    private ?int $averageLifeDuration = null;

    #[ORM\Column(length: 255)]
    private ?string $martialArt = null;

    #[ORM\Column(length: 20)]
    private ?string $phoneNumber = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAverageSize(): ?int
    {
        return $this->averageSize;
    }

    public function setAverageSize(int $averageSize): self
    {
        $this->averageSize = $averageSize;

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getAverageLifeDuration(): ?int
    {
        return $this->averageLifeDuration;
    }

    public function setAverageLifeDuration(int $averageLifeDuration): self
    {
        $this->averageLifeDuration = $averageLifeDuration;

        return $this;
    }

    public function getMartialArt(): ?string
    {
        return $this->martialArt;
    }

    public function setMartialArt(string $martialArt): self
    {
        $this->martialArt = $martialArt;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }
}
