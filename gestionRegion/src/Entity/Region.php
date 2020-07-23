<?php

namespace App\Entity;

use App\Entity\Depart;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use App\Repository\RegionRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=RegionRepository::class)
 * @UniqueEntity(
 * fields={"code"},
 * message="Le code doit être unique"
 * )
 */
class Region
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"region::read","region::read_all"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le Nom est obligatoire")
     * @Groups({"region::read","region::read_all"})
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le Code est obligatoire")
     * @Groups({"region::read","region::read_all"})
     */
    private $code;

    /**
     * @ORM\OneToMany(targetEntity=Depart::class, mappedBy="region")
     * @Groups({"region::read_all"})
     */
    private $departs;

    public function __construct()
    {
        $this->departs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return Collection|Depart[]
     */
    public function getDeparts(): Collection
    {
        return $this->departs;
    }

    public function addDepart(Depart $depart): self
    {
        if (!$this->departs->contains($depart)) {
            $this->departs[] = $depart;
            $depart->setRegion($this);
        }

        return $this;
    }

    public function removeDepart(Depart $depart): self
    {
        if ($this->departs->contains($depart)) {
            $this->departs->removeElement($depart);
            // set the owning side to null (unless already changed)
            if ($depart->getRegion() === $this) {
                $depart->setRegion(null);
            }
        }

        return $this;
    }
}
