<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220304125043 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, nom_entreprise VARCHAR(255) NOT NULL, siret VARCHAR(255) DEFAULT NULL, adresse VARCHAR(255) NOT NULL, postal INT NOT NULL, ville VARCHAR(255) NOT NULL, nom_client VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(180) NOT NULL, telephone VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image_cm (id INT AUTO_INCREMENT NOT NULL, messages_id INT NOT NULL, nom_image VARCHAR(255) NOT NULL, INDEX IDX_BE967543A5905F5A (messages_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message_cm (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(50) NOT NULL, text LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE image_cm ADD CONSTRAINT FK_BE967543A5905F5A FOREIGN KEY (messages_id) REFERENCES message_cm (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image_cm DROP FOREIGN KEY FK_BE967543A5905F5A');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE image_cm');
        $this->addSql('DROP TABLE message_cm');
        $this->addSql('ALTER TABLE messenger_messages CHANGE body body LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE headers headers LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE queue_name queue_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user CHANGE email email VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:json)\', CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
