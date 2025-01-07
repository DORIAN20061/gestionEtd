-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 07 jan. 2025 à 03:46
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `etudiant`
--

-- --------------------------------------------------------

--
-- Structure de la table `classes`
--

DROP TABLE IF EXISTS `classes`;
CREATE TABLE IF NOT EXISTS `classes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(20) NOT NULL,
  `pension` int NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `classes`
--

INSERT INTO `classes` (`id`, `nom`, `pension`, `create_at`, `update_at`) VALUES
(1, 'B1', 1000000, '2025-01-02 22:54:15', '2025-01-03 06:03:34'),
(2, 'B2', 2000000, '2025-01-02 22:54:15', '2025-01-02 22:54:15'),
(3, 'B3', 3000000, '2025-01-02 22:54:15', '2025-01-02 22:54:15');

-- --------------------------------------------------------

--
-- Structure de la table `cours`
--

DROP TABLE IF EXISTS `cours`;
CREATE TABLE IF NOT EXISTS `cours` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(45) NOT NULL,
  `niveau` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `credit` int DEFAULT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `cours`
--

INSERT INTO `cours` (`id`, `nom`, `niveau`, `credit`, `create_at`, `update_at`) VALUES
(2, 'CCNA3', 'B2', 3, '2025-01-02 23:48:36', '2025-01-03 00:37:34');

-- --------------------------------------------------------

--
-- Structure de la table `etudiants`
--

DROP TABLE IF EXISTS `etudiants`;
CREATE TABLE IF NOT EXISTS `etudiants` (
  `id` int NOT NULL AUTO_INCREMENT,
  `matricule` varchar(15) NOT NULL,
  `nom` varchar(45) NOT NULL,
  `prenom` varchar(45) NOT NULL,
  `dateNaiss` date NOT NULL,
  `Niveau` varchar(2) NOT NULL,
  `Email` varchar(45) NOT NULL,
  `Statut` varchar(15) NOT NULL,
  `dateIns` date NOT NULL,
  `nomPrt` varchar(20) NOT NULL,
  `emailPrt` varchar(45) NOT NULL,
  `pass` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `solde` int DEFAULT NULL,
  `total` int DEFAULT NULL,
  `image` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `imagePath` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `matricule` (`matricule`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `etudiants`
--

INSERT INTO `etudiants` (`id`, `matricule`, `nom`, `prenom`, `dateNaiss`, `Niveau`, `Email`, `Statut`, `dateIns`, `nomPrt`, `emailPrt`, `pass`, `solde`, `total`, `image`, `create_at`, `update_at`, `imagePath`) VALUES
(7, '24B1004', 'Nti', 'Guy ', '2008-07-03', 'B1', 'tamar@icloud.com', 'Insolvable', '2024-12-16', 'ondoa', 'tamar@gmail.com', '$2y$10$1VBFN.EqRILfUfILm3dLmOebsiw5ENZvuvYanriviVd.NUwc0a.e2', NULL, NULL, '', '2025-01-02 22:45:47', '2025-01-06 18:36:13', '677c229dd7eb8_2e702bb3ae2fb16cd92052bea295db50.jpg'),
(20, '24B2004', 'TAMAR', 'TAMSES', '2005-01-03', 'B2', 'tamar.ondoa@icloud.com', 'En cours', '2024-12-17', 'Endale', 'ondoa@icloud.com', '$2y$10$8yI8e.saddlfYa0Cchgik.bpEGG8pN4VNivAs5jLi5qAEUybOSLie', 40000, 2000000, NULL, '2025-01-02 22:45:47', '2025-01-06 18:36:38', '677c22b66c0aa_5ccfcf25-e36e-4821-800c-36b5f743e116.jpg'),
(21, '24B1005', 'fomekong', 'evaris', '2006-05-21', 'B1', 'tamar.ondoa@icloud.com', 'Insolvable', '2024-12-17', 'Endale', 'ondoa@icloud.com', '$2y$10$JLfvJ1m0zw3gEq4KUs/ctOKlqjXl9LdyqtSC9eMeLywbPB4x8QdA6', 1000000, 1000000, NULL, '2025-01-02 22:45:47', '2025-01-06 18:37:05', '677c22d183d6e_7331f4a4-002f-4813-b3d7-9fe197f515a2.jpg'),
(22, '24B2006', 'fomekong', 'evaris', '2011-12-30', 'B2', 'tamar.ondoa@icloud.com', 'Insolvable', '2024-12-24', 'Endale', 'ondoa@icloud.com', 'popo', 1790000, 2000000, NULL, '2025-01-02 22:45:47', '2025-01-06 18:38:33', '677c2329b7ae9_2436828d-23a0-4601-8427-0b0c753cb310.jpg'),
(23, '25B2006', 'bato', 'dorian', '2011-12-31', 'B2', 'tamarondoa4@gmail.com', 'Insolvable', '2025-01-03', 'ondoa', 'tamar.ondoa@icloud.com', '25B2006', 2000000, 2000000, NULL, '2025-01-03 00:26:16', '2025-01-06 18:39:16', '677c23542ba89_b2f09829c4be9e29406a283234e73599.jpg'),
(24, '25B3007', 'bato', 'dorian', '2011-12-31', 'B3', 'tamarondoa4@gmail.com', 'Insolvable', '2025-01-03', 'ondoa', 'tamar.ondoa@icloud.com', '25B3007', 3000000, 3000000, NULL, '2025-01-03 06:19:12', '2025-01-06 18:39:40', '677c236c6413f_Leyenda.jpg'),
(25, '25B2007', 'BATOSINE', 'DORIAN', '2006-01-17', 'B2', 'dorianbat8@gmail.com', 'Insolvable', '2025-01-06', 'PAPADORIAN', 'papadorian@gmail.com', '25B2007', 1750000, 2000000, NULL, '2025-01-06 18:47:04', '2025-01-07 03:45:12', '677c25491ddff_5ccfcf25-e36e-4821-800c-36b5f743e116.jpg'),
(27, '25B3008', 'brooklyn', 'frances', '2008-11-11', 'B3', 'matangabrooklyn@gmail.com', 'Insolvable', '2025-01-07', 'papabrooklyn', 'papabrook@gmail.com', '25B3008', 3000000, 3000000, NULL, '2025-01-07 03:43:55', '2025-01-07 03:43:55', '677ca2fb3f2e7_4k-mask-anonymous-hacker-4riytoswu2unq9d4.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `notes`
--

DROP TABLE IF EXISTS `notes`;
CREATE TABLE IF NOT EXISTS `notes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `note` int NOT NULL,
  `matiere` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'php',
  `etd` varchar(45) NOT NULL,
  `categorie` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'cc',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `notes`
--

INSERT INTO `notes` (`id`, `note`, `matiere`, `etd`, `categorie`, `create_at`, `update_at`) VALUES
(4, 15, 'ccna', '20', 'cc', '2025-01-02 22:56:41', '2025-01-02 22:56:41'),
(6, 10, 'ccna', '22', 'sn', '2025-01-02 22:56:41', '2025-01-02 22:56:41'),
(9, 12, 'CC', '2', 'PHP', '2025-01-02 22:56:41', '2025-01-02 22:56:41'),
(10, 12, 'CC', '20', 'PHP', '2025-01-02 22:56:41', '2025-01-02 22:56:41'),
(11, 15, 'PHP', '22', 'CC', '2025-01-02 22:56:41', '2025-01-02 22:56:41');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(15) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `role` enum('admin','etudiant') NOT NULL,
  `pass` varchar(15) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `nom`, `prenom`, `email`, `role`, `pass`, `create_at`, `update_at`) VALUES
(1, 'admin', '', '', 'admin', 'admin', '2025-01-02 23:02:50', '2025-01-02 23:02:50');

-- --------------------------------------------------------

--
-- Structure de la table `versements`
--

DROP TABLE IF EXISTS `versements`;
CREATE TABLE IF NOT EXISTS `versements` (
  `id` int NOT NULL AUTO_INCREMENT,
  `numero` varchar(45) NOT NULL,
  `etdid` int NOT NULL,
  `date` date DEFAULT NULL,
  `matrietd` varchar(45) DEFAULT NULL,
  `montant` int DEFAULT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `matricule_UNIQUE` (`numero`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `versements`
--

INSERT INTO `versements` (`id`, `numero`, `etdid`, `date`, `matrietd`, `montant`, `create_at`, `update_at`) VALUES
(13, '2024_24B1007_011', 0, '2024-12-17', '24B1007', 200000, '2025-01-02 23:08:42', '2025-01-02 23:08:42'),
(14, '2024_24B1007_012', 0, '2024-12-17', '24B1007', 800000, '2025-01-02 23:08:42', '2025-01-02 23:08:42'),
(15, '2024_24B1007_013', 0, '2024-12-17', '24B1007', 200000, '2025-01-02 23:08:42', '2025-01-02 23:08:42'),
(16, '2024_24B2011_014', 0, '2024-12-17', '24B2011', 200000, '2025-01-02 23:08:42', '2025-01-02 23:08:42'),
(17, '2024_24B2004_005', 0, '2024-12-17', '24B2004', 50000, '2025-01-02 23:08:42', '2025-01-02 23:08:42'),
(18, '2024_24B2004_006', 0, '2024-12-17', '24B2004', 50000, '2025-01-02 23:08:42', '2025-01-02 23:08:42'),
(19, '2024_24B2004_007', 0, '2024-12-17', '24B2004', 50000, '2025-01-02 23:08:42', '2025-01-02 23:08:42'),
(20, '2025_24B2006_008', 0, '2025-01-02', '24B2006', 5000, '2025-01-02 23:08:42', '2025-01-02 23:08:42'),
(21, '2025_24B2006_009', 0, '2025-01-02', '24B2006', 10000, '2025-01-02 23:08:42', '2025-01-02 23:08:42'),
(22, '2025_24B2006_010', 0, '2025-01-02', '24B2006', 10000, '2025-01-02 23:08:42', '2025-01-02 23:08:42'),
(23, '2025_24B2006_011', 0, '2025-01-02', '24B2006', 10000, '2025-01-02 23:08:42', '2025-01-02 23:08:42'),
(24, '2025_24B2006_012', 0, '2025-01-02', '24B2006', 10000, '2025-01-02 23:08:42', '2025-01-02 23:08:42'),
(25, '2025_24B2006_013', 0, '2025-01-02', '24B2006', 15000, '2025-01-02 23:08:42', '2025-01-02 23:08:42'),
(26, '2025_24B2006_014', 0, '2025-01-02', '24B2006', 150000, '2025-01-02 23:08:42', '2025-01-02 23:08:42'),
(27, '2025_24B2004_015', 0, '2025-01-02', '24B2004', 5000, '2025-01-02 23:08:42', '2025-01-02 23:08:42'),
(28, '2025_24B2004_016', 0, '2025-01-02', '24B2004', 5000, '2025-01-02 23:08:42', '2025-01-02 23:08:42'),
(29, '2025_24B2004_017', 0, '2025-01-02', '24B2004', 1800000, '2025-01-02 23:08:42', '2025-01-02 23:08:42'),
(30, '2025_25B2007_018', 0, '2025-01-07', '25B2007', 250000, '2025-01-07 03:45:12', '2025-01-07 03:45:12');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
