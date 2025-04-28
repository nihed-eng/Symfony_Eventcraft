<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240308000000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Rename tables and fields to match pi database schema';
    }

    public function up(Schema $schema): void
    {
        // Rename user table to utilisateur and its fields
        $this->addSql('RENAME TABLE user TO utilisateur');
        $this->addSql('ALTER TABLE utilisateur CHANGE first_name nom VARCHAR(255)');
        $this->addSql('ALTER TABLE utilisateur CHANGE last_name prenom VARCHAR(255)');
        $this->addSql('ALTER TABLE utilisateur CHANGE profile_picture image VARCHAR(255)');
        $this->addSql('ALTER TABLE utilisateur CHANGE statut_compte status VARCHAR(20)');
        $this->addSql('ALTER TABLE utilisateur DROP email_notifications');
        $this->addSql('ALTER TABLE utilisateur DROP push_notifications');
        $this->addSql('ALTER TABLE utilisateur DROP face_data');

        // Rename response table to reponse and its fields
        $this->addSql('RENAME TABLE response TO reponse');
        $this->addSql('ALTER TABLE reponse CHANGE content contenu TEXT NOT NULL');
        $this->addSql('ALTER TABLE reponse CHANGE created_at date_creation DATETIME NOT NULL');
        $this->addSql('ALTER TABLE reponse CHANGE responded_by admin_id INT NOT NULL');
        
        // Update foreign key constraints
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_response_user');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_reponse_utilisateur FOREIGN KEY (admin_id) REFERENCES utilisateur (id)');
        
        // Update reclamation table fields and constraints
        $this->addSql('ALTER TABLE reclamation CHANGE subject sujet VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE reclamation CHANGE description description TEXT NOT NULL');
        $this->addSql('ALTER TABLE reclamation CHANGE created_at date_creation DATETIME NOT NULL');
        $this->addSql('ALTER TABLE reclamation CHANGE status etat VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_reclamation_user');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_reclamation_utilisateur FOREIGN KEY (user_id) REFERENCES utilisateur (id)');
    }

    public function down(Schema $schema): void
    {
        // Restore original table and field names
        $this->addSql('RENAME TABLE utilisateur TO user');
        $this->addSql('ALTER TABLE user CHANGE nom first_name VARCHAR(255)');
        $this->addSql('ALTER TABLE user CHANGE prenom last_name VARCHAR(255)');
        $this->addSql('ALTER TABLE user CHANGE image profile_picture VARCHAR(255)');
        $this->addSql('ALTER TABLE user CHANGE status statut_compte VARCHAR(20)');
        $this->addSql('ALTER TABLE user ADD email_notifications JSON DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD push_notifications JSON DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD face_data TEXT DEFAULT NULL');

        $this->addSql('RENAME TABLE reponse TO response');
        $this->addSql('ALTER TABLE response CHANGE contenu content TEXT NOT NULL');
        $this->addSql('ALTER TABLE response CHANGE date_creation created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE response CHANGE admin_id responded_by INT NOT NULL');

        $this->addSql('ALTER TABLE response DROP FOREIGN KEY FK_reponse_utilisateur');
        $this->addSql('ALTER TABLE response ADD CONSTRAINT FK_response_user FOREIGN KEY (responded_by) REFERENCES user (id)');

        $this->addSql('ALTER TABLE reclamation CHANGE sujet subject VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE reclamation CHANGE description description TEXT NOT NULL');
        $this->addSql('ALTER TABLE reclamation CHANGE date_creation created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE reclamation CHANGE etat status VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_reclamation_utilisateur');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_reclamation_user FOREIGN KEY (user_id) REFERENCES user (id)');
    }
}