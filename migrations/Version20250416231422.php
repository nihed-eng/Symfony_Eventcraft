<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250416231422 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE commande_decoration (id_commande INT AUTO_INCREMENT NOT NULL, decoration INT DEFAULT NULL, id_user INT DEFAULT NULL, quantité INT NOT NULL, prix DOUBLE PRECISION NOT NULL, date_commande DATE DEFAULT NULL, INDEX IDX_9FA6B1417649DA7 (decoration), INDEX IDX_9FA6B1416B3CA4B (id_user), PRIMARY KEY(id_commande)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE decoration (id_decor INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, nom_decor VARCHAR(255) NOT NULL, type_decor VARCHAR(255) NOT NULL, description_decor VARCHAR(500) NOT NULL, stock INT NOT NULL, prix DOUBLE PRECISION NOT NULL, imageDeco VARCHAR(255) DEFAULT NULL, INDEX IDX_7649DA7A76ED395 (user_id), PRIMARY KEY(id_decor)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE demande (id_demande INT AUTO_INCREMENT NOT NULL, offre INT DEFAULT NULL, user_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, statut_demande VARCHAR(255) NOT NULL, date_demande DATE NOT NULL, INDEX IDX_2694D7A5AF86866F (offre), INDEX IDX_2694D7A5A76ED395 (user_id), PRIMARY KEY(id_demande)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE evenement (id_evenement INT AUTO_INCREMENT NOT NULL, titre VARCHAR(30) NOT NULL, description_evenement VARCHAR(30) NOT NULL, image VARCHAR(10) NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, location VARCHAR(20) NOT NULL, user INT NOT NULL, salle_id INT DEFAULT NULL, PRIMARY KEY(id_evenement)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE offre (id_offre INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, titre_offre VARCHAR(255) NOT NULL, description_offre LONGTEXT NOT NULL, type_offre VARCHAR(255) NOT NULL, montant DOUBLE PRECISION NOT NULL, date_exp DATE DEFAULT NULL, evenement INT DEFAULT NULL, INDEX IDX_AF86866FA76ED395 (user_id), PRIMARY KEY(id_offre)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE participation (id_participation INT AUTO_INCREMENT NOT NULL, evenement_id INT NOT NULL, user_id INT NOT NULL, statut VARCHAR(30) NOT NULL, date_inscription DATE NOT NULL, INDEX IDX_AB55E24FFD02F13 (evenement_id), PRIMARY KEY(id_participation)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE reclamation (id_reclamation INT AUTO_INCREMENT NOT NULL, id_user INT NOT NULL, titre VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, date DATE NOT NULL, statut VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_CE6064046B3CA4B (id_user), PRIMARY KEY(id_reclamation)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE reponse (id_reponse INT AUTO_INCREMENT NOT NULL, reclamation_id INT NOT NULL, contenu_reponse VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_5FB6DEC72D6BA2D9 (reclamation_id), PRIMARY KEY(id_reponse)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE reservation (id_reservation INT AUTO_INCREMENT NOT NULL, salle INT DEFAULT NULL, user_id INT DEFAULT NULL, date_debut DATETIME NOT NULL, date_fin DATETIME NOT NULL, INDEX fk_reservation_salle (salle), INDEX fk_reservation_user (user_id), PRIMARY KEY(id_reservation)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', expires_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE salle (id_salle INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, nom_salle VARCHAR(255) NOT NULL, capacité VARCHAR(255) NOT NULL, équipement VARCHAR(255) NOT NULL, image_salle VARCHAR(255) NOT NULL, location_salle VARCHAR(255) NOT NULL, qualite VARCHAR(255) DEFAULT NULL, prix NUMERIC(10, 2) DEFAULT NULL, INDEX IDX_4E977E5CA76ED395 (user_id), PRIMARY KEY(id_salle)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, statut_compte VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', available_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', delivered_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commande_decoration ADD CONSTRAINT FK_9FA6B1417649DA7 FOREIGN KEY (decoration) REFERENCES decoration (id_decor)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commande_decoration ADD CONSTRAINT FK_9FA6B1416B3CA4B FOREIGN KEY (id_user) REFERENCES utilisateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE decoration ADD CONSTRAINT FK_7649DA7A76ED395 FOREIGN KEY (user_id) REFERENCES utilisateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE demande ADD CONSTRAINT FK_2694D7A5AF86866F FOREIGN KEY (offre) REFERENCES offre (id_offre)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE demande ADD CONSTRAINT FK_2694D7A5A76ED395 FOREIGN KEY (user_id) REFERENCES utilisateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE offre ADD CONSTRAINT FK_AF86866FA76ED395 FOREIGN KEY (user_id) REFERENCES utilisateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE participation ADD CONSTRAINT FK_AB55E24FFD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id_evenement)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reclamation ADD CONSTRAINT FK_CE6064046B3CA4B FOREIGN KEY (id_user) REFERENCES utilisateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC72D6BA2D9 FOREIGN KEY (reclamation_id) REFERENCES reclamation (id_reclamation)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reservation ADD CONSTRAINT FK_42C849554E977E5C FOREIGN KEY (salle) REFERENCES salle (id_salle)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reservation ADD CONSTRAINT FK_42C84955A76ED395 FOREIGN KEY (user_id) REFERENCES utilisateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES utilisateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE salle ADD CONSTRAINT FK_4E977E5CA76ED395 FOREIGN KEY (user_id) REFERENCES utilisateur (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE commande_decoration DROP FOREIGN KEY FK_9FA6B1417649DA7
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commande_decoration DROP FOREIGN KEY FK_9FA6B1416B3CA4B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE decoration DROP FOREIGN KEY FK_7649DA7A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A5AF86866F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A5A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE offre DROP FOREIGN KEY FK_AF86866FA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24FFD02F13
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reclamation DROP FOREIGN KEY FK_CE6064046B3CA4B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC72D6BA2D9
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reservation DROP FOREIGN KEY FK_42C849554E977E5C
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE salle DROP FOREIGN KEY FK_4E977E5CA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE commande_decoration
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE decoration
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE demande
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE evenement
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE offre
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE participation
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE reclamation
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE reponse
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE reservation
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE reset_password_request
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE salle
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE utilisateur
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE messenger_messages
        SQL);
    }
}
