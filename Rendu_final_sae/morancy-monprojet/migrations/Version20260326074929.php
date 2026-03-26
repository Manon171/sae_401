<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260326074929 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE departement DROP nom_region, CHANGE code_region code_region VARCHAR(3) NOT NULL');
        $this->addSql('ALTER TABLE region CHANGE code code VARCHAR(3) NOT NULL');
        $this->addSql('ALTER TABLE statistique_logement CHANGE annee_publication annee_publication INT DEFAULT NULL, CHANGE densite_population densite_population DOUBLE PRECISION DEFAULT NULL, CHANGE variation_population_10_ans variation_population_10_ans DOUBLE PRECISION DEFAULT NULL, CHANGE contribution_solde_naturel contribution_solde_naturel DOUBLE PRECISION DEFAULT NULL, CHANGE contribution_solde_migratoire contribution_solde_migratoire DOUBLE PRECISION DEFAULT NULL, CHANGE pourcentage_moins_20_ans pourcentage_moins_20_ans DOUBLE PRECISION DEFAULT NULL, CHANGE pourcentage_plus_60_ans pourcentage_plus_60_ans DOUBLE PRECISION DEFAULT NULL, CHANGE taux_chomage_t4 taux_chomage_t4 DOUBLE PRECISION DEFAULT NULL, CHANGE taux_pauvrete taux_pauvrete DOUBLE PRECISION DEFAULT NULL, CHANGE nombre_logements nombre_logements INT NOT NULL, CHANGE taux_logements_sociaux taux_logements_sociaux DOUBLE PRECISION DEFAULT NULL, CHANGE taux_logements_vacants taux_logements_vacants DOUBLE PRECISION DEFAULT NULL, CHANGE taux_logements_individuels taux_logements_individuels DOUBLE PRECISION DEFAULT NULL, CHANGE moyenne_annuelle_construction_neuve_10_ans moyenne_annuelle_construction_neuve_10_ans DOUBLE PRECISION DEFAULT NULL, CHANGE construction construction DOUBLE PRECISION NOT NULL, CHANGE parc_social_taux_logements_vacants parc_social_taux_logements_vacants DOUBLE PRECISION DEFAULT NULL, CHANGE parc_social_taux_logements_individuels parc_social_taux_logements_individuels DOUBLE PRECISION DEFAULT NULL, CHANGE parc_social_loyer_moyen parc_social_loyer_moyen DOUBLE PRECISION DEFAULT NULL, CHANGE parc_social_age_moyen parc_social_age_moyen DOUBLE PRECISION DEFAULT NULL, CHANGE parc_social_taux_logements_energivores parc_social_taux_logements_energivores DOUBLE PRECISION DEFAULT NULL, CHANGE code_departement code_departement VARCHAR(3) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE departement ADD nom_region VARCHAR(255) DEFAULT NULL, CHANGE code_region code_region VARCHAR(10) DEFAULT NULL');
        $this->addSql('ALTER TABLE region CHANGE code code VARCHAR(10) NOT NULL');
        $this->addSql('ALTER TABLE statistique_logement CHANGE construction construction NUMERIC(8, 2) DEFAULT NULL, CHANGE nombre_logements nombre_logements INT DEFAULT NULL, CHANGE annee_publication annee_publication SMALLINT NOT NULL, CHANGE densite_population densite_population NUMERIC(10, 2) DEFAULT NULL, CHANGE variation_population_10_ans variation_population_10_ans NUMERIC(6, 2) DEFAULT NULL, CHANGE contribution_solde_naturel contribution_solde_naturel NUMERIC(6, 2) DEFAULT NULL, CHANGE contribution_solde_migratoire contribution_solde_migratoire NUMERIC(6, 2) DEFAULT NULL, CHANGE pourcentage_moins_20_ans pourcentage_moins_20_ans NUMERIC(5, 2) DEFAULT NULL, CHANGE pourcentage_plus_60_ans pourcentage_plus_60_ans NUMERIC(5, 2) DEFAULT NULL, CHANGE taux_chomage_t4 taux_chomage_t4 NUMERIC(5, 2) DEFAULT NULL, CHANGE taux_pauvrete taux_pauvrete NUMERIC(5, 2) DEFAULT NULL, CHANGE taux_logements_sociaux taux_logements_sociaux NUMERIC(5, 2) DEFAULT NULL, CHANGE taux_logements_vacants taux_logements_vacants NUMERIC(5, 2) DEFAULT NULL, CHANGE taux_logements_individuels taux_logements_individuels NUMERIC(5, 2) DEFAULT NULL, CHANGE moyenne_annuelle_construction_neuve_10_ans moyenne_annuelle_construction_neuve_10_ans INT DEFAULT NULL, CHANGE parc_social_taux_logements_vacants parc_social_taux_logements_vacants NUMERIC(5, 2) DEFAULT NULL, CHANGE parc_social_taux_logements_individuels parc_social_taux_logements_individuels NUMERIC(5, 2) DEFAULT NULL, CHANGE parc_social_loyer_moyen parc_social_loyer_moyen NUMERIC(6, 2) DEFAULT NULL, CHANGE parc_social_age_moyen parc_social_age_moyen NUMERIC(5, 2) DEFAULT NULL, CHANGE parc_social_taux_logements_energivores parc_social_taux_logements_energivores NUMERIC(5, 2) DEFAULT NULL, CHANGE code_departement code_departement VARCHAR(3) NOT NULL');
    }
}
