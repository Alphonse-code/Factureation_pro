<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220509063651 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, nom_client VARCHAR(255) DEFAULT NULL, prenom_client VARCHAR(255) DEFAULT NULL, tel VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, code_postal_client VARCHAR(255) DEFAULT NULL, ville_client VARCHAR(255) DEFAULT NULL, nom_rue_client VARCHAR(255) DEFAULT NULL, num_rue_client INT DEFAULT NULL, adresse_facture_client VARCHAR(255) DEFAULT NULL, numero_de_serie_client VARCHAR(255) DEFAULT NULL, pays_client VARCHAR(255) DEFAULT NULL, titre_entreprise_client VARCHAR(255) DEFAULT NULL, codition_de_paiement VARCHAR(255) DEFAULT NULL, nom_societe VARCHAR(255) DEFAULT NULL, tel2 VARCHAR(255) DEFAULT NULL, fixe VARCHAR(255) DEFAULT NULL, type TINYINT(1) DEFAULT NULL, ref VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_C7440455146F3EA3 (ref), INDEX IDX_C7440455A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE facture (id INT AUTO_INCREMENT NOT NULL, clent_id INT DEFAULT NULL, user_id INT NOT NULL, ref VARCHAR(255) NOT NULL, date VARCHAR(255) NOT NULL, condition_de_payment VARCHAR(255) NOT NULL, echeance VARCHAR(20) DEFAULT NULL, num VARCHAR(255) DEFAULT NULL, note VARCHAR(255) DEFAULT NULL, etat VARCHAR(255) DEFAULT NULL, paye TINYINT(1) DEFAULT NULL, INDEX IDX_FE8664107436228C (clent_id), INDEX IDX_FE866410A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ligne_facture (id INT AUTO_INCREMENT NOT NULL, facture_id INT NOT NULL, description VARCHAR(255) DEFAULT NULL, qt INT NOT NULL, remise INT DEFAULT NULL, total_ht DOUBLE PRECISION DEFAULT NULL, total_ttc DOUBLE PRECISION DEFAULT NULL, total_tva DOUBLE PRECISION DEFAULT NULL, pu DOUBLE PRECISION DEFAULT NULL, total_remise DOUBLE PRECISION DEFAULT NULL, tva INT DEFAULT NULL, designation VARCHAR(255) DEFAULT NULL, ref_produit VARCHAR(255) DEFAULT NULL, INDEX IDX_611F5A297F2DEE08 (facture_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, prix_uht INT NOT NULL, prix_uttc INT NOT NULL, nom_produit VARCHAR(255) NOT NULL, comment VARCHAR(255) DEFAULT NULL, prix_base VARCHAR(255) DEFAULT NULL, ref VARCHAR(255) DEFAULT NULL, tva INT DEFAULT NULL, INDEX IDX_29A5EC27A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_infos (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, logo VARCHAR(255) DEFAULT NULL, nom_entreprise VARCHAR(255) DEFAULT NULL, email_entreprise VARCHAR(255) DEFAULT NULL, num_siret VARCHAR(255) DEFAULT NULL, num_tva VARCHAR(255) DEFAULT NULL, stat_juridique VARCHAR(255) DEFAULT NULL, rcs VARCHAR(255) DEFAULT NULL, tvadefault VARCHAR(255) DEFAULT NULL, pays VARCHAR(255) DEFAULT NULL, adresse VARCHAR(255) DEFAULT NULL, code_postal VARCHAR(255) DEFAULT NULL, ville VARCHAR(255) DEFAULT NULL, site_web VARCHAR(255) DEFAULT NULL, inter_prenom VARCHAR(255) DEFAULT NULL, inter_nom VARCHAR(255) DEFAULT NULL, inter_email VARCHAR(255) DEFAULT NULL, inter_portable VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_C087935A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users_infos (id INT AUTO_INCREMENT NOT NULL, adresse VARCHAR(255) DEFAULT NULL, code_postal VARCHAR(255) DEFAULT NULL, ville VARCHAR(255) DEFAULT NULL, site_web VARCHAR(255) DEFAULT NULL, inter_prenom VARCHAR(255) DEFAULT NULL, inter_nom VARCHAR(255) DEFAULT NULL, inter_email VARCHAR(255) DEFAULT NULL, inter_portable VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE8664107436228C FOREIGN KEY (clent_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE866410A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE ligne_facture ADD CONSTRAINT FK_611F5A297F2DEE08 FOREIGN KEY (facture_id) REFERENCES facture (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_infos ADD CONSTRAINT FK_C087935A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE8664107436228C');
        $this->addSql('ALTER TABLE ligne_facture DROP FOREIGN KEY FK_611F5A297F2DEE08');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455A76ED395');
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE866410A76ED395');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27A76ED395');
        $this->addSql('ALTER TABLE user_infos DROP FOREIGN KEY FK_C087935A76ED395');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE facture');
        $this->addSql('DROP TABLE ligne_facture');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_infos');
        $this->addSql('DROP TABLE users_infos');
    }
}
