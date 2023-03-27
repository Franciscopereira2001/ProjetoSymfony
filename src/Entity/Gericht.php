<?php

namespace App\Entity;

use App\Repository\GerichtRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GerichtRepository::class)]
class Gericht
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;


    #[ORM\Column(type: "string", length: 255)]
    private $bild;
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $beschreibund = null;

    #[ORM\Column(nullable: true)]
    private ?float $preis = null;

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


    public function getPreis(): ?float
    {
        return $this->preis;
    }

    public function setPreis(?float $preis): self
    {
        $this->preis = $preis;

        return $this;
    }

    public function getBild(): ?string
    {
        return $this->bild;
    }

    public function setBild(string $bild): self
    {
        $this->bild = $bild;

        return $this;
    }

    public function getBeschreibund(): ?string
    {
        return $this->beschreibund;
    }

    public function setBeschreibund(?string $beschreibund): self
    {
        $this->beschreibund = $beschreibund;

        return $this;
    }

}
