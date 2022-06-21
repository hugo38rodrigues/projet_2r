<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220518172911 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE invitation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE invitation (id INT NOT NULL, inviteur_id INT DEFAULT NULL, invite_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F11D61A2EA375D06 ON invitation (inviteur_id)');
        $this->addSql('CREATE INDEX IDX_F11D61A2EA417747 ON invitation (invite_id)');
        $this->addSql('ALTER TABLE invitation ADD CONSTRAINT FK_F11D61A2EA375D06 FOREIGN KEY (inviteur_id) REFERENCES utilisateur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE invitation ADD CONSTRAINT FK_F11D61A2EA417747 FOREIGN KEY (invite_id) REFERENCES utilisateur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE invitation_id_seq CASCADE');
        $this->addSql('DROP TABLE invitation');
        $this->addSql('CREATE UNIQUE INDEX lien_utilisateur_id_ressource_id_type_key ON lien (utilisateur_id, ressource_id, type)');
    }
}
