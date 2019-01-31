-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mar. 11 déc. 2018 à 16:57
-- Version du serveur :  10.1.26-MariaDB
-- Version de PHP :  7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `sutekinabox`
--

-- --------------------------------------------------------

--
-- Structure de la table `box`
--

CREATE TABLE `box` (
  `id` int(11) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `box`
--

INSERT INTO `box` (`id`, `date`) VALUES
(1, '2018-05-07 00:00:00'),
(2, '2018-06-04 00:00:00'),
(3, '2018-07-02 00:00:00'),
(4, '2018-08-06 00:00:00'),
(5, '2013-01-01 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `fournisseur`
--

CREATE TABLE `fournisseur` (
  `id` int(11) NOT NULL,
  `nom` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `fournisseur`
--

INSERT INTO `fournisseur` (`id`, `nom`) VALUES
(1, 'fournisseur 1'),
(2, 'fournisseur 2'),
(3, 'fournisseur 3'),
(4, 'fournisseur 4'),
(5, 'fournisseur 5');

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

CREATE TABLE `membre` (
  `id` int(11) NOT NULL,
  `nom` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:array)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `membre`
--

INSERT INTO `membre` (`id`, `nom`, `prenom`, `email`, `password`, `roles`) VALUES
(3, 'Logistique', 'Jean', 'jean.logistique@sutekina.box', '$2y$13$2HHDhWwY/fGKkUAKH4g6/OICHmbf4iAyTFzxmAHdnM0CdrIdZaIPq', 'a:1:{i:0;s:15:\"ROLE_LOGISTIQUE\";}'),
(4, 'Admin', 'Jean', 'jean.admin@sutekina.box', '$2y$13$jLhd6Vm3AmcYZa/ryLeowusy9JfE3tFvRCtShLzyzVzXIm4jSCIry', 'a:1:{i:0;s:10:\"ROLE_ADMIN\";}'),
(5, 'Achat', 'Jean', 'jean.achat@sutekina.box', '$2y$13$g55OE1K4Hc37HNAuJDD2vu575Aw46e1Cex7JwTOY4MKDULpd0udiS', 'a:1:{i:0;s:10:\"ROLE_ACHAT\";}');

-- --------------------------------------------------------

--
-- Structure de la table `migration_versions`
--

CREATE TABLE `migration_versions` (
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `migration_versions`
--

INSERT INTO `migration_versions` (`version`) VALUES
('20181211091527'),
('20181211111855'),
('20181211131523');

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE `produit` (
  `id` int(11) NOT NULL,
  `fournisseur_id` int(11) DEFAULT NULL,
  `nom` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prix` double NOT NULL,
  `statut` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id`, `fournisseur_id`, `nom`, `prix`, `statut`) VALUES
(1, 2, 'produit A', 12, ''),
(2, 3, 'produit B', 28, ''),
(3, 4, 'produit C', 19, ''),
(4, 2, 'produit D', 23, ''),
(5, 5, 'produit E', 37, ''),
(6, 4, 'produit F', 8, ''),
(7, 3, 'produit G', 42, ''),
(8, 4, 'produit H', 39, ''),
(9, 4, 'produit I', 15, ''),
(10, 5, 'produit K', 33, '');

-- --------------------------------------------------------

--
-- Structure de la table `produit_box`
--

CREATE TABLE `produit_box` (
  `produit_id` int(11) NOT NULL,
  `box_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `box`
--
ALTER TABLE `box`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `fournisseur`
--
ALTER TABLE `fournisseur`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `membre`
--
ALTER TABLE `membre`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `migration_versions`
--
ALTER TABLE `migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_29A5EC27670C757F` (`fournisseur_id`);

--
-- Index pour la table `produit_box`
--
ALTER TABLE `produit_box`
  ADD PRIMARY KEY (`produit_id`,`box_id`),
  ADD KEY `IDX_491D3F43F347EFB` (`produit_id`),
  ADD KEY `IDX_491D3F43D8177B3F` (`box_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `box`
--
ALTER TABLE `box`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `fournisseur`
--
ALTER TABLE `fournisseur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `membre`
--
ALTER TABLE `membre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `produit`
--
ALTER TABLE `produit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `produit`
--
ALTER TABLE `produit`
  ADD CONSTRAINT `FK_29A5EC27670C757F` FOREIGN KEY (`fournisseur_id`) REFERENCES `fournisseur` (`id`);

--
-- Contraintes pour la table `produit_box`
--
ALTER TABLE `produit_box`
  ADD CONSTRAINT `FK_491D3F43D8177B3F` FOREIGN KEY (`box_id`) REFERENCES `box` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_491D3F43F347EFB` FOREIGN KEY (`produit_id`) REFERENCES `produit` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
