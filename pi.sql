-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 27 mars 2025 à 14:28
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `pi`
--

-- --------------------------------------------------------

--
-- Structure de la table `commande_decoration`
--

CREATE TABLE `commande_decoration` (
  `id_commande` int(11) NOT NULL,
  `decoration` int(11) NOT NULL,
  `evenement_id` int(11) DEFAULT NULL,
  `quantité` int(11) NOT NULL,
  `prix` float NOT NULL,
  `date_commande` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `commande_decoration`
--

INSERT INTO `commande_decoration` (`id_commande`, `decoration`, `evenement_id`, `quantité`, `prix`, `date_commande`) VALUES
(1, 1, NULL, 1, 200, '2025-03-06'),
(2, 1, NULL, 3, 600, '2025-03-06');

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

CREATE TABLE `commentaire` (
  `id_commentaire` int(11) NOT NULL,
  `contenu` varchar(255) NOT NULL,
  `date_pub` date NOT NULL,
  `user_id` int(11) NOT NULL,
  `forum_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `decoration`
--

CREATE TABLE `decoration` (
  `id_decor` int(11) NOT NULL,
  `nom_decor` varchar(255) NOT NULL,
  `type_decor` varchar(255) NOT NULL,
  `description_decor` varchar(255) NOT NULL,
  `stock` int(11) NOT NULL,
  `prix` float NOT NULL,
  `imageDeco` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `decoration`
--

INSERT INTO `decoration` (`id_decor`, `nom_decor`, `type_decor`, `description_decor`, `stock`, `prix`, `imageDeco`, `user_id`) VALUES
(1, 'jghghfg', 'bhbh', 'fdfd', 0, 200, 'vIdSZT.jpg', NULL),
(2, 'tables', 'tables', 'tables', 0, 22, 'DSC_0210.jpg', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `demande_offre`
--

CREATE TABLE `demande_offre` (
  `id_demande` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `offre` int(11) NOT NULL,
  `statut_demande` varchar(255) NOT NULL,
  `date_demande` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `demande_offre`
--

INSERT INTO `demande_offre` (`id_demande`, `user`, `offre`, `statut_demande`, `date_demande`) VALUES
(4, 1, 2, 'ons', '2025-03-06');

-- --------------------------------------------------------

--
-- Structure de la table `evenement`
--

CREATE TABLE `evenement` (
  `id_evenement` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `description_evenement` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `user` int(11) NOT NULL,
  `location` varchar(255) NOT NULL,
  `salle_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `evenement`
--

INSERT INTO `evenement` (`id_evenement`, `titre`, `description_evenement`, `image`, `date_debut`, `date_fin`, `user`, `location`, `salle_id`) VALUES
(1, 'Événement 102', 'Description de l\'événement 102', 'image102.jpg', '2025-04-15', '2025-04-16', 1, 'Lyon', NULL),
(2, 'gggggggggg', 'jjjjjjjjjjjj', 'jjjjjjjj', '2025-02-05', '2025-02-20', 1, ',,,,,,,,,,,,', NULL),
(55, 'llll', 'lllllllmmmmm', 'mmmmm', '2025-02-10', '2025-02-28', 1, 'llllllllllll', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `forum`
--

CREATE TABLE `forum` (
  `id_forum` int(11) NOT NULL,
  `titre_forum` varchar(255) NOT NULL,
  `description_forum` varchar(255) NOT NULL,
  `date_creation` date NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `offre`
--

CREATE TABLE `offre` (
  `id_offre` int(11) NOT NULL,
  `titre_offre` varchar(255) NOT NULL,
  `description_offre` varchar(255) NOT NULL,
  `type_offre` varchar(255) NOT NULL,
  `montant` float NOT NULL,
  `date_exp` date NOT NULL,
  `evenement` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `rating` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `offre`
--

INSERT INTO `offre` (`id_offre`, `titre_offre`, `description_offre`, `type_offre`, `montant`, `date_exp`, `evenement`, `user_id`, `rating`) VALUES
(2, 'ahahhd', 'dsjdh', 'ddhkd', 200, '2025-02-24', 1, 1, 4),
(3, 'baff', 'sdsd', 'vcv', 300, '2025-03-12', 1, 1, 3);

-- --------------------------------------------------------

--
-- Structure de la table `participation`
--

CREATE TABLE `participation` (
  `id_participation` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `evenement_id` int(11) NOT NULL,
  `date_inscription` date NOT NULL,
  `statut` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `payment`
--

CREATE TABLE `payment` (
  `paymentId` int(11) NOT NULL,
  `transactionId` varchar(255) NOT NULL,
  `amount` double NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `payment`
--

INSERT INTO `payment` (`paymentId`, `transactionId`, `amount`, `email`) VALUES
(1, 'pi_3QzRYvGC5kHdZarF0sKTP4Bp', 200, 'ayadi.baha35@gmail.com'),
(2, 'pi_3QzZGBGC5kHdZarF0lFtbYbY', 600, 'eyazouaghi@gmail.com');

-- --------------------------------------------------------

--
-- Structure de la table `reclamation`
--

CREATE TABLE `reclamation` (
  `id_reclamation` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `statut` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reponse`
--

CREATE TABLE `reponse` (
  `id_reponse` int(11) NOT NULL,
  `contenu_reponse` varchar(255) NOT NULL,
  `reclamation_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

CREATE TABLE `reservation` (
  `id_reservation` int(11) NOT NULL,
  `salle` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_debut` datetime NOT NULL,
  `date_fin` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `reservation`
--

INSERT INTO `reservation` (`id_reservation`, `salle`, `user_id`, `date_debut`, `date_fin`) VALUES
(136, 68, 2, '2025-03-15 00:00:00', '2025-03-22 00:00:00'),
(137, 69, 2, '2028-03-18 00:00:00', '2029-03-17 00:00:00'),
(138, 63, 2, '2025-03-03 00:00:00', '2025-03-03 00:00:00'),
(139, 63, 2, '2037-02-12 00:00:00', '2037-02-12 00:00:00'),
(140, 63, 2, '2025-03-04 00:00:00', '2025-03-04 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `salle`
--

CREATE TABLE `salle` (
  `id_salle` int(11) NOT NULL,
  `nom_salle` varchar(255) NOT NULL,
  `capacité` varchar(255) NOT NULL,
  `équipement` varchar(255) NOT NULL,
  `image_salle` varchar(255) NOT NULL,
  `location_salle` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `qualite` varchar(255) DEFAULT NULL,
  `prix` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `salle`
--

INSERT INTO `salle` (`id_salle`, `nom_salle`, `capacité`, `équipement`, `image_salle`, `location_salle`, `user_id`, `qualite`, `prix`) VALUES
(63, 'Bouraoui', '600', 'projecteur', 'C:\\Users\\Asus sonicMaster\\OneDrive\\Desktop\\a.jpg', 'Carthage', 1, 'Exceptionnel', 1000.00),
(64, 'Zitouna', '600', 'aze', 'C:\\Users\\Asus sonicMaster\\OneDrive\\Desktop\\aa.jpg', 'lac2', 1, 'Très bien', 600.00),
(68, 'Salle Zwinaa', '1500', 'tous', 'C:\\Users\\Asus sonicMaster\\OneDrive\\Desktop\\aa.jpg', 'Ben Arous', 2, 'Superbe', 12000.00),
(69, 'Espace Bouraoui', '500', 'tout', 'C:\\Users\\Asus sonicMaster\\OneDrive\\Desktop\\aaa.jpg', 'Carthage', 2, 'Très bien', 12000.00),
(70, 'El Firma', '900', 'tout', 'C:\\Users\\Asus sonicMaster\\OneDrive\\Desktop\\s2.jpg', '58 rue. des Fruits Chotrana 3 Ariana', 2, 'Exceptionnel', 15000.00),
(71, 'Dar Jebal', '250', 'tous', 'D:\\3A27\\PI\\demosalle - Copie\\src\\main\\resources\\images\\Dar Jebal.jpg,D:\\3A27\\PI\\demosalle - Copie\\src\\main\\resources\\images\\Dar Mhenna Hammamet.jpg,D:\\3A27\\PI\\demosalle - Copie\\src\\main\\resources\\images\\Golden Carthage Tunis.jpg', 'Bizerte', 2, 'Superbe', 1000.00),
(72, 'Zahra', '200', 'tous', 'C:\\Users\\Baha Ayadi\\Pictures\\DSC_0210.jpg', 'ARIANA', 2, 'Très bien', 1000.00);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `statut_compte` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `id_user` int(11) NOT NULL,
  `CV` varchar(800) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`nom`, `prenom`, `password`, `statut_compte`, `role`, `email`, `id_user`, `CV`) VALUES
('Dupont', 'Jean', 'password123', 'actif', 'admin', 'jean.dupont@example.com', 1, ''),
('Nihed', 'session', 'AZERTY123azerty', 'active', 'Client', 'nihed.mathlouthi@gmail.com', 2, ''),
('Mathlouthi', 'nihed', 'GOOGLE_AUTH_USER', 'Active', 'Client', 'mathlouthinihed@gmail.com', 3, ''),
('Soumaya', 'Mchita', 'GOOGLE_AUTH_USER', 'Active', 'Client', 'soumayamchita5@gmail.com', 4, ''),
('ayadi', 'baha', 'GOOGLE_AUTH_USER', 'Active', 'Client', 'tasnimayadi75@gmail.com', 5, ''),
('baha', 'ayadi', 'ayadibaha123', 'active', 'Client', 'baha.ayadi75@gmail.com', 6, ''),
('baha', 'ayadi', 'bahaaya123', 'active', 'Admin', 'ayadi.baha35@gmail.com', 7, ''),
('ayadi', 'riadh', 'bahaaya123', 'active', 'Admin', 'riadh@gmail.com', 8, ''),
('ayadi', 'baha', 'bahaaya123', 'active', 'Client', 'baha@gmail.com', 9, ''),
('ayadi', 'baha', 'bahaaya123', 'active', 'Organisateur', 'bahaayadi3@gmail.com', 10, ''),
('ayadi', 'baha', 'bahaaya123', 'active', 'Client', 'bahaaya@gmail.com', 11, 'C:\\Users\\Baha Ayadi\\Pictures\\Camera\\505af079e2925c7d3d93e0bbd74155b1.png');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `commande_decoration`
--
ALTER TABLE `commande_decoration`
  ADD PRIMARY KEY (`id_commande`),
  ADD KEY `fk_commande_decoration` (`decoration`),
  ADD KEY `fk_commande_evenement` (`evenement_id`);

--
-- Index pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD PRIMARY KEY (`id_commentaire`),
  ADD KEY `fk_commentaire_utilisateur` (`user_id`),
  ADD KEY `fk_commentaire_forum` (`forum_id`);

--
-- Index pour la table `decoration`
--
ALTER TABLE `decoration`
  ADD PRIMARY KEY (`id_decor`),
  ADD KEY `fk_decoration_utilisateur` (`user_id`);

--
-- Index pour la table `demande_offre`
--
ALTER TABLE `demande_offre`
  ADD PRIMARY KEY (`id_demande`),
  ADD KEY `fk_demande_offre_utilisateur` (`user`),
  ADD KEY `fk_demande_offre_offre` (`offre`);

--
-- Index pour la table `evenement`
--
ALTER TABLE `evenement`
  ADD PRIMARY KEY (`id_evenement`),
  ADD KEY `fk_evenement_utilisateur` (`user`),
  ADD KEY `fk_evenement_salle` (`salle_id`);

--
-- Index pour la table `forum`
--
ALTER TABLE `forum`
  ADD PRIMARY KEY (`id_forum`),
  ADD KEY `fk_forum_utilisateur` (`user_id`);

--
-- Index pour la table `offre`
--
ALTER TABLE `offre`
  ADD PRIMARY KEY (`id_offre`),
  ADD KEY `fk_offre_utilisateur` (`user_id`),
  ADD KEY `fk_offre_evenement` (`evenement`);

--
-- Index pour la table `participation`
--
ALTER TABLE `participation`
  ADD PRIMARY KEY (`id_participation`),
  ADD KEY `fk_participation_utilisateur` (`user_id`),
  ADD KEY `fk_participation_evenement` (`evenement_id`);

--
-- Index pour la table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`paymentId`);

--
-- Index pour la table `reclamation`
--
ALTER TABLE `reclamation`
  ADD PRIMARY KEY (`id_reclamation`),
  ADD KEY `fk_utilisateur_reclamation` (`id_user`);

--
-- Index pour la table `reponse`
--
ALTER TABLE `reponse`
  ADD PRIMARY KEY (`id_reponse`),
  ADD KEY `fk_reclamation` (`reclamation_id`);

--
-- Index pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`id_reservation`),
  ADD KEY `fk_reservation_salle` (`salle`),
  ADD KEY `fk_reservation_user` (`user_id`);

--
-- Index pour la table `salle`
--
ALTER TABLE `salle`
  ADD PRIMARY KEY (`id_salle`),
  ADD KEY `fk_user_salle` (`user_id`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `commande_decoration`
--
ALTER TABLE `commande_decoration`
  MODIFY `id_commande` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `commentaire`
--
ALTER TABLE `commentaire`
  MODIFY `id_commentaire` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `decoration`
--
ALTER TABLE `decoration`
  MODIFY `id_decor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `demande_offre`
--
ALTER TABLE `demande_offre`
  MODIFY `id_demande` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `evenement`
--
ALTER TABLE `evenement`
  MODIFY `id_evenement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT pour la table `offre`
--
ALTER TABLE `offre`
  MODIFY `id_offre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `participation`
--
ALTER TABLE `participation`
  MODIFY `id_participation` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `payment`
--
ALTER TABLE `payment`
  MODIFY `paymentId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `reclamation`
--
ALTER TABLE `reclamation`
  MODIFY `id_reclamation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `reponse`
--
ALTER TABLE `reponse`
  MODIFY `id_reponse` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `id_reservation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT pour la table `salle`
--
ALTER TABLE `salle`
  MODIFY `id_salle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commande_decoration`
--
ALTER TABLE `commande_decoration`
  ADD CONSTRAINT `fk_commande_decoration` FOREIGN KEY (`decoration`) REFERENCES `decoration` (`id_decor`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_commande_evenement` FOREIGN KEY (`evenement_id`) REFERENCES `evenement` (`id_evenement`) ON DELETE CASCADE;

--
-- Contraintes pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD CONSTRAINT `fk_commentaire_forum` FOREIGN KEY (`forum_id`) REFERENCES `forum` (`id_forum`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_commentaire_utilisateur` FOREIGN KEY (`user_id`) REFERENCES `utilisateur` (`id_user`) ON DELETE CASCADE;

--
-- Contraintes pour la table `decoration`
--
ALTER TABLE `decoration`
  ADD CONSTRAINT `fk_decoration_utilisateur` FOREIGN KEY (`user_id`) REFERENCES `utilisateur` (`id_user`) ON DELETE CASCADE;

--
-- Contraintes pour la table `demande_offre`
--
ALTER TABLE `demande_offre`
  ADD CONSTRAINT `fk_demande_offre_offre` FOREIGN KEY (`offre`) REFERENCES `offre` (`id_offre`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_demande_offre_utilisateur` FOREIGN KEY (`user`) REFERENCES `utilisateur` (`id_user`) ON DELETE CASCADE;

--
-- Contraintes pour la table `evenement`
--
ALTER TABLE `evenement`
  ADD CONSTRAINT `fk_evenement_salle` FOREIGN KEY (`salle_id`) REFERENCES `salle` (`id_salle`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_evenement_utilisateur` FOREIGN KEY (`user`) REFERENCES `utilisateur` (`id_user`) ON DELETE CASCADE;

--
-- Contraintes pour la table `forum`
--
ALTER TABLE `forum`
  ADD CONSTRAINT `fk_forum_utilisateur` FOREIGN KEY (`user_id`) REFERENCES `utilisateur` (`id_user`) ON DELETE CASCADE;

--
-- Contraintes pour la table `offre`
--
ALTER TABLE `offre`
  ADD CONSTRAINT `fk_offre_evenement` FOREIGN KEY (`evenement`) REFERENCES `evenement` (`id_evenement`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_offre_utilisateur` FOREIGN KEY (`user_id`) REFERENCES `utilisateur` (`id_user`) ON DELETE CASCADE;

--
-- Contraintes pour la table `participation`
--
ALTER TABLE `participation`
  ADD CONSTRAINT `fk_participation_evenement` FOREIGN KEY (`evenement_id`) REFERENCES `evenement` (`id_evenement`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_participation_utilisateur` FOREIGN KEY (`user_id`) REFERENCES `utilisateur` (`id_user`) ON DELETE CASCADE;

--
-- Contraintes pour la table `reclamation`
--
ALTER TABLE `reclamation`
  ADD CONSTRAINT `fk_utilisateur_reclamation` FOREIGN KEY (`id_user`) REFERENCES `utilisateur` (`id_user`) ON DELETE CASCADE;

--
-- Contraintes pour la table `reponse`
--
ALTER TABLE `reponse`
  ADD CONSTRAINT `fk_reclamation` FOREIGN KEY (`reclamation_id`) REFERENCES `reclamation` (`id_reclamation`);

--
-- Contraintes pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `fk_reservation_salle` FOREIGN KEY (`salle`) REFERENCES `salle` (`id_salle`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_reservation_user` FOREIGN KEY (`user_id`) REFERENCES `utilisateur` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `salle`
--
ALTER TABLE `salle`
  ADD CONSTRAINT `fk_user_salle` FOREIGN KEY (`user_id`) REFERENCES `utilisateur` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
