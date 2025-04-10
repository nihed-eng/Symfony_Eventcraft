<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240229 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creates the reset_password_request table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE reset_password_request (
            id INT AUTO_INCREMENT NOT NULL,
            user_id INT NOT NULL,
            verification_code VARCHAR(6) NOT NULL,
            expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\',
            is_verified TINYINT(1) NOT NULL,
            INDEX IDX_7CE748AA76ED395 (user_id),
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        
        $this->addSql('ALTER TABLE reset_password_request 
            ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) 
            REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE reset_password_request');
    }
} 