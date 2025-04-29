<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250423173539 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DROP TABLE payment
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
            DROP INDEX fk_commentaire_utilisateur ON commentaire
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commentaire ADD id INT AUTO_INCREMENT NOT NULL, DROP id_commentaire, DROP user_id, CHANGE forum_id forum_id INT DEFAULT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC29CCBAD0 FOREIGN KEY (forum_id) REFERENCES forum (id)
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX fk_commentaire_forum ON commentaire
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_67F068BC29CCBAD0 ON commentaire (forum_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE decoration CHANGE description_decor description_decor VARCHAR(500) NOT NULL
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
            ALTER TABLE demande DROP FOREIGN KEY FK_offre_demande
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE demande DROP FOREIGN KEY fk_demande_offre
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
            ALTER TABLE demande ADD CONSTRAINT fk_demande_user FOREIGN KEY (user_id) REFERENCES utilisateur (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE demande ADD CONSTRAINT FK_offre_demande FOREIGN KEY (offre) REFERENCES offre (id_offre) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE demande ADD CONSTRAINT fk_demande_offre FOREIGN KEY (offre) REFERENCES offre (id_offre) ON DELETE SET NULL
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX fk_evenement_utilisateur ON evenement
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX fk_evenement_salle ON evenement
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE evenement CHANGE id_evenement id_evenement INT AUTO_INCREMENT NOT NULL, CHANGE titre titre VARCHAR(30) NOT NULL, CHANGE description_evenement description_evenement VARCHAR(30) NOT NULL, CHANGE image image VARCHAR(10) NOT NULL, CHANGE location location VARCHAR(20) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX fk_forum_utilisateur ON forum
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE forum ADD id INT AUTO_INCREMENT NOT NULL, DROP id_forum, DROP user_id, DROP PRIMARY KEY, ADD PRIMARY KEY (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE offre CHANGE description_offre description_offre LONGTEXT NOT NULL, CHANGE date_exp date_exp DATE DEFAULT NULL
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
            DROP INDEX fk_participation_utilisateur ON participation
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE participation CHANGE id_participation id_participation INT AUTO_INCREMENT NOT NULL, CHANGE statut statut VARCHAR(30) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE participation ADD CONSTRAINT FK_AB55E24FFD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id_evenement)
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX fk_participation_evenement ON participation
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_AB55E24FFD02F13 ON participation (evenement_id)
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
            ALTER TABLE salle CHANGE id_salle id_salle INT AUTO_INCREMENT NOT NULL, CHANGE user_id user_id INT DEFAULT NULL
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
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE payment (paymentId INT AUTO_INCREMENT NOT NULL, transactionId VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, amount DOUBLE PRECISION NOT NULL, email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(paymentId)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = '' 
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
            DROP INDEX idx_9fa6b1416b3ca4b ON commande_decoration
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX fk_commande_decoration_utilisateur ON commande_decoration (id_user)
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX idx_9fa6b1417649da7 ON commande_decoration
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX fk_commande_decoration ON commande_decoration (decoration)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commande_decoration ADD CONSTRAINT FK_9FA6B1417649DA7 FOREIGN KEY (decoration) REFERENCES decoration (id_decor)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commande_decoration ADD CONSTRAINT FK_9FA6B1416B3CA4B FOREIGN KEY (id_user) REFERENCES utilisateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commentaire MODIFY id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC29CCBAD0
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX `PRIMARY` ON commentaire
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC29CCBAD0
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commentaire ADD id_commentaire INT NOT NULL, ADD user_id INT NOT NULL, DROP id, CHANGE forum_id forum_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX fk_commentaire_utilisateur ON commentaire (user_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commentaire ADD PRIMARY KEY (id_commentaire)
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX idx_67f068bc29ccbad0 ON commentaire
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX fk_commentaire_forum ON commentaire (forum_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC29CCBAD0 FOREIGN KEY (forum_id) REFERENCES forum (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE decoration DROP FOREIGN KEY FK_7649DA7A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE decoration DROP FOREIGN KEY FK_7649DA7A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE decoration CHANGE description_decor description_decor VARCHAR(255) NOT NULL
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
            ALTER TABLE demande ADD CONSTRAINT fk_demande_user FOREIGN KEY (user_id) REFERENCES utilisateur (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE demande ADD CONSTRAINT FK_offre_demande FOREIGN KEY (offre) REFERENCES offre (id_offre) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE demande ADD CONSTRAINT fk_demande_offre FOREIGN KEY (offre) REFERENCES offre (id_offre) ON DELETE SET NULL
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX idx_2694d7a5a76ed395 ON demande
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX fk_demande_user ON demande (user_id)
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX idx_2694d7a5af86866f ON demande
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX fk_demande_offre ON demande (offre)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE demande ADD CONSTRAINT FK_2694D7A5AF86866F FOREIGN KEY (offre) REFERENCES offre (id_offre)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE demande ADD CONSTRAINT FK_2694D7A5A76ED395 FOREIGN KEY (user_id) REFERENCES utilisateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE evenement CHANGE id_evenement id_evenement INT NOT NULL, CHANGE titre titre VARCHAR(255) NOT NULL, CHANGE description_evenement description_evenement VARCHAR(255) NOT NULL, CHANGE image image VARCHAR(255) NOT NULL, CHANGE location location VARCHAR(255) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX fk_evenement_utilisateur ON evenement (user)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX fk_evenement_salle ON evenement (salle_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE forum MODIFY id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX `PRIMARY` ON forum
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE forum ADD id_forum INT NOT NULL, ADD user_id INT NOT NULL, DROP id
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX fk_forum_utilisateur ON forum (user_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE forum ADD PRIMARY KEY (id_forum)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE offre DROP FOREIGN KEY FK_AF86866FA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE offre DROP FOREIGN KEY FK_AF86866FA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE offre CHANGE description_offre description_offre VARCHAR(255) NOT NULL, CHANGE date_exp date_exp DATE NOT NULL
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
            ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24FFD02F13
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24FFD02F13
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE participation CHANGE id_participation id_participation INT NOT NULL, CHANGE statut statut VARCHAR(255) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX fk_participation_utilisateur ON participation (user_id)
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX idx_ab55e24ffd02f13 ON participation
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX fk_participation_evenement ON participation (evenement_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE participation ADD CONSTRAINT FK_AB55E24FFD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id_evenement)
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
            ALTER TABLE salle CHANGE id_salle id_salle INT NOT NULL, CHANGE user_id user_id INT NOT NULL
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
