<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220515205515 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE acces_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE categorie_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE commentaire_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE etat_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE file_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE lien_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE message_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE ressource_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE stat_recherche_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE utilisateur_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE acces (id INT NOT NULL, niveau INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE categorie (id INT NOT NULL, libelle VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE commentaire (id INT NOT NULL, utilisateur_id INT DEFAULT NULL, ressource_id INT DEFAULT NULL, text TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_67F068BCFB88E14F ON commentaire (utilisateur_id)');
        $this->addSql('CREATE INDEX IDX_67F068BCFC6CD52A ON commentaire (ressource_id)');
        $this->addSql('CREATE TABLE etat (id INT NOT NULL, libelle VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE file (id INT NOT NULL, ressource_id INT DEFAULT NULL, libelle VARCHAR(255) DEFAULT NULL, lien VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8C9F3610FC6CD52A ON file (ressource_id)');
        $this->addSql('CREATE TABLE lien (id INT NOT NULL, utilisateur_id INT DEFAULT NULL, ressource_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_A532B4B5FB88E14F ON lien (utilisateur_id)');
        $this->addSql('CREATE INDEX IDX_A532B4B5FC6CD52A ON lien (ressource_id)');
        $this->addSql('CREATE TABLE message (id INT NOT NULL, utilisateur_id INT DEFAULT NULL, ressource_id INT DEFAULT NULL, text TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B6BD307FFB88E14F ON message (utilisateur_id)');
        $this->addSql('CREATE INDEX IDX_B6BD307FFC6CD52A ON message (ressource_id)');
        $this->addSql('CREATE TABLE ressource (id INT NOT NULL, createur_id INT DEFAULT NULL, categorie_id INT DEFAULT NULL, etat_id INT DEFAULT NULL, acces_id INT DEFAULT NULL, titre VARCHAR(255) DEFAULT NULL, resume TEXT DEFAULT NULL, date_crea DATE DEFAULT NULL, valide BOOLEAN DEFAULT NULL, exploite BOOLEAN DEFAULT NULL, demarre BOOLEAN DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_939F454473A201E5 ON ressource (createur_id)');
        $this->addSql('CREATE INDEX IDX_939F4544BCF5E72D ON ressource (categorie_id)');
        $this->addSql('CREATE INDEX IDX_939F4544D5E86FF ON ressource (etat_id)');
        $this->addSql('CREATE INDEX IDX_939F4544FC05BFAD ON ressource (acces_id)');
        $this->addSql('CREATE TABLE stat_recherche (id INT NOT NULL, recherche VARCHAR(255) DEFAULT NULL, nbr_recherche INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE stat_recherche_utilisateur (stat_recherche_id INT NOT NULL, utilisateur_id INT NOT NULL, PRIMARY KEY(stat_recherche_id, utilisateur_id))');
        $this->addSql('CREATE INDEX IDX_1C6789A8B6D557AD ON stat_recherche_utilisateur (stat_recherche_id)');
        $this->addSql('CREATE INDEX IDX_1C6789A8FB88E14F ON stat_recherche_utilisateur (utilisateur_id)');
        $this->addSql('CREATE TABLE utilisateur (id INT NOT NULL, droit VARCHAR(255) DEFAULT NULL, nom VARCHAR(255) DEFAULT NULL, prenom VARCHAR(255) DEFAULT NULL, date_naiss DATE DEFAULT NULL, actif BOOLEAN DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCFC6CD52A FOREIGN KEY (ressource_id) REFERENCES ressource (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE file ADD CONSTRAINT FK_8C9F3610FC6CD52A FOREIGN KEY (ressource_id) REFERENCES ressource (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE lien ADD CONSTRAINT FK_A532B4B5FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE lien ADD CONSTRAINT FK_A532B4B5FC6CD52A FOREIGN KEY (ressource_id) REFERENCES ressource (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FFC6CD52A FOREIGN KEY (ressource_id) REFERENCES ressource (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ressource ADD CONSTRAINT FK_939F454473A201E5 FOREIGN KEY (createur_id) REFERENCES utilisateur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ressource ADD CONSTRAINT FK_939F4544BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ressource ADD CONSTRAINT FK_939F4544D5E86FF FOREIGN KEY (etat_id) REFERENCES etat (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ressource ADD CONSTRAINT FK_939F4544FC05BFAD FOREIGN KEY (acces_id) REFERENCES acces (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE stat_recherche_utilisateur ADD CONSTRAINT FK_1C6789A8B6D557AD FOREIGN KEY (stat_recherche_id) REFERENCES stat_recherche (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE stat_recherche_utilisateur ADD CONSTRAINT FK_1C6789A8FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE ressource DROP CONSTRAINT FK_939F4544FC05BFAD');
        $this->addSql('ALTER TABLE ressource DROP CONSTRAINT FK_939F4544BCF5E72D');
        $this->addSql('ALTER TABLE ressource DROP CONSTRAINT FK_939F4544D5E86FF');
        $this->addSql('ALTER TABLE commentaire DROP CONSTRAINT FK_67F068BCFC6CD52A');
        $this->addSql('ALTER TABLE file DROP CONSTRAINT FK_8C9F3610FC6CD52A');
        $this->addSql('ALTER TABLE lien DROP CONSTRAINT FK_A532B4B5FC6CD52A');
        $this->addSql('ALTER TABLE message DROP CONSTRAINT FK_B6BD307FFC6CD52A');
        $this->addSql('ALTER TABLE stat_recherche_utilisateur DROP CONSTRAINT FK_1C6789A8B6D557AD');
        $this->addSql('ALTER TABLE commentaire DROP CONSTRAINT FK_67F068BCFB88E14F');
        $this->addSql('ALTER TABLE lien DROP CONSTRAINT FK_A532B4B5FB88E14F');
        $this->addSql('ALTER TABLE message DROP CONSTRAINT FK_B6BD307FFB88E14F');
        $this->addSql('ALTER TABLE ressource DROP CONSTRAINT FK_939F454473A201E5');
        $this->addSql('ALTER TABLE stat_recherche_utilisateur DROP CONSTRAINT FK_1C6789A8FB88E14F');
        $this->addSql('DROP SEQUENCE acces_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE categorie_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE commentaire_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE etat_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE file_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE lien_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE message_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE ressource_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE stat_recherche_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE utilisateur_id_seq CASCADE');
        $this->addSql('DROP TABLE acces');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE etat');
        $this->addSql('DROP TABLE file');
        $this->addSql('DROP TABLE lien');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE ressource');
        $this->addSql('DROP TABLE stat_recherche');
        $this->addSql('DROP TABLE stat_recherche_utilisateur');
        $this->addSql('DROP TABLE utilisateur');
    }
}
