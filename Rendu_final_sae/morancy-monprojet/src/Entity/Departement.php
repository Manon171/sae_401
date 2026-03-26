<?php

namespace App\Entity;

use App\Repository\DepartementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use App\Entity\Region;

#[ORM\Entity(repositoryClass: DepartementRepository::class)]
class Departement
{
    // Clé primaire
    #[ORM\Id]
    #[ORM\Column(length: 3)]
    #[Groups(['departement'])]
    private ?string $code = null;

    #[ORM\Column(length: 255)]
    #[Groups(['departement'])]
    private ?string $nom = null;

    // Relation ManyToOne vers Region
    #[ORM\ManyToOne(targetEntity: Region::class, inversedBy: "departements")]
    #[ORM\JoinColumn(name: "code_region", referencedColumnName: "code", nullable: false)]
    private ?Region $region = null;

    /**
     * @var Collection<int, StatistiqueLogement>
     */
    #[ORM\OneToMany(targetEntity: StatistiqueLogement::class,mappedBy:'departement')]
    private Collection $statistiquesLogement;

    public function __construct()
    {
        $this->statistiquesLogement = new ArrayCollection();
    }


    // --- Getters / Setters ---
    
    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;
        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;
        return $this;
    }

    public function getRegion(): ?Region
    {
        return $this->region;
    }

    public function setRegion(?Region $region): static
    {
        $this->region = $region;
        return $this;
    }
    


}