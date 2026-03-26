<?php

namespace App\Entity;

use App\Repository\StatistiqueLogementRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Departement;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: StatistiqueLogementRepository::class)]
class StatistiqueLogement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['logement'])]
    private ?int $id = null;

    #[ORM\Column(type: "float", nullable: true)]
    #[Groups(['logement'])]
    private ?float $construction = null;

    #[ORM\Column(name: "nombre_logements", type: "integer", nullable: true)]
    #[Groups(['logement'])]
    private ?int $nombreLogement = null;

    /**
     * On ajoute le Groupe 'logement' ici pour qu'Axios reçoive l'objet département
     */
    #[ORM\ManyToOne(targetEntity: Departement::class)]
    #[ORM\JoinColumn(name: "code_departement", referencedColumnName: "code", nullable: true)]
    #[Groups(['logement'])] 
    private ?Departement $departement = null;

    #[ORM\Column(name: "annee_publication", type: "integer", nullable: true)]
    #[Groups(['logement'])]
    private ?int $anneePublication = null;

    #[ORM\Column(name: "nombre_habitants", type: "integer", nullable: true)]
    #[Groups(['logement'])]
    private ?int $nombreHabitants = null;

    #[ORM\Column(name: "densite_population", type: "float", nullable: true)]
    #[Groups(['logement'])]
    private ?float $densitePopulation = null;

    #[ORM\Column(name: "variation_population_10_ans", type: "float", nullable: true)]
    #[Groups(['logement'])]
    private ?float $variationPopulation10Ans = null;

    #[ORM\Column(name: "contribution_solde_naturel", type: "float", nullable: true)]
    #[Groups(['logement'])]
    private ?float $contributionSoldeNaturel = null;

    #[ORM\Column(name: "contribution_solde_migratoire", type: "float", nullable: true)]
    #[Groups(['logement'])]
    private ?float $contributionSoldeMigratoire = null;

    #[ORM\Column(name: "pourcentage_moins_20_ans", type: "float", nullable: true)]
    #[Groups(['logement'])]
    private ?float $pourcentageMoins20Ans = null;

    #[ORM\Column(name: "pourcentage_plus_60_ans", type: "float", nullable: true)]
    #[Groups(['logement'])]
    private ?float $pourcentagePlus60Ans = null;

    #[ORM\Column(name: "taux_chomage_t4", type: "float", nullable: true)]
    #[Groups(['logement'])]
    private ?float $tauxChomageT4 = null;

    #[ORM\Column(name: "taux_pauvrete", type: "float", nullable: true)]
    #[Groups(['logement'])]
    private ?float $tauxPauvrete = null;

    #[ORM\Column(name: "nombre_residences_principales", type: "integer", nullable: true)]
    #[Groups(['logement'])]
    private ?int $nombreResidencesPrincipales = null;

    #[ORM\Column(name: "taux_logements_sociaux", type: "float", nullable: true)]
    #[Groups(['logement'])]
    private ?float $tauxLogementsSociaux = null;

    #[ORM\Column(name: "taux_logements_vacants", type: "float", nullable: true)]
    #[Groups(['logement'])]
    private ?float $tauxLogementsVacants = null;

    #[ORM\Column(name: "taux_logements_individuels", type: "float", nullable: true)]
    #[Groups(['logement'])]
    private ?float $tauxLogementsIndividuels = null;

    #[ORM\Column(name: "moyenne_annuelle_construction_neuve_10_ans", type: "float", nullable: true)]
    #[Groups(['logement'])]
    private ?float $moyenneAnnuelleConstructionNeuve10Ans = null;

    #[ORM\Column(name: "parc_social_nombre_logements", type: "integer", nullable: true)]
    #[Groups(['logement'])]
    private ?int $parcSocialNombreDeLogements = null;

    #[ORM\Column(name: "parc_social_logements_mis_location", type: "integer", nullable: true)]
    #[Groups(['logement'])]
    private ?int $parcSocialLogementsMisEnLocation = null;

    #[ORM\Column(name: "parc_social_logements_demolis", type: "integer", nullable: true)]
    #[Groups(['logement'])]
    private ?int $parcSocialLogementsDemolis = null;

    #[ORM\Column(name: "parc_social_ventes_personnes_physiques", type: "integer", nullable: true)]
    #[Groups(['logement'])]
    private ?int $parcSocialVentesADesPersonnesPhysiques = null;

    #[ORM\Column(name: "parc_social_taux_logements_vacants", type: "float", nullable: true)]
    #[Groups(['logement'])]
    private ?float $parcSocialTauxDeLogementsVacants = null;

    #[ORM\Column(name: "parc_social_taux_logements_individuels", type: "float", nullable: true)]
    #[Groups(['logement'])]
    private ?float $parcSocialTauxDeLogementsIndividuels = null;

    #[ORM\Column(name: "parc_social_loyer_moyen", type: "float", nullable: true)]
    #[Groups(['logement'])]
    private ?float $parcSocialLoyerMoyenEnEurM2Mois = null;

    #[ORM\Column(name: "parc_social_age_moyen", type: "float", nullable: true)]
    #[Groups(['logement'])]
    private ?float $parcSocialAgeMoyenDuParcEnAnnees = null;

    #[ORM\Column(name: "parc_social_taux_logements_energivores", type: "float", nullable: true)]
    #[Groups(['logement'])]
    private ?float $parcSocialTauxDeLogementsEnergivoresEFG = null;

    // ----- Getters et Setters -----

    public function getId(): ?int { return $this->id; }

    public function getConstruction(): ?float { return $this->construction; }
    public function setConstruction(?float $construction): static { $this->construction = $construction; return $this; }

    public function getNombreLogement(): ?int { return $this->nombreLogement; }
    public function setNombreLogement(?int $nombreLogement): static { $this->nombreLogement = $nombreLogement; return $this; }

    public function getDepartement(): ?Departement { return $this->departement; }
    public function setDepartement(?Departement $departement): static { $this->departement = $departement; return $this; }

    /**
     * Retourne directement le code pour React
     */
    #[Groups(['logement'])]
    public function getCodeDepartement(): ?string
    {
        return $this->departement ? $this->departement->getCode() : null;
    }

    public function getAnneePublication(): ?int { return $this->anneePublication; }
    public function setAnneePublication(?int $anneePublication): static { $this->anneePublication = $anneePublication; return $this; }

    public function getNombreHabitants(): ?int { return $this->nombreHabitants; }
    public function setNombreHabitants(?int $nombreHabitants): static { $this->nombreHabitants = $nombreHabitants; return $this; }

    public function getDensitePopulation(): ?float { return $this->densitePopulation; }
    public function setDensitePopulation(?float $densitePopulation): static { $this->densitePopulation = $densitePopulation; return $this; }

    public function getVariationPopulation10Ans(): ?float { return $this->variationPopulation10Ans; }
    public function setVariationPopulation10Ans(?float $val): static { $this->variationPopulation10Ans = $val; return $this; }

    public function getContributionSoldeNaturel(): ?float { return $this->contributionSoldeNaturel; }
    public function setContributionSoldeNaturel(?float $val): static { $this->contributionSoldeNaturel = $val; return $this; }

    public function getContributionSoldeMigratoire(): ?float { return $this->contributionSoldeMigratoire; }
    public function setContributionSoldeMigratoire(?float $val): static { $this->contributionSoldeMigratoire = $val; return $this; }

    public function getPourcentageMoins20Ans(): ?float { return $this->pourcentageMoins20Ans; }
    public function setPourcentageMoins20Ans(?float $val): static { $this->pourcentageMoins20Ans = $val; return $this; }

    public function getPourcentagePlus60Ans(): ?float { return $this->pourcentagePlus60Ans; }
    public function setPourcentagePlus60Ans(?float $val): static { $this->pourcentagePlus60Ans = $val; return $this; }

    public function getTauxChomageT4(): ?float { return $this->tauxChomageT4; }
    public function setTauxChomageT4(?float $val): static { $this->tauxChomageT4 = $val; return $this; }

    public function getTauxPauvrete(): ?float { return $this->tauxPauvrete; }
    public function setTauxPauvrete(?float $val): static { $this->tauxPauvrete = $val; return $this; }

    public function getNombreResidencesPrincipales(): ?int { return $this->nombreResidencesPrincipales; }
    public function setNombreResidencesPrincipales(?int $val): static { $this->nombreResidencesPrincipales = $val; return $this; }

    public function getTauxLogementsSociaux(): ?float { return $this->tauxLogementsSociaux; }
    public function setTauxLogementsSociaux(?float $val): static { $this->tauxLogementsSociaux = $val; return $this; }

    public function getTauxLogementsVacants(): ?float { return $this->tauxLogementsVacants; }
    public function setTauxLogementsVacants(?float $val): static { $this->tauxLogementsVacants = $val; return $this; }

    public function getTauxLogementsIndividuels(): ?float { return $this->tauxLogementsIndividuels; }
    public function setTauxLogementsIndividuels(?float $val): static { $this->tauxLogementsIndividuels = $val; return $this; }

    public function getMoyenneAnnuelleConstructionNeuve10Ans(): ?float { return $this->moyenneAnnuelleConstructionNeuve10Ans; }
    public function setMoyenneAnnuelleConstructionNeuve10Ans(?float $val): static { $this->moyenneAnnuelleConstructionNeuve10Ans = $val; return $this; }

    public function getParcSocialNombreDeLogements(): ?int { return $this->parcSocialNombreDeLogements; }
    public function setParcSocialNombreDeLogements(?int $val): static { $this->parcSocialNombreDeLogements = $val; return $this; }

    public function getParcSocialLogementsMisEnLocation(): ?int { return $this->parcSocialLogementsMisEnLocation; }
    public function setParcSocialLogementsMisEnLocation(?int $val): static { $this->parcSocialLogementsMisEnLocation = $val; return $this; }

    public function getParcSocialLogementsDemolis(): ?int { return $this->parcSocialLogementsDemolis; }
    public function setParcSocialLogementsDemolis(?int $val): static { $this->parcSocialLogementsDemolis = $val; return $this; }

    public function getParcSocialVentesAPersonnesPhysiques(): ?int { return $this->parcSocialVentesADesPersonnesPhysiques; }
    public function setParcSocialVentesAPersonnesPhysiques(?int $val): static { $this->parcSocialVentesADesPersonnesPhysiques = $val; return $this; }

    public function getParcSocialTauxDeLogementsVacants(): ?float { return $this->parcSocialTauxDeLogementsVacants; }
    public function setParcSocialTauxDeLogementsVacants(?float $val): static { $this->parcSocialTauxDeLogementsVacants = $val; return $this; }

    public function getParcSocialTauxDeLogementsIndividuels(): ?float { return $this->parcSocialTauxDeLogementsIndividuels; }
    public function setParcSocialTauxDeLogementsIndividuels(?float $val): static { $this->parcSocialTauxDeLogementsIndividuels = $val; return $this; }

    public function getParcSocialLoyerMoyenEnEurM2Mois(): ?float { return $this->parcSocialLoyerMoyenEnEurM2Mois; }
    public function setParcSocialLoyerMoyenEnEurM2Mois(?float $val): static { $this->parcSocialLoyerMoyenEnEurM2Mois = $val; return $this; }

    public function getParcSocialAgeMoyenDuParcEnAnnees(): ?float { return $this->parcSocialAgeMoyenDuParcEnAnnees; }
    public function setParcSocialAgeMoyenDuParcEnAnnees(?float $val): static { $this->parcSocialAgeMoyenDuParcEnAnnees = $val; return $this; }

    public function getParcSocialTauxDeLogementsEnergivoresEFG(): ?float { return $this->parcSocialTauxDeLogementsEnergivoresEFG; }
    public function setParcSocialTauxDeLogementsEnergivoresEFG(?float $val): static { $this->parcSocialTauxDeLogementsEnergivoresEFG = $val; return $this; }
}