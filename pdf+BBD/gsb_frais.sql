-- phpMyAdmin SQL Dump
-- version 4.1.11
-- http://www.phpmyadmin.net
--
-- Client :  50.62.209.108:3306
-- Généré le :  Dim 27 Avril 2014 à 07:57
-- Version du serveur :  5.5.33-log
-- Version de PHP :  5.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `gsb_frais`
--

-- --------------------------------------------------------

--
-- Structure de la table `Etat`
--

CREATE TABLE IF NOT EXISTS `Etat` (
  `id` char(2) NOT NULL,
  `libelle` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `Etat`
--

INSERT INTO `Etat` (`id`, `libelle`) VALUES
('CL', 'Saisie clôturée'),
('CR', 'Fiche créée, saisie en cours'),
('RB', 'Remboursée'),
('VA', 'Validée et mise en paiement');

-- --------------------------------------------------------

--
-- Structure de la table `FicheFrais`
--

CREATE TABLE IF NOT EXISTS `FicheFrais` (
  `idVisiteur` char(4) CHARACTER SET latin1 NOT NULL,
  `mois` char(6) CHARACTER SET latin1 NOT NULL,
  `nbJustificatifs` int(11) DEFAULT NULL,
  `montantValide` decimal(10,2) DEFAULT NULL,
  `dateModif` date DEFAULT NULL,
  `idEtat` char(2) CHARACTER SET latin1 DEFAULT 'CR',
  PRIMARY KEY (`idVisiteur`,`mois`),
  KEY `idEtat` (`idEtat`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Contenu de la table `FicheFrais`
--

INSERT INTO `FicheFrais` (`idVisiteur`, `mois`, `nbJustificatifs`, `montantValide`, `dateModif`, `idEtat`) VALUES
('a131', '201402', 0, NULL, '2014-04-23', 'CL'),
('a131', '201404', 0, NULL, '2014-04-23', 'CR'),
('a17', '201402', 3, '240.67', '2014-04-23', 'RB'),
('a17', '201403', 8, '1006.34', '2014-04-23', 'VA'),
('a17', '201404', 6, '180.74', '2014-04-23', 'VA'),
('a17', '201405', 0, NULL, '2014-04-26', 'CL'),
('a17', '201406', 0, NULL, '2014-04-26', 'CR'),
('a17', '201407', 0, NULL, '2014-04-26', 'CR'),
('a55', '201402', 5, '111.20', '2014-04-27', 'VA'),
('a93', '201403', 1, NULL, '2014-04-27', 'CL'),
('a93', '201404', 0, '135.00', '2014-04-27', 'VA'),
('a93', '201405', 0, NULL, '2014-04-27', 'CR'),
('b13', '201403', 4, NULL, '2014-03-04', 'CR'),
('b16', '201404', 0, NULL, '2014-04-10', 'CR'),
('b25', '201404', 0, NULL, '2014-04-23', 'CR'),
('b28', '201404', 0, NULL, '2014-04-23', 'CR'),
('b34', '201403', 0, NULL, '2014-03-04', 'CR'),
('b4', '201403', 0, NULL, '2014-03-21', 'CR'),
('c54', '201403', 0, NULL, '2014-03-21', 'CR'),
('d13', '201403', 0, NULL, '2014-03-04', 'CR'),
('e24', '201403', 0, NULL, '2014-03-04', 'CR'),
('e49', '201404', 0, NULL, '2014-04-23', 'CR'),
('e5', '201403', 0, NULL, '2014-03-21', 'CR'),
('e52', '201404', 0, NULL, '2014-04-23', 'CR'),
('f39', '201404', 2, '3.10', '2014-04-27', 'RB');

-- --------------------------------------------------------

--
-- Structure de la table `FraisForfait`
--

CREATE TABLE IF NOT EXISTS `FraisForfait` (
  `id` char(3) NOT NULL,
  `libelle` char(20) DEFAULT NULL,
  `montant` decimal(5,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `FraisForfait`
--

INSERT INTO `FraisForfait` (`id`, `libelle`, `montant`) VALUES
('ETP', 'Forfait Etape', '110.00'),
('KM', 'Frais Kilométrique', '1.00'),
('NUI', 'Nuitée Hôtel', '80.00'),
('REP', 'Repas Restaurant', '25.00');

-- --------------------------------------------------------

--
-- Structure de la table `LigneFraisForfait`
--

CREATE TABLE IF NOT EXISTS `LigneFraisForfait` (
  `idVisiteur` char(4) CHARACTER SET latin1 NOT NULL,
  `mois` char(6) CHARACTER SET latin1 NOT NULL,
  `idFraisForfait` char(3) CHARACTER SET latin1 NOT NULL,
  `quantite` int(11) DEFAULT NULL,
  PRIMARY KEY (`idVisiteur`,`mois`,`idFraisForfait`),
  KEY `idFraisForfait` (`idFraisForfait`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Contenu de la table `LigneFraisForfait`
--

INSERT INTO `LigneFraisForfait` (`idVisiteur`, `mois`, `idFraisForfait`, `quantite`) VALUES
('a131', '201402', 'ETP', 0),
('a131', '201402', 'KM', 0),
('a131', '201402', 'NUI', 0),
('a131', '201402', 'REP', 0),
('a131', '201404', 'ETP', 0),
('a131', '201404', 'KM', 0),
('a131', '201404', 'NUI', 0),
('a131', '201404', 'REP', 0),
('a17', '201402', 'ETP', 1),
('a17', '201402', 'KM', 1),
('a17', '201402', 'NUI', 1),
('a17', '201402', 'REP', 2),
('a17', '201403', 'ETP', 3),
('a17', '201403', 'KM', 2),
('a17', '201403', 'NUI', 5),
('a17', '201403', 'REP', 11),
('a17', '201404', 'ETP', 0),
('a17', '201404', 'KM', 22),
('a17', '201404', 'NUI', 0),
('a17', '201404', 'REP', 0),
('a17', '201405', 'ETP', 0),
('a17', '201405', 'KM', 0),
('a17', '201405', 'NUI', 0),
('a17', '201405', 'REP', 0),
('a17', '201406', 'ETP', 0),
('a17', '201406', 'KM', 0),
('a17', '201406', 'NUI', 0),
('a17', '201406', 'REP', 0),
('a17', '201407', 'ETP', 0),
('a17', '201407', 'KM', 0),
('a17', '201407', 'NUI', 0),
('a17', '201407', 'REP', 0),
('a55', '201402', 'ETP', 0),
('a55', '201402', 'KM', 10),
('a55', '201402', 'NUI', 1),
('a55', '201402', 'REP', 1),
('a93', '201403', 'ETP', 0),
('a93', '201403', 'KM', 0),
('a93', '201403', 'NUI', 0),
('a93', '201403', 'REP', 0),
('a93', '201404', 'ETP', 1),
('a93', '201404', 'KM', 0),
('a93', '201404', 'NUI', 0),
('a93', '201404', 'REP', 1),
('a93', '201405', 'ETP', 0),
('a93', '201405', 'KM', 0),
('a93', '201405', 'NUI', 0),
('a93', '201405', 'REP', 0),
('b13', '201403', 'ETP', 0),
('b13', '201403', 'KM', 0),
('b13', '201403', 'NUI', 0),
('b13', '201403', 'REP', 0),
('b16', '201404', 'ETP', 3),
('b16', '201404', 'KM', 6),
('b16', '201404', 'NUI', 0),
('b16', '201404', 'REP', 0),
('b25', '201404', 'ETP', 0),
('b25', '201404', 'KM', 0),
('b25', '201404', 'NUI', 0),
('b25', '201404', 'REP', 0),
('b28', '201404', 'ETP', 0),
('b28', '201404', 'KM', 0),
('b28', '201404', 'NUI', 0),
('b28', '201404', 'REP', 0),
('b34', '201403', 'ETP', 0),
('b34', '201403', 'KM', 0),
('b34', '201403', 'NUI', 0),
('b34', '201403', 'REP', 0),
('b4', '201403', 'ETP', 0),
('b4', '201403', 'KM', 0),
('b4', '201403', 'NUI', 0),
('b4', '201403', 'REP', 0),
('c54', '201403', 'ETP', 0),
('c54', '201403', 'KM', 0),
('c54', '201403', 'NUI', 0),
('c54', '201403', 'REP', 0),
('d13', '201403', 'ETP', 0),
('d13', '201403', 'KM', 0),
('d13', '201403', 'NUI', 0),
('d13', '201403', 'REP', 0),
('e24', '201403', 'ETP', 0),
('e24', '201403', 'KM', 0),
('e24', '201403', 'NUI', 0),
('e24', '201403', 'REP', 0),
('e49', '201404', 'ETP', 0),
('e49', '201404', 'KM', 0),
('e49', '201404', 'NUI', 0),
('e49', '201404', 'REP', 0),
('e5', '201403', 'ETP', 0),
('e5', '201403', 'KM', 0),
('e5', '201403', 'NUI', 0),
('e5', '201403', 'REP', 0),
('e52', '201404', 'ETP', 0),
('e52', '201404', 'KM', 0),
('e52', '201404', 'NUI', 0),
('e52', '201404', 'REP', 0),
('f39', '201404', 'ETP', 0),
('f39', '201404', 'KM', 5),
('f39', '201404', 'NUI', 0),
('f39', '201404', 'REP', 0);

-- --------------------------------------------------------

--
-- Structure de la table `LigneFraisHorsForfait`
--

CREATE TABLE IF NOT EXISTS `LigneFraisHorsForfait` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idVisiteur` char(4) CHARACTER SET latin1 NOT NULL,
  `mois` char(6) CHARACTER SET latin1 NOT NULL,
  `libelle` varchar(53) COLLATE latin1_general_ci DEFAULT NULL,
  `date` date DEFAULT NULL,
  `montant` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idVisiteur` (`idVisiteur`,`mois`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=15 ;

--
-- Contenu de la table `LigneFraisHorsForfait`
--

INSERT INTO `LigneFraisHorsForfait` (`id`, `idVisiteur`, `mois`, `libelle`, `date`, `montant`) VALUES
(1, 'a17', '201403', 'REFUSE - Achat Essence', '2014-02-10', '150.00'),
(2, 'a17', '201403', 'REFUSE - Achat Jouets', '2014-01-20', '10.00'),
(3, 'a17', '201403', 'REFUSE -  Des bonbons', '2014-01-10', '2.00'),
(7, 'a17', '201407', 'ACCEPTE - Test2', '2014-04-21', '150.00'),
(8, 'a17', '201404', 'REFUSE - test3', '2014-04-15', '15.00'),
(9, 'a17', '201404', 'test4', '2014-04-15', '150.00'),
(10, 'a17', '201404', 'test5', '2014-04-15', '12.00'),
(11, 'a17', '201404', 'REFUSE - test66', '2014-04-15', '120.00'),
(12, 'a17', '201404', 'test ', '2014-04-15', '4.00'),
(14, 'a93', '201405', 'ACHAT CAF2', '2014-04-10', '1.50');

-- --------------------------------------------------------

--
-- Structure de la table `User`
--

CREATE TABLE IF NOT EXISTS `User` (
  `id` char(4) CHARACTER SET latin1 NOT NULL,
  `nom` char(30) CHARACTER SET latin1 DEFAULT NULL,
  `prenom` char(30) CHARACTER SET latin1 DEFAULT NULL,
  `login` char(20) CHARACTER SET latin1 DEFAULT NULL,
  `mdp` text CHARACTER SET latin1,
  `adresse` char(30) CHARACTER SET latin1 DEFAULT NULL,
  `cp` char(5) CHARACTER SET latin1 DEFAULT NULL,
  `ville` char(30) CHARACTER SET latin1 DEFAULT NULL,
  `dateEmbauche` date DEFAULT NULL,
  `metier` varchar(20) CHARACTER SET latin1 NOT NULL DEFAULT 'visiteur',
  `coeffVoiture` float NOT NULL DEFAULT '0.62',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Contenu de la table `User`
--

INSERT INTO `User` (`id`, `nom`, `prenom`, `login`, `mdp`, `adresse`, `cp`, `ville`, `dateEmbauche`, `metier`, `coeffVoiture`) VALUES
('a131', 'Villechalane', 'Louis', 'lvillachane', '3abf9eb797afe468902101efe6b4b00f7d50802a', '8 rue des Charmes', '46000', 'Cahors', '2005-12-21', 'visiteur', 0.62),
('a17', 'Andre', 'David', 'dandre', '12e0b9be32932a8028b0ef0432a0a0a99421f745', '1 rue Petit', '46200', 'Lalbenque', '1998-11-23', 'comptable', 0.67),
('a55', 'Bedos', 'Christian', 'cbedos', 'a34b9dfadee33917a63c3cdebdc9526230611f0b', '1 rue Peranud', '46250', 'Montcuq', '1995-01-12', 'visiteur', 0.62),
('a93', 'Tusseau', 'Louis', 'ltusseau', 'f1c1d39e9898f3202a2eaa3dc38ae61575cd77ad', '22 rue des Ternes', '46123', 'Gramat', '2000-05-01', 'visiteur', 0.62),
('b13', 'Bentot', 'Pascal', 'pbentot', '178e1efaf000fdf2267edc43fad2a65197a0ab10', '11 allée des Cerises', '46512', 'Bessines', '1992-07-09', 'visiteur', 0.62),
('b16', 'Bioret', 'Luc', 'lbioret', 'ab7fa51f9bf8fde35d9e5bcc5066d3b71dda00d2', '1 Avenue gambetta', '46000', 'Cahors', '1998-05-11', 'visiteur', 0.62),
('b19', 'Bunisset', 'Francis', 'fbunisset', 'aa710ca3a1f12234bc2872aa0a6f88d6cf896ae4', '10 rue des Perles', '93100', 'Montreuil', '1987-10-21', 'visiteur', 0.62),
('b25', 'Bunisset', 'Denise', 'dbunisset', '40ff56dc0525aa08de29eba96271997a91e7d405', '23 rue Manin', '75019', 'paris', '2010-12-05', 'visiteur', 0.62),
('b28', 'Cacheux', 'Bernard', 'bcacheux', '51a4fac4890def1ef8605f0b2e6554c86b2eb919', '114 rue Blanche', '75017', 'Paris', '2009-11-12', 'visiteur', 0.62),
('b34', 'Cadic', 'Eric', 'ecadic', '2ed5ee95d2588be3650a935ff7687dee46d70fc8', '123 avenue de la République', '75011', 'Paris', '2008-09-23', 'visiteur', 0.62),
('b4', 'Charoze', 'Catherine', 'ccharoze', '8b16cf71ab0842bd871bce99a1ba61dd7e9d4423', '100 rue Petit', '75019', 'Paris', '2005-11-12', 'visiteur', 0.62),
('b50', 'Clepkens', 'Christophe', 'cclepkens', '7ddda57eca7a823c85ac0441adf56928b47ece76', '12 allée des Anges', '93230', 'Romainville', '2003-08-11', 'visiteur', 0.62),
('b59', 'Cottin', 'Vincenne', 'vcottin', '2f95d1cac7b8e7459376bf36b93ae7333026282d', '36 rue Des Roches', '93100', 'Monteuil', '2001-11-18', 'visiteur', 0.62),
('c14', 'Daburon', 'François', 'fdaburon', '5c7cc4a7f0123460c29c84d8f8a73bc86184adbb', '13 rue de Chanzy', '94000', 'Créteil', '2002-02-11', 'visiteur', 0.62),
('c3', 'De', 'Philippe', 'pde', '03b03872dd570959311f4fb9be01788e4d1a2abf', '13 rue Barthes', '94000', 'Créteil', '2010-12-14', 'visiteur', 0.62),
('c54', 'Debelle', 'Michel', 'mdebelle', '1fa95c2fac5b14c6386b73cbe958b663fc66fdfa', '181 avenue Barbusse', '93210', 'Rosny', '2006-11-23', 'visiteur', 0.62),
('d13', 'Debelle', 'Jeanne', 'jdebelle', '18c2cad6adb7cee7884f70108cfd0a9b448be9be', '134 allée des Joncs', '44000', 'Nantes', '2000-05-11', 'visiteur', 0.62),
('d51', 'Debroise', 'Michel', 'mdebroise', '46b609fe3aaa708f5606469b5bc1c0fa85010d76', '2 Bld Jourdain', '44000', 'Nantes', '2001-04-17', 'visiteur', 0.62),
('e22', 'Desmarquest', 'Nathalie', 'ndesmarquest', 'abc20ea01dabd079ddd63fd9006e7232e442973c', '14 Place d Arc', '45000', 'Orléans', '2005-11-12', 'visiteur', 0.62),
('e24', 'Desnost', 'Pierre', 'pdesnost', '8eaa8011ec8aa8baa63231a21d12f4138ccc1a3d', '16 avenue des Cèdres', '23200', 'Guéret', '2001-02-05', 'visiteur', 0.62),
('e39', 'Dudouit', 'Frédéric', 'fdudouit', '55072fa16c988da8f1fb31e40e4ac5f325ac145d', '18 rue de l église', '23120', 'GrandBourg', '2000-08-01', 'visiteur', 0.62),
('e49', 'Duncombe', 'Claude', 'cduncombe', '577576f0b2c56c43b596f701b782870c8742c592', '19 rue de la tour', '23100', 'La souteraine', '1987-10-10', 'visiteur', 0.62),
('e5', 'Enault-Pascreau', 'Céline', 'cenault', 'cc0fb4115bb04c613fd1b95f4792fc44f07e9f4f', '25 place de la gare', '23200', 'Gueret', '1995-09-01', 'visiteur', 0.62),
('e52', 'Eynde', 'Valérie', 'veynde', 'd06ace8d729693904c304625e6a6fab6ab9e9746', '3 Grand Place', '13015', 'Marseille', '1999-11-01', 'comptable', 0.62),
('f21', 'Finck', 'Jacques', 'jfinck', '6d8b2060b60132d9bdb09d37913fbef637b295f2', '10 avenue du Prado', '13002', 'Marseille', '2001-11-10', 'visiteur', 0.62),
('f39', 'Frémont', 'Fernande', 'ffremont', 'aa45efe9ecbf37db0089beeedea62ceb57db7f17', '4 route de la mer', '13012', 'Allauh', '1998-10-01', 'visiteur', 0.62),
('f4', 'Gest', 'Alain', 'agest', '1af7dedacbbe8ce324e316429a816daeff4c542f', '30 avenue de la mer', '13025', 'Berre', '1985-11-01', 'visiteur', 0.62);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `FicheFrais`
--
ALTER TABLE `FicheFrais`
  ADD CONSTRAINT `FicheFrais_ibfk_1` FOREIGN KEY (`idEtat`) REFERENCES `Etat` (`id`),
  ADD CONSTRAINT `FicheFrais_ibfk_2` FOREIGN KEY (`idVisiteur`) REFERENCES `User` (`id`);

--
-- Contraintes pour la table `LigneFraisForfait`
--
ALTER TABLE `LigneFraisForfait`
  ADD CONSTRAINT `LigneFraisForfait_ibfk_1` FOREIGN KEY (`idVisiteur`, `mois`) REFERENCES `FicheFrais` (`idVisiteur`, `mois`),
  ADD CONSTRAINT `LigneFraisForfait_ibfk_2` FOREIGN KEY (`idFraisForfait`) REFERENCES `FraisForfait` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
