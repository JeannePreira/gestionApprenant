<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommuneRepository;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CommuneRepository::class)
 */
class Commune
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * Groups({"region::read_all"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * Groups({"region::read_all"})
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=255)
     * Groups({"region::read_all"})
     */
    private $nom;

    /**
     * @ORM\ManyToOne(targetEntity=Depart::class, inversedBy="communes")
     */
    private $depart;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDepart(): ?Depart
    {
        return $this->depart;
    }

    public function setDepart(?Depart $depart): self
    {
        $this->depart = $depart;

        return $this;
    }
}
