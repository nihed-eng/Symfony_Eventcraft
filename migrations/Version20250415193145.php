<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250415193145 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE reponse (id_reponse INT AUTO_INCREMENT NOT NULL, reclamation_id INT NOT NULL, contenu_reponse VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_5FB6DEC72D6BA2D9 (reclamation_id), PRIMARY KEY(id_reponse)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', available_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', delivered_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC72D6BA2D9 FOREIGN KEY (reclamation_id) REFERENCES reclamation (id_reclamation)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commentaire DROP FOREIGN KEY fk_commentaire_utilisateur
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commentaire DROP FOREIGN KEY fk_commentaire_forum
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE evenement DROP FOREIGN KEY fk_evenement_salle
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE evenement DROP FOREIGN KEY fk_evenement_utilisateur
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE forum DROP FOREIGN KEY fk_forum_utilisateur
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE participation DROP FOREIGN KEY fk_participation_evenement
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE participation DROP FOREIGN KEY fk_participation_utilisateur
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE commentaire
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE evenement
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE forum
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE participation
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE payment
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commande_decoration DROP FOREIGN KEY fk_commande_decoration
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commande_decoration DROP FOREIGN KEY fk_commande_decoration_utilisateur
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commande_decoration DROP FOREIGN KEY fk_commande_decoration
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commande_decoration DROP FOREIGN KEY fk_commande_decoration_utilisateur
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commande_decoration CHANGE decoration decoration INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commande_decoration ADD CONSTRAINT FK_9FA6B1417649DA7 FOREIGN KEY (decoration) REFERENCES decoration (id_decor)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commande_decoration ADD CONSTRAINT FK_9FA6B1416B3CA4B FOREIGN KEY (id_user) REFERENCES utilisateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX fk_commande_decoration ON commande_decoration
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_9FA6B1417649DA7 ON commande_decoration (decoration)
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX fk_commande_decoration_utilisateur ON commande_decoration
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_9FA6B1416B3CA4B ON commande_decoration (id_user)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commande_decoration ADD CONSTRAINT fk_commande_decoration FOREIGN KEY (decoration) REFERENCES decoration (id_decor) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commande_decoration ADD CONSTRAINT fk_commande_decoration_utilisateur FOREIGN KEY (id_user) REFERENCES utilisateur (id) ON DELETE SET NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE decoration DROP FOREIGN KEY fk_decoration_utilisateur
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE decoration DROP FOREIGN KEY fk_decoration_utilisateur
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE decoration ADD CONSTRAINT FK_7649DA7A76ED395 FOREIGN KEY (user_id) REFERENCES utilisateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX fk_decoration_utilisateur ON decoration
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_7649DA7A76ED395 ON decoration (user_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE decoration ADD CONSTRAINT fk_decoration_utilisateur FOREIGN KEY (user_id) REFERENCES utilisateur (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE demande DROP FOREIGN KEY FK_offre_demande
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE demande DROP FOREIGN KEY fk_demande_offre
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE demande DROP FOREIGN KEY fk_demande_user
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE demande DROP FOREIGN KEY FK_offre_demande
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE demande DROP FOREIGN KEY fk_demande_offre
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE demande DROP FOREIGN KEY fk_demande_user
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE demande CHANGE description description LONGTEXT NOT NULL, CHANGE statut_demande statut_demande VARCHAR(255) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE demande ADD CONSTRAINT FK_2694D7A5AF86866F FOREIGN KEY (offre) REFERENCES offre (id_offre)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE demande ADD CONSTRAINT FK_2694D7A5A76ED395 FOREIGN KEY (user_id) REFERENCES utilisateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX fk_demande_offre ON demande
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_2694D7A5AF86866F ON demande (offre)
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX fk_demande_user ON demande
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_2694D7A5A76ED395 ON demande (user_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE demande ADD CONSTRAINT FK_offre_demande FOREIGN KEY (offre) REFERENCES offre (id_offre) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE demande ADD CONSTRAINT fk_demande_offre FOREIGN KEY (offre) REFERENCES offre (id_offre) ON DELETE SET NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE demande ADD CONSTRAINT fk_demande_user FOREIGN KEY (user_id) REFERENCES utilisateur (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE offre CHANGE description_offre description_offre LONGTEXT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE offre ADD CONSTRAINT FK_AF86866FA76ED395 FOREIGN KEY (user_id) REFERENCES utilisateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX fk_offre_utilisateur ON offre
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_AF86866FA76ED395 ON offre (user_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reclamation DROP FOREIGN KEY fk_utilisateur_reclamation
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reclamation DROP FOREIGN KEY fk_utilisateur_reclamation
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reclamation CHANGE id_reclamation id_reclamation INT AUTO_INCREMENT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reclamation ADD CONSTRAINT FK_CE6064046B3CA4B FOREIGN KEY (id_user) REFERENCES utilisateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX fk_utilisateur_reclamation ON reclamation
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_CE6064046B3CA4B ON reclamation (id_user)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reclamation ADD CONSTRAINT fk_utilisateur_reclamation FOREIGN KEY (id_user) REFERENCES utilisateur (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reservation DROP FOREIGN KEY fk_reservation_salle
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reservation DROP FOREIGN KEY fk_reservation_user
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reservation CHANGE salle salle INT DEFAULT NULL, CHANGE user_id user_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reservation ADD CONSTRAINT FK_42C849554E977E5C FOREIGN KEY (salle) REFERENCES salle (id_salle)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reservation ADD CONSTRAINT FK_42C84955A76ED395 FOREIGN KEY (user_id) REFERENCES utilisateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reset_password_request ADD selector VARCHAR(20) NOT NULL, ADD hashed_token VARCHAR(100) NOT NULL, ADD requested_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', DROP verification_code, DROP is_verified
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES utilisateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE salle DROP FOREIGN KEY fk_user_salle
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE salle DROP FOREIGN KEY fk_user_salle
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE salle CHANGE user_id user_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE salle ADD CONSTRAINT FK_4E977E5CA76ED395 FOREIGN KEY (user_id) REFERENCES utilisateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX fk_user_salle ON salle
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_4E977E5CA76ED395 ON salle (user_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE salle ADD CONSTRAINT fk_user_salle FOREIGN KEY (user_id) REFERENCES utilisateur (id) ON UPDATE CASCADE ON DELETE CASCADE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE commentaire (id_commentaire INT NOT NULL, user_id INT NOT NULL, forum_id INT NOT NULL, contenu VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, date_pub DATE NOT NULL, INDEX fk_commentaire_utilisateur (user_id), INDEX fk_commentaire_forum (forum_id), PRIMARY KEY(id_commentaire)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE evenement (id_evenement INT NOT NULL, user INT NOT NULL, salle_id INT DEFAULT NULL, titre VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, description_evenement VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, image VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, date_debut DATE NOT NULL, date_fin DATE NOT NULL, location VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, INDEX fk_evenement_utilisateur (user), INDEX fk_evenement_salle (salle_id), PRIMARY KEY(id_evenement)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE forum (id_forum INT NOT NULL, user_id INT NOT NULL, titre_forum VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, description_forum VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, date_creation DATE NOT NULL, INDEX fk_forum_utilisateur (user_id), PRIMARY KEY(id_forum)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE participation (id_participation INT NOT NULL, user_id INT NOT NULL, evenement_id INT NOT NULL, date_inscription DATE NOT NULL, statut VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, INDEX fk_participation_utilisateur (user_id), INDEX fk_participation_evenement (evenement_id), PRIMARY KEY(id_participation)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE payment (paymentId INT AUTO_INCREMENT NOT NULL, transactionId VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, amount DOUBLE PRECISION NOT NULL, email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(paymentId)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commentaire ADD CONSTRAINT fk_commentaire_utilisateur FOREIGN KEY (user_id) REFERENCES utilisateur (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commentaire ADD CONSTRAINT fk_commentaire_forum FOREIGN KEY (forum_id) REFERENCES forum (id_forum) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE evenement ADD CONSTRAINT fk_evenement_salle FOREIGN KEY (salle_id) REFERENCES salle (id_salle) ON DELETE SET NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE evenement ADD CONSTRAINT fk_evenement_utilisateur FOREIGN KEY (user) REFERENCES utilisateur (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE forum ADD CONSTRAINT fk_forum_utilisateur FOREIGN KEY (user_id) REFERENCES utilisateur (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE participation ADD CONSTRAINT fk_participation_evenement FOREIGN KEY (evenement_id) REFERENCES evenement (id_evenement) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE participation ADD CONSTRAINT fk_participation_utilisateur FOREIGN KEY (user_id) REFERENCES utilisateur (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC72D6BA2D9
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE reponse
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE messenger_messages
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commande_decoration DROP FOREIGN KEY FK_9FA6B1417649DA7
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commande_decoration DROP FOREIGN KEY FK_9FA6B1416B3CA4B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commande_decoration DROP FOREIGN KEY FK_9FA6B1417649DA7
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commande_decoration DROP FOREIGN KEY FK_9FA6B1416B3CA4B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commande_decoration CHANGE decoration decoration INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commande_decoration ADD CONSTRAINT fk_commande_decoration FOREIGN KEY (decoration) REFERENCES decoration (id_decor) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commande_decoration ADD CONSTRAINT fk_commande_decoration_utilisateur FOREIGN KEY (id_user) REFERENCES utilisateur (id) ON DELETE SET NULL
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX idx_9fa6b1417649da7 ON commande_decoration
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX fk_commande_decoration ON commande_decoration (decoration)
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX idx_9fa6b1416b3ca4b ON commande_decoration
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX fk_commande_decoration_utilisateur ON commande_decoration (id_user)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commande_decoration ADD CONSTRAINT FK_9FA6B1417649DA7 FOREIGN KEY (decoration) REFERENCES decoration (id_decor)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commande_decoration ADD CONSTRAINT FK_9FA6B1416B3CA4B FOREIGN KEY (id_user) REFERENCES utilisateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE decoration DROP FOREIGN KEY FK_7649DA7A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE decoration DROP FOREIGN KEY FK_7649DA7A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE decoration ADD CONSTRAINT fk_decoration_utilisateur FOREIGN KEY (user_id) REFERENCES utilisateur (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX idx_7649da7a76ed395 ON decoration
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX fk_decoration_utilisateur ON decoration (user_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE decoration ADD CONSTRAINT FK_7649DA7A76ED395 FOREIGN KEY (user_id) REFERENCES utilisateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A5AF86866F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A5A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A5AF86866F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A5A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE demande CHANGE description description TEXT NOT NULL, CHANGE statut_demande statut_demande VARCHAR(255) DEFAULT 'En attente' NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE demande ADD CONSTRAINT FK_offre_demande FOREIGN KEY (offre) REFERENCES offre (id_offre) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE demande ADD CONSTRAINT fk_demande_offre FOREIGN KEY (offre) REFERENCES offre (id_offre) ON DELETE SET NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE demande ADD CONSTRAINT fk_demande_user FOREIGN KEY (user_id) REFERENCES utilisateur (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX idx_2694d7a5af86866f ON demande
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX fk_demande_offre ON demande (offre)
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX idx_2694d7a5a76ed395 ON demande
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX fk_demande_user ON demande (user_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE demande ADD CONSTRAINT FK_2694D7A5AF86866F FOREIGN KEY (offre) REFERENCES offre (id_offre)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE demande ADD CONSTRAINT FK_2694D7A5A76ED395 FOREIGN KEY (user_id) REFERENCES utilisateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE offre DROP FOREIGN KEY FK_AF86866FA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE offre DROP FOREIGN KEY FK_AF86866FA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE offre CHANGE description_offre description_offre VARCHAR(255) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX idx_af86866fa76ed395 ON offre
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX fk_offre_utilisateur ON offre (user_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE offre ADD CONSTRAINT FK_AF86866FA76ED395 FOREIGN KEY (user_id) REFERENCES utilisateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reclamation DROP FOREIGN KEY FK_CE6064046B3CA4B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reclamation DROP FOREIGN KEY FK_CE6064046B3CA4B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reclamation CHANGE id_reclamation id_reclamation INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reclamation ADD CONSTRAINT fk_utilisateur_reclamation FOREIGN KEY (id_user) REFERENCES utilisateur (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX idx_ce6064046b3ca4b ON reclamation
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX fk_utilisateur_reclamation ON reclamation (id_user)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reclamation ADD CONSTRAINT FK_CE6064046B3CA4B FOREIGN KEY (id_user) REFERENCES utilisateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reservation DROP FOREIGN KEY FK_42C849554E977E5C
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reservation CHANGE salle salle INT NOT NULL, CHANGE user_id user_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reservation ADD CONSTRAINT fk_reservation_salle FOREIGN KEY (salle) REFERENCES salle (id_salle) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reservation ADD CONSTRAINT fk_reservation_user FOREIGN KEY (user_id) REFERENCES utilisateur (id) ON UPDATE CASCADE ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reset_password_request ADD verification_code VARCHAR(6) NOT NULL, ADD is_verified TINYINT(1) NOT NULL, DROP selector, DROP hashed_token, DROP requested_at
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE salle DROP FOREIGN KEY FK_4E977E5CA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE salle DROP FOREIGN KEY FK_4E977E5CA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE salle CHANGE user_id user_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE salle ADD CONSTRAINT fk_user_salle FOREIGN KEY (user_id) REFERENCES utilisateur (id) ON UPDATE CASCADE ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX idx_4e977e5ca76ed395 ON salle
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX fk_user_salle ON salle (user_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE salle ADD CONSTRAINT FK_4E977E5CA76ED395 FOREIGN KEY (user_id) REFERENCES utilisateur (id)
        SQL);
    }
}
