-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 25 juil. 2025 à 14:35
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestion_billeterie`
--

-- --------------------------------------------------------

--
-- Structure de la table `activite`
--

CREATE TABLE `activite` (
  `id` int(11) NOT NULL,
  `titre` text NOT NULL,
  `type` text NOT NULL,
  `date` text NOT NULL,
  `lieu` text NOT NULL,
  `photo` text DEFAULT NULL,
  `prix` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `activite`
--

INSERT INTO `activite` (`id`, `titre`, `type`, `date`, `lieu`, `photo`, `prix`) VALUES
(1, 'Afro Nation', 'Exposition d\'art africain', '2025-07-24', 'bbo', '68821e9edaa09_A14.jpg', 1000.00),
(2, 'Lake of Stars', 'Debats et conferences', '2025-08-02', 'Butembo', '68821e49a5976_A9.jpg', 3000.00),
(3, 'FESPAM', 'Concerts live', '2025-08-09', 'beni', '68821df5cda2d_A13.jpg', 2000.00);

-- --------------------------------------------------------

--
-- Structure de la table `activite_artiste`
--

CREATE TABLE `activite_artiste` (
  `id` int(11) NOT NULL,
  `artiste` int(11) NOT NULL,
  `activite` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `activite_artiste`
--

INSERT INTO `activite_artiste` (`id`, `artiste`, `activite`) VALUES
(1, 1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `artiste`
--

CREATE TABLE `artiste` (
  `id` int(11) NOT NULL,
  `nom` text NOT NULL,
  `prenom` text NOT NULL,
  `genre` text NOT NULL,
  `pays` text NOT NULL,
  `biographie` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `artiste`
--

INSERT INTO `artiste` (`id`, `nom`, `prenom`, `genre`, `pays`, `biographie`) VALUES
(1, 'dadju', 'dadju', 'Masculin', 'rdc', 'chanteur, danseur');

-- --------------------------------------------------------

--
-- Structure de la table `billet`
--

CREATE TABLE `billet` (
  `id` int(11) NOT NULL,
  `code` text NOT NULL,
  `date` date NOT NULL,
  `statut` text NOT NULL,
  `vente` int(11) NOT NULL,
  `activite` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `billet`
--

INSERT INTO `billet` (`id`, `code`, `date`, `statut`, `vente`, `activite`) VALUES
(1, 'AMANI-0EB7D0', '2025-07-21', 'utilisé', 1, 2),
(2, 'AMANI-AB7FB1', '2025-07-21', 'valide', 2, 2),
(3, 'AMANI-582130', '2025-07-21', 'valide', 2, 2),
(4, 'AMANI-3D86C1', '2025-07-21', 'valide', 2, 2),
(5, 'AMANI-F08394', '2025-07-22', 'valide', 3, 3),
(6, 'AMANI-04ABA7', '2025-07-22', 'valide', 3, 3),
(7, 'AMANI-1D912C', '2025-07-22', 'valide', 4, 2),
(8, 'AMANI-CBA219', '2025-07-24', 'valide', 5, 2),
(9, 'AMANI-CA27C6', '2025-07-24', 'valide', 5, 2),
(10, 'AMANI-2B2346', '2025-07-24', 'valide', 5, 2),
(11, 'AMANI-29B0D2', '2025-07-24', 'valide', 5, 2);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id` int(11) NOT NULL,
  `noms` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `role` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `noms`, `email`, `password`, `role`) VALUES
(1, 'chris', 'chris@gmail.om', '$2y$10$b.94lrG8QJFxDLD1LtnD2.QJpTi9Mwe3pGF3DU0EkqdUYRO2mg./6', 'agent'),
(2, 'milka', 'milka@gmail.com', '$2y$10$cKYN4uQb1e00ktYizjrMUuezQZKZCmq.BMp107isv66x1Ow2BphAS', 'admin'),
(3, 'kbg', 'kbg@gmail.com', '$2y$10$tPNuYY4DGRogEPekvwHP4.ahep4MOaI8UB3kapA2wewBr19NVNxda', 'organisateur');

-- --------------------------------------------------------

--
-- Structure de la table `vente`
--

CREATE TABLE `vente` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `agent` int(11) DEFAULT NULL,
  `visiteur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `vente`
--

INSERT INTO `vente` (`id`, `date`, `agent`, `visiteur`) VALUES
(1, '2025-07-21', NULL, 3),
(2, '2025-07-21', NULL, 4),
(3, '2025-07-22', NULL, 5),
(4, '2025-07-22', NULL, 6),
(5, '2025-07-24', NULL, 7);

-- --------------------------------------------------------

--
-- Structure de la table `visiteur`
--

CREATE TABLE `visiteur` (
  `id` int(11) NOT NULL,
  `nom` text NOT NULL,
  `telephone` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `visiteur`
--

INSERT INTO `visiteur` (`id`, `nom`, `telephone`) VALUES
(1, 'chris', '0983898789'),
(2, 'chris', '0983898789'),
(3, 'chris', '0983898789'),
(4, 'simons', '5347657757'),
(5, 'christel', '0983898789'),
(6, 'vvv', 'vvvv'),
(7, 'christelle', '09765677889');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `activite`
--
ALTER TABLE `activite`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `activite_artiste`
--
ALTER TABLE `activite_artiste`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `artiste`
--
ALTER TABLE `artiste`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `billet`
--
ALTER TABLE `billet`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `vente`
--
ALTER TABLE `vente`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `visiteur`
--
ALTER TABLE `visiteur`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `activite`
--
ALTER TABLE `activite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `activite_artiste`
--
ALTER TABLE `activite_artiste`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `artiste`
--
ALTER TABLE `artiste`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `billet`
--
ALTER TABLE `billet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `vente`
--
ALTER TABLE `vente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `visiteur`
--
ALTER TABLE `visiteur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
