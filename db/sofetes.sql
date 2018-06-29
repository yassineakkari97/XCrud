-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mer. 30 mai 2018 à 07:44
-- Version du serveur :  5.7.19
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
-- Base de données :  `sofetes`
--

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

DROP TABLE IF EXISTS `articles`;
CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `nom` varchar(20) NOT NULL,
  `unite` varchar(20) NOT NULL,
  `prix_unitaire` double(10,3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `articles`
--

INSERT INTO `articles` (`id`, `nom`, `unite`, `prix_unitaire`) VALUES
(1, 'Eau', '( Littre )', 1.500),
(2, 'Jus', '( Littre )', 5.000),
(3, 'Thé', '( Littre )', 3.000),
(4, 'Patisserie', '( Kg )', 50.000),
(5, 'Papier Serviette', '( Piece )', 1.000);

-- --------------------------------------------------------

--
-- Structure de la table `banque`
--

DROP TABLE IF EXISTS `banque`;
CREATE TABLE IF NOT EXISTS `banque` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `type` int(8) NOT NULL,
  `observation` text NOT NULL,
  `montant` double(9,3) NOT NULL,
  `date_echeance` date DEFAULT NULL,
  `date` date DEFAULT NULL,
  `operation` enum('transfert','reception') DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `type` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `banque`
--

INSERT INTO `banque` (`id`, `type`, `observation`, `montant`, `date_echeance`, `date`, `operation`) VALUES
(26, 1, '', 250.000, NULL, '2018-05-18', 'transfert'),
(27, 1, '', 500.000, NULL, NULL, 'reception'),
(28, 1, '', 250.000, NULL, '2018-05-18', 'transfert');

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `phone` varchar(25) NOT NULL,
  `cin` varchar(8) NOT NULL,
  `cin_date` date DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `adresse` varchar(100) NOT NULL,
  `code-postale` varchar(4) NOT NULL,
  `ville` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`nom`, `prenom`, `id`, `phone`, `cin`, `cin_date`, `email`, `adresse`, `code-postale`, `ville`) VALUES
('Amin', 'Gaouet', 2, '23456789', '01234567', '2018-02-01', 'client@email.com', 'Rue de la Liberte, Dar chaben El Fehri', '8021', 'Nabeul'),
('Salah', 'Bensalah', 3, '85456123', '74123987', NULL, '', 'Rue de la liberté', '8024', 'Hammamat'),
('Bayram', 'Bani', 4, '25489683', '09876543', NULL, 'bayram.bani@gmail.com', 'Rue De Marroc, Tazarka', '8024', 'Nabeul');

-- --------------------------------------------------------

--
-- Structure de la table `commande_article`
--

DROP TABLE IF EXISTS `commande_article`;
CREATE TABLE IF NOT EXISTS `commande_article` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `id_article` int(8) NOT NULL,
  `id_reservation` varchar(10) NOT NULL,
  `quantite` varchar(20) NOT NULL,
  `prix` double(9,3) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_article` (`id_article`),
  KEY `commande_article_ibfk_3` (`id_reservation`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `commande_article`
--

INSERT INTO `commande_article` (`id`, `id_article`, `id_reservation`, `quantite`, `prix`) VALUES
(22, 1, '2018-0001', '100', 50.000),
(23, 2, '2018-0001', '50', 100.000),
(24, 4, '2018-0001', '30', 200.000),
(26, 1, '2018-0003', '30', 300.000),
(27, 2, '2018-0002', '30', 300.000),
(34, 2, '2018-0001 ', '10', 50.000),
(35, 1, '2018-0004 ', '10', 15.000),
(36, 3, '2018-0004 ', '10', 30.000),
(37, 1, '2018-0002 ', '10', 15.000),
(38, 1, '2018-0005 ', '500', 750.000);

-- --------------------------------------------------------

--
-- Structure de la table `depense`
--

DROP TABLE IF EXISTS `depense`;
CREATE TABLE IF NOT EXISTS `depense` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `fournisseur` int(8) DEFAULT NULL,
  `type` int(8) NOT NULL,
  `objet` text NOT NULL,
  `montant` double(9,3) NOT NULL,
  `numero` varchar(200) DEFAULT NULL,
  `date_echeance` date DEFAULT NULL,
  `etat` enum('encaisse','non_encaisse') DEFAULT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `type` (`type`),
  KEY `fournisseur` (`fournisseur`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `depense`
--

INSERT INTO `depense` (`id`, `fournisseur`, `type`, `objet`, `montant`, `numero`, `date_echeance`, `etat`, `date`) VALUES
(12, 5, 1, 'Post haec Gallus Hierapolim profecturus ut expeditioni specie tenus adesset, Antiochensi plebi suppliciter obsecranti ut inediae dispelleret metum, quae per multas difficilisque causas adfore iam sperabatur, non ut mos est principibus, quorum diffusa potestas localibus subinde medetur aerumnis, disponi quicquam statuit vel ex provinciis alimenta transferri conterminis, sed consularem Syriae Theophilum prope adstantem ultima metuenti multitudini dedit id adsidue replicando quod invito rectore nullus egere poterit victu.', 500.000, NULL, '2018-05-31', 'encaisse', '2018-05-18');

-- --------------------------------------------------------

--
-- Structure de la table `fournisseur`
--

DROP TABLE IF EXISTS `fournisseur`;
CREATE TABLE IF NOT EXISTS `fournisseur` (
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `phone` varchar(25) NOT NULL,
  `cin` varchar(8) NOT NULL,
  `cin_date` date DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `adresse` varchar(100) NOT NULL,
  `code-postale` varchar(4) NOT NULL,
  `ville` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `fournisseur`
--

INSERT INTO `fournisseur` (`nom`, `prenom`, `id`, `phone`, `cin`, `cin_date`, `email`, `adresse`, `code-postale`, `ville`) VALUES
('Flan', 'Foulani', 5, '25896321444', '98765432', NULL, '', 'flan adresse', '8501', 'nabeul');

-- --------------------------------------------------------

--
-- Structure de la table `mode_pay`
--

DROP TABLE IF EXISTS `mode_pay`;
CREATE TABLE IF NOT EXISTS `mode_pay` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `mode_pay`
--

INSERT INTO `mode_pay` (`id`, `libelle`) VALUES
(1, 'Chéque'),
(2, 'Virement'),
(3, 'Espece'),
(4, 'Traite');

-- --------------------------------------------------------

--
-- Structure de la table `page`
--

DROP TABLE IF EXISTS `page`;
CREATE TABLE IF NOT EXISTS `page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `page`
--

INSERT INTO `page` (`id`, `nom`) VALUES
(1, 'dashboard.php'),
(11, 'error_404.php'),
(12, 'error_500.php'),
(15, 'index.php'),
(19, 'login.php'),
(20, 'logout.php'),
(22, 'menu-builder.php'),
(25, 'privilege.php'),
(31, 'trace.php'),
(34, 'utilisateurs.php');

-- --------------------------------------------------------

--
-- Structure de la table `payment`
--

DROP TABLE IF EXISTS `payment`;
CREATE TABLE IF NOT EXISTS `payment` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `id_reservation` varchar(10) NOT NULL,
  `montant` double(9,3) NOT NULL,
  `type` int(8) NOT NULL,
  `banque` varchar(200) NOT NULL,
  `numero` varchar(200) NOT NULL,
  `date_echeance` date DEFAULT NULL,
  `etat` enum('non_encaisse','encaisse') DEFAULT NULL,
  `description` text,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_reservation` (`id_reservation`),
  KEY `type` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `payment`
--

INSERT INTO `payment` (`id`, `id_reservation`, `montant`, `type`, `banque`, `numero`, `date_echeance`, `etat`, `description`, `date`) VALUES
(58, '2018-0001', 1000.000, 1, 'Banque x', '123 456 789', '2018-05-31', 'encaisse', 'Post haec Gallus Hierapolim profecturus ut expeditioni specie tenus adesset, Antiochensi plebi suppliciter obsecranti ut inediae dispelleret metum, quae per multas difficilisque causas adfore iam sperabatur, non ut mos est principibus, quorum diffusa potestas localibus subinde medetur aerumnis, disponi quicquam statuit vel ex provinciis alimenta transferri conterminis, sed consularem Syriae Theophilum prope adstantem ultima metuenti multitudini dedit id adsidue replicando quod invito rectore nullus egere poterit victu.', '2018-05-18');

-- --------------------------------------------------------

--
-- Structure de la table `privilege`
--

DROP TABLE IF EXISTS `privilege`;
CREATE TABLE IF NOT EXISTS `privilege` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(30) NOT NULL,
  `default_page` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `default_page` (`default_page`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `privilege`
--

INSERT INTO `privilege` (`id`, `libelle`, `default_page`) VALUES
(1, 'administrateur', 1),
(2, 'service finance', 1);

-- --------------------------------------------------------

--
-- Structure de la table `privilege_page`
--

DROP TABLE IF EXISTS `privilege_page`;
CREATE TABLE IF NOT EXISTS `privilege_page` (
  `id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  `ajouter` int(1) NOT NULL,
  `modifier` int(1) NOT NULL,
  `supprimer` int(1) NOT NULL,
  `detail` int(1) NOT NULL,
  PRIMARY KEY (`id`,`page_id`),
  KEY `page_id` (`page_id`),
  KEY `id` (`id`),
  KEY `page_id_2` (`page_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `privilege_page`
--

INSERT INTO `privilege_page` (`id`, `page_id`, `ajouter`, `modifier`, `supprimer`, `detail`) VALUES
(2, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

DROP TABLE IF EXISTS `reservation`;
CREATE TABLE IF NOT EXISTS `reservation` (
  `id` varchar(10) NOT NULL,
  `date` date NOT NULL,
  `heure_debut` time NOT NULL,
  `heure_fin` time NOT NULL,
  `observation` text NOT NULL,
  `id_client` int(8) NOT NULL,
  `prix` double(10,3) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `reservation_ibfk_1` (`id_client`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `reservation`
--

INSERT INTO `reservation` (`id`, `date`, `heure_debut`, `heure_fin`, `observation`, `id_client`, `prix`) VALUES
('2018-0001', '2018-02-28', '15:00:00', '17:00:00', 'rien', 4, 1000.000),
('2018-0002', '2018-02-28', '06:00:00', '10:00:00', '', 2, 1000.000),
('2018-0003', '2018-02-26', '10:00:00', '16:00:00', '', 3, 1000.000),
('2018-0004', '2018-02-01', '20:00:00', '23:00:00', '', 2, 2000.000),
('2018-0005', '2018-06-01', '16:00:00', '20:00:00', '', 2, 1000.000),
('2018-0006', '2018-03-20', '18:00:00', '20:00:00', '', 2, 1200.000),
('2018-0007', '2018-03-21', '15:00:00', '23:00:00', '', 3, 2000.000),
('2018-0008', '2018-04-01', '13:00:00', '19:00:00', '', 4, 1000.000),
('2018-0010', '2018-05-10', '12:00:00', '20:00:00', '', 3, 3000.000);

-- --------------------------------------------------------

--
-- Structure de la table `trace`
--

DROP TABLE IF EXISTS `trace`;
CREATE TABLE IF NOT EXISTS `trace` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ajout` int(1) NOT NULL,
  `modif` int(1) NOT NULL,
  `id_champ` varchar(100) NOT NULL,
  `nom_table` varchar(25) CHARACTER SET utf8 NOT NULL,
  `supp` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `id_user` (`id_user`),
  KEY `date` (`date`),
  KEY `ajout` (`ajout`),
  KEY `modif` (`modif`),
  KEY `id_champ` (`id_champ`),
  KEY `table` (`nom_table`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Civilite` enum('M.','Mme.','Mlle.') NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `CIN/passport` varchar(8) NOT NULL,
  `telephone` varchar(50) NOT NULL,
  `privilege` int(10) NOT NULL,
  `password_hash` text NOT NULL,
  `api_key` varchar(32) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `privilege` (`privilege`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `Civilite`, `nom`, `prenom`, `password`, `email`, `photo`, `CIN/passport`, `telephone`, `privilege`, `password_hash`, `api_key`, `status`, `created_at`, `updated_at`) VALUES
(1, 'M.', 'Gaouat', 'Mohamed Amine', 'h2Csuc2R', 'mohamedaminegaouat@gmail.com', '13utxye3wwcg4c4.jpg', '09778545', '24100229', 1, '$2a$10$fe01b8d0e0751b2d983fbuhJi9QB6fSMMWNxsl9CJJtv.k5PbJzxe', '12eda7da84ee2a2b839ce184cad3cb99', 1, '2016-05-16 09:41:31', '2016-06-01 11:50:58'),
(3, 'M.', 'Bani', 'Bayram', 'BZfItOg', 'bayram.bani@outlook.com', NULL, '09759433', '25489683', 1, '$2a$10$1b7b963987bbc67c9cb26OIOiEK3QgMXMjfI68BoDUwHGDP.cIFZC', 'e210c251bb3c9b46a7a7e994023b7377', 1, '2018-02-08 10:38:02', '2018-02-08 10:38:02');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commande_article`
--
ALTER TABLE `commande_article`
  ADD CONSTRAINT `commande_article_ibfk_2` FOREIGN KEY (`id_article`) REFERENCES `articles` (`id`),
  ADD CONSTRAINT `commande_article_ibfk_3` FOREIGN KEY (`id_reservation`) REFERENCES `reservation` (`id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `depense`
--
ALTER TABLE `depense`
  ADD CONSTRAINT `depense_ibfk_1` FOREIGN KEY (`type`) REFERENCES `mode_pay` (`id`),
  ADD CONSTRAINT `depense_ibfk_2` FOREIGN KEY (`fournisseur`) REFERENCES `fournisseur` (`id`);

--
-- Contraintes pour la table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_2` FOREIGN KEY (`type`) REFERENCES `mode_pay` (`id`),
  ADD CONSTRAINT `payment_ibfk_3` FOREIGN KEY (`id_reservation`) REFERENCES `reservation` (`id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `privilege`
--
ALTER TABLE `privilege`
  ADD CONSTRAINT `privilege_ibfk_1` FOREIGN KEY (`default_page`) REFERENCES `page` (`id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `privilege_page`
--
ALTER TABLE `privilege_page`
  ADD CONSTRAINT `privilege_page_ibfk_1` FOREIGN KEY (`id`) REFERENCES `privilege` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `privilege_page_ibfk_2` FOREIGN KEY (`page_id`) REFERENCES `page` (`id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`id_client`) REFERENCES `client` (`id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `trace`
--
ALTER TABLE `trace`
  ADD CONSTRAINT `trace_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `utilisateurs` (`id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD CONSTRAINT `utilisateurs_ibfk_1` FOREIGN KEY (`privilege`) REFERENCES `privilege` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
