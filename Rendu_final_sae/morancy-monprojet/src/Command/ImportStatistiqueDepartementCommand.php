<?php

namespace App\Command;

use App\Entity\Departement;
use App\Entity\StatistiqueLogement;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
   name: 'app:import:stats-logement',
   description: 'Import des statistiques logement depuis un CSV'
)]
class ImportStatistiqueLogementCommand extends Command
{
    public function __construct(private EntityManagerInterface $em)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Import des statistiques logement depuis un CSV')
            ->addArgument('file', InputArgument::REQUIRED, 'Chemin du fichier CSV');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $filePath = $input->getArgument('file');

        if (!is_readable($filePath)) {
            $output->writeln('<error>Fichier introuvable ou illisible</error>');
            return Command::FAILURE;
        }

        $handle = fopen($filePath, 'r');
        if (!$handle) {
            $output->writeln('<error>Impossible d’ouvrir le fichier</error>');
            return Command::FAILURE;
        }

        $separator = ';';
        $batchSize = 50;
        $i = 0;

        // HEADER
        $header = fgetcsv($handle, 0, $separator);
        if ($header === false) {
            $output->writeln('<error>CSV vide</error>');
            return Command::FAILURE;
        }

        $header = array_map([$this, 'normalizeHeader'], $header);

        while (($row = fgetcsv($handle, 0, $separator)) !== false) {

            // Ignore lignes vides
            if ($row === [null] || count(array_filter($row)) === 0) {
                continue;
            }

            if (count($row) !== count($header)) {
                $output->writeln('<comment>Ligne ignorée (mauvais nombre de colonnes)</comment>');
                continue;
            }

            $data = array_combine($header, $row);
            if ($data === false) {
                continue;
            }

            $rawCode = trim($data['code_departement'] ?? '');
            if ($rawCode === '') {
                continue;
            }

            $code = $this->formatCodeDepartement($rawCode);
            if ($code === null) {
                continue;
            }

            $departement = $this->em
                ->getRepository(Departement::class)
                ->find($code);

            if (!$departement) {
                $output->writeln("<comment>Département absent : $code</comment>");
                continue;
            }

            // Mise à jour des colonnes du département depuis le CSV
            $departement->setNom($data['nom_departement'] ?? $departement->getNom());
            $departement->setCodeRegion($data['code_region'] ?? null);
            $departement->setNomRegion($data['nom_region'] ?? null);
            $departement->setNombreHabitants($this->int($data['nombre_d_habitants'] ?? null));
            $departement->setDensitePopulation($this->decimal($data['densite_de_population_au_km2'] ?? null));
            $departement->setVariationPopulation($this->decimal($data['variation_de_la_population_sur_10_ans_en'] ?? null));
            $departement->setContributionSoldeNaturel($this->decimal($data['dont_contribution_du_solde_naturel_en'] ?? null));
            $departement->setContributionSoldeMigratoire($this->decimal($data['dont_contribution_du_solde_migratoire_en'] ?? null));
            $departement->setPopulationMoins20Ans($this->decimal($data['population_de_moins_de_20_ans'] ?? null));
            $departement->setPopulation60AnsEtPlus($this->decimal($data['population_de_60_ans_et_plus'] ?? null));
            $departement->setTauxChomage($this->decimal($data['taux_de_chomage_au_t4_en'] ?? null));
            $departement->setTauxPauvrete($this->decimal($data['taux_de_pauvrete_en'] ?? null));
            $departement->setNombreLogements($this->int($data['nombre_de_logements'] ?? null));
            $departement->setNombreResidencesPrincipales($this->int($data['nombre_de_residences_principales'] ?? null));
            $departement->setTauxLogementsSociaux($this->decimal($data['taux_de_logements_sociaux_en'] ?? null));
            $departement->setTauxLogementsVacants($this->decimal($data['taux_de_logements_vacants_en'] ?? null));
            $departement->setTauxLogementsIndividuels($this->decimal($data['taux_de_logements_individuels_en'] ?? null));
            $departement->setMoyenneConstruction10Ans($this->int($data['moyenne_annuelle_de_la_construction_neuve_sur_10_ans'] ?? null));

            // Création de l'entité StatistiqueLogement
            $stat = new StatistiqueLogement();
            $stat->setDepartement($departement);
            $stat->setConstruction($this->decimal($data['construction'] ?? 0));
            $stat->setNombreLogement($this->int($data['parc_social_nombre_de_logements'] ?? 0));
            $stat->setLogementsMisEnLocation($this->int($data['parc_social_logements_mis_en_location'] ?? 0));
            $stat->setLogementsDemolis($this->int($data['parc_social_logements_demolis'] ?? 0));
            $stat->setVentesPhysiques($this->int($data['parc_social_ventes_a_des_personnes_physiques'] ?? 0));
            $stat->setTauxVacants($this->decimal($data['parc_social_taux_de_logements_vacants_en'] ?? null));
            $stat->setTauxIndividuels($this->decimal($data['parc_social_taux_de_logements_individuels_en'] ?? null));
            $stat->setLoyerMoyen($this->decimal($data['parc_social_loyer_moyen_en_eur_m2_mois'] ?? null));
            $stat->setAgeMoyen($this->decimal($data['parc_social_age_moyen_du_parc_en_annees'] ?? null));
            $stat->setTauxEnergie($this->decimal($data['parc_social_taux_de_logements_energivores_e_f_g_en'] ?? null));

            $this->em->persist($departement);
            $this->em->persist($stat);

            $i++;
            if (($i % $batchSize) === 0) {
                $this->em->flush();
                $this->em->clear();
            }
        }

        $this->em->flush();
        fclose($handle);

        $output->writeln("<info>Import terminé : $i lignes</info>");

        return Command::SUCCESS;
    }

    private function normalizeHeader(string $value): string
    {
        $value = preg_replace('/^\xEF\xBB\xBF/', '', $value);
        $encoding = mb_detect_encoding($value, ['UTF-8','ISO-8859-1','Windows-1252'], true);
        if ($encoding !== 'UTF-8') {
            $value = mb_convert_encoding($value, 'UTF-8', $encoding);
        }
        $value = trim($value);
        $value = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $value);
        $value = strtolower($value);
        $value = str_replace([' ', '-', '%', '(', ')', '/', '*', ',', '€', '²', "'"], '_', $value);
        $value = preg_replace('/_+/', '_', $value);
        return trim($value, '_');
    }

    private function decimal($value): ?float
    {
        if ($value === null || $value === '') {
            return null;
        }
        return (float)str_replace(',', '.', $value);
    }

    private function int($value): ?int
    {
        if ($value === null || $value === '') {
            return null;
        }
        return (int)$value;
    }

    private function formatCodeDepartement(string $code): ?string
    {
        $code = trim($code);
        if ($code === '') {
            return null;
        }
        if (in_array($code, ['2A', '2B'])) {
            return $code;
        }
        if (strlen($code) === 3) {
            return $code;
        }
        return str_pad($code, 2, '0', STR_PAD_LEFT);
    }
}