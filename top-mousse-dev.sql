-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : lun. 12 déc. 2022 à 20:35
-- Version du serveur : 5.7.24
-- Version de PHP : 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `top-mousse-dev`
--

-- --------------------------------------------------------

--
-- Structure de la table `answer`
--

CREATE TABLE `answer` (
  `id` int(11) NOT NULL,
  `feedback_id` int(11) DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cart_item`
--

CREATE TABLE `cart_item` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `plate_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `volume` double NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` double NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shape` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `thickness` int(11) DEFAULT NULL,
  `width` int(11) DEFAULT NULL,
  `length` int(11) DEFAULT NULL,
  `diameter` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `configuration`
--

CREATE TABLE `configuration` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `configuration`
--

INSERT INTO `configuration` (`id`, `title`, `slug`, `content`) VALUES
(1, 'TVA', 'tva', '0.2'),
(2, 'Délai de fabrication, du type \"3 à 4 jours ouvrables\"', 'delai-de-fabrication-du-type-3-a-4-jours-ouvrables', '(4 a 7 jours ouvres)'),
(3, 'Délai pour les livraisons en point relai : du type \"3 à 4 jours ouvrables\"', 'delai-pour-les-livraisons-en-point-relai-du-type-3-a-4-jours-ouvrables', '(2 à 3 jours ouvrables)'),
(4, 'Délai pour les livraisons à domicile : du type \"4 à 6 jours ouvrables\"', 'delai-pour-les-livraisons-a-domicile-du-type-4-a-6-jours-ouvrables', '(1 à 2 jours ouvrables)'),
(5, 'Prix TTC de la livraison en point relay', 'prix-ttc-de-la-livraison-en-point-relay', '9'),
(6, 'Prix de la TVA pour les livraisons en points relay', 'prix-de-la-tva-pour-les-livraisons-en-points-relay', '1.50'),
(7, 'Prix TTC de la livraison à domicile', 'prix-ttc-de-la-livraison-a-domicile', '20'),
(8, 'Prix de la TVA pour les livraisons à domicile', 'prix-de-la-tva-pour-les-livraisons-a-domicile', '3.17'),
(9, 'Forfait mininmun des petits découpes', 'forfait-mininmun-des-petits-decoupes', '15'),
(10, 'Forfait maximum pour frais de port offerts', 'forfait-maximum-pour-frais-de-port-offerts', '200.00'),
(11, 'Volume maximum pour les points relay', 'volume-maximum-pour-les-points-relay', '4'),
(12, 'Prix minimum pour les petites commandes', 'prix-minimum-pour-les-petites-commandes', '1'),
(13, 'Taille supplémentaire pour les découpes spéciales', 'taille-supplementaire-pour-les-decoupes-speciales', '3');

-- --------------------------------------------------------

--
-- Structure de la table `cutting`
--

CREATE TABLE `cutting` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `billing_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `billing_postal_code` int(11) NOT NULL,
  `billing_city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shipping_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_postal_code` int(11) DEFAULT NULL,
  `shipping_city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_method` int(11) DEFAULT NULL,
  `shipping_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `payment_method` int(11) DEFAULT NULL,
  `shipping_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `packages` int(11) DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `density` int(11) DEFAULT NULL,
  `c_prod` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cutting_item`
--

CREATE TABLE `cutting_item` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `plate_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `volume` double NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` double NOT NULL,
  `shape` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `thickness` int(11) DEFAULT NULL,
  `width` int(11) DEFAULT NULL,
  `length` int(11) DEFAULT NULL,
  `diameter` int(11) DEFAULT NULL,
  `cutted` int(11) NOT NULL,
  `quality` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20210820124611', '2022-12-12 15:08:57', 68),
('DoctrineMigrations\\Version20210820124741', '2022-12-12 15:08:57', 5),
('DoctrineMigrations\\Version20210820124826', '2022-12-12 15:08:57', 41),
('DoctrineMigrations\\Version20210824121532', '2022-12-12 15:08:57', 21),
('DoctrineMigrations\\Version20210825122622', '2022-12-12 15:08:57', 22),
('DoctrineMigrations\\Version20210825131742', '2022-12-12 15:08:57', 23),
('DoctrineMigrations\\Version20210825135117', '2022-12-12 15:08:57', 23),
('DoctrineMigrations\\Version20210825135305', '2022-12-12 15:08:57', 38),
('DoctrineMigrations\\Version20210825140846', '2022-12-12 15:08:57', 10),
('DoctrineMigrations\\Version20210825140917', '2022-12-12 15:08:57', 8),
('DoctrineMigrations\\Version20210825144901', '2022-12-12 15:08:57', 8),
('DoctrineMigrations\\Version20210825153020', '2022-12-12 15:08:57', 20),
('DoctrineMigrations\\Version20210825153752', '2022-12-12 15:08:57', 47),
('DoctrineMigrations\\Version20210825154207', '2022-12-12 15:08:57', 28),
('DoctrineMigrations\\Version20210825154526', '2022-12-12 15:08:57', 29),
('DoctrineMigrations\\Version20210825155355', '2022-12-12 15:08:57', 37),
('DoctrineMigrations\\Version20210825160039', '2022-12-12 15:08:57', 29),
('DoctrineMigrations\\Version20210825161335', '2022-12-12 15:08:57', 32),
('DoctrineMigrations\\Version20210826132649', '2022-12-12 15:08:57', 18),
('DoctrineMigrations\\Version20210826132834', '2022-12-12 15:08:57', 30),
('DoctrineMigrations\\Version20210826133535', '2022-12-12 15:08:57', 29),
('DoctrineMigrations\\Version20210827122744', '2022-12-12 15:08:57', 31),
('DoctrineMigrations\\Version20210830123256', '2022-12-12 15:08:57', 59),
('DoctrineMigrations\\Version20210831132554', '2022-12-12 15:08:57', 32),
('DoctrineMigrations\\Version20210831134150', '2022-12-12 15:08:57', 61),
('DoctrineMigrations\\Version20210901193046', '2022-12-12 15:08:57', 57),
('DoctrineMigrations\\Version20210901193139', '2022-12-12 15:08:57', 57),
('DoctrineMigrations\\Version20210901194351', '2022-12-12 15:08:57', 30),
('DoctrineMigrations\\Version20210903123509', '2022-12-12 15:08:58', 99),
('DoctrineMigrations\\Version20210903123554', '2022-12-12 15:08:58', 38),
('DoctrineMigrations\\Version20210903123810', '2022-12-12 15:08:58', 165),
('DoctrineMigrations\\Version20210903123835', '2022-12-12 15:08:58', 6),
('DoctrineMigrations\\Version20210906132240', '2022-12-12 15:08:58', 63),
('DoctrineMigrations\\Version20210906132613', '2022-12-12 15:08:58', 151),
('DoctrineMigrations\\Version20210906140951', '2022-12-12 15:08:58', 32),
('DoctrineMigrations\\Version20210906141606', '2022-12-12 15:08:58', 31),
('DoctrineMigrations\\Version20210908132819', '2022-12-12 15:08:58', 39),
('DoctrineMigrations\\Version20210920081236', '2022-12-12 15:08:58', 36),
('DoctrineMigrations\\Version20210920081259', '2022-12-12 15:08:58', 48),
('DoctrineMigrations\\Version20210920082538', '2022-12-12 15:08:58', 33),
('DoctrineMigrations\\Version20210920082619', '2022-12-12 15:08:58', 39),
('DoctrineMigrations\\Version20210920095925', '2022-12-12 15:08:58', 28),
('DoctrineMigrations\\Version20210922081043', '2022-12-12 15:08:58', 47),
('DoctrineMigrations\\Version20210922093521', '2022-12-12 15:08:58', 31),
('DoctrineMigrations\\Version20210923075700', '2022-12-12 15:08:58', 33),
('DoctrineMigrations\\Version20210923080211', '2022-12-12 15:08:58', 33),
('DoctrineMigrations\\Version20211012125800', '2022-12-12 15:08:58', 32),
('DoctrineMigrations\\Version20211013134545', '2022-12-12 15:08:59', 29),
('DoctrineMigrations\\Version20211018131554', '2022-12-12 15:08:59', 34),
('DoctrineMigrations\\Version20211018131724', '2022-12-12 15:08:59', 31),
('DoctrineMigrations\\Version20211019113850', '2022-12-12 15:08:59', 69),
('DoctrineMigrations\\Version20211019115433', '2022-12-12 15:08:59', 30),
('DoctrineMigrations\\Version20221212151249', '2022-12-12 15:13:01', 1001);

-- --------------------------------------------------------

--
-- Structure de la table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `foam`
--

CREATE TABLE `foam` (
  `id` int(11) NOT NULL,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comfort` int(11) DEFAULT NULL,
  `density` int(11) DEFAULT NULL,
  `various` int(11) NOT NULL,
  `mattress` int(11) NOT NULL,
  `cake` int(11) NOT NULL,
  `sitting` int(11) NOT NULL,
  `back` int(11) NOT NULL,
  `cuff` int(11) NOT NULL,
  `pillow` int(11) NOT NULL,
  `cap` int(11) NOT NULL,
  `wedging` int(11) NOT NULL,
  `footstool` int(11) NOT NULL,
  `price_cube` double NOT NULL,
  `price_cylinder` double NOT NULL,
  `promo` int(11) NOT NULL,
  `line` int(11) NOT NULL,
  `reseller_price` double DEFAULT NULL,
  `reseller_price_ht` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `foam`
--

INSERT INTO `foam` (`id`, `reference`, `comfort`, `density`, `various`, `mattress`, `cake`, `sitting`, `back`, `cuff`, `pillow`, `cap`, `wedging`, `footstool`, `price_cube`, `price_cylinder`, `promo`, `line`, `reseller_price`, `reseller_price_ht`) VALUES
(5, 'NA40', 3, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 800, 1040, 0, 4, 930, 775),
(6, 'R38150', 2, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 521.07, 665.69, 0, 2, NULL, NULL),
(7, 'Mousse grise', NULL, NULL, 1, 0, 0, 0, 0, 0, 0, 0, 1, 0, 600, 780, 0, 0, NULL, NULL),
(8, 'T23140', 2, 2, 1, 1, 0, 0, 1, 0, 1, 0, 0, 0, 522.24, 678.92, 0, 1, NULL, NULL),
(9, 'T40300', 4, 3, 1, 0, 1, 1, 0, 1, 0, 0, 0, 1, 818.69, 1064.3, 0, 1, NULL, NULL),
(10, 'T28240', 4, 2, 1, 0, 1, 1, 0, 1, 0, 0, 0, 1, 587.43, 763.66, 0, 1, NULL, NULL),
(11, 'TM25190bleu', 2, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 800, 960, 0, 7, NULL, NULL),
(12, 'DRYFEEL', 2, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 900, 1080, 0, 6, NULL, NULL),
(13, 'R40160', 3, 3, 1, 1, 0, 1, 0, 0, 0, 0, 0, 0, 811.28, 1054.67, 0, 2, NULL, NULL),
(14, 'T25160', 2, 2, 1, 0, 1, 1, 0, 1, 1, 0, 0, 0, 556, 722.8, 0, 1, NULL, NULL),
(15, 'B35100', 1, 3, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 847.56, 1101.83, 1, 3, NULL, NULL),
(16, 'B30070', 1, 2, 1, 0, 0, 0, 1, 0, 0, 1, 0, 0, 798.11, 1037.54, 1, 3, NULL, NULL),
(17, 'B42190', 4, 3, 1, 0, 1, 1, 0, 1, 0, 0, 0, 0, 1068.27, 1388.75, 1, 3, NULL, NULL),
(18, 'T40240', 4, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 818.69, 1064.3, 0, 1, NULL, NULL),
(19, 'B40160', 3, 3, 1, 1, 0, 1, 0, 0, 0, 0, 0, 0, 899.25, 1169.03, 1, 3, NULL, NULL),
(20, 'B37130', 2, 3, 1, 1, 0, 1, 0, 1, 0, 0, 0, 0, 861, 1119.3, 1, 3, NULL, NULL),
(21, 'R35130', 2, NULL, 1, 1, 0, 1, 1, 1, 0, 0, 0, 0, 663.65, 862.74, 1, 2, NULL, NULL),
(22, 'T30180', 3, 2, 1, 0, 1, 1, 0, 1, 0, 0, 0, 1, 575.25, 747.83, 0, 1, NULL, NULL),
(23, 'T20120', 1, 1, 1, 1, 0, 0, 1, 0, 0, 0, 0, 0, 470.8, 612.04, 0, 1, NULL, NULL),
(24, '17F', 1, 1, 1, 0, 0, 0, 0, 0, 1, 1, 1, 0, 428.71, 557.32, 0, 1, 400, 430),
(25, '20F', 3, 2, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 430, 430, 1, 1, 430, 430);

-- --------------------------------------------------------

--
-- Structure de la table `invoice`
--

CREATE TABLE `invoice` (
  `id` int(11) NOT NULL,
  `number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payement_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fee` int(11) DEFAULT NULL,
  `date_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `invoice`
--

INSERT INTO `invoice` (`id`, `number`, `status`, `name`, `email`, `address`, `city`, `postal_code`, `country`, `phone`, `payement_type`, `shipment`, `fee`, `date_at`) VALUES
(1, '12.12.2022-1', 'Réglé', 'VALLIER AXEL', 'test@gmail.com', '75 dekedjkej', 'kjkj', '75000', 'FRANCE', '0659631174', 'En ligne', 'Domicile', 19, '2022-12-12 00:00:00'),
(2, '12.12.2022-1', 'Réglé', 'VALLIER AXEL', 'test@gmail.com', '75 dekedjkej', 'kjkj', '75000', 'FRANCE', '0659631174', 'En ligne', 'Domicile', 19, '2022-12-12 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `invoice_article`
--

CREATE TABLE `invoice_article` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  `shape` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `use_case` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ref` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `length` int(11) DEFAULT NULL,
  `longueur` int(11) DEFAULT NULL,
  `diametre` int(11) DEFAULT NULL,
  `volume` double DEFAULT NULL,
  `price_ht` double DEFAULT NULL,
  `price_ttc` double DEFAULT NULL,
  `tva` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `invoice_article`
--

INSERT INTO `invoice_article` (`id`, `invoice_id`, `shape`, `use_case`, `ref`, `quantity`, `height`, `length`, `longueur`, `diametre`, `volume`, `price_ht`, `price_ttc`, `tva`) VALUES
(1, 1, 'Cylindre', 'Matelas', '5454554', 5, 5, 5, 55, 5, 5, 52, 60, 25),
(2, 2, 'Cylindre', 'Matelas', '5454554', 5, 5, 5, 55, 5, 5, 52, 60, 25);

-- --------------------------------------------------------

--
-- Structure de la table `log`
--

CREATE TABLE `log` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `log`
--

INSERT INTO `log` (`id`, `user_id`, `title`, `ip`, `created_at`) VALUES
(1, 11, 'Authentification réussie.', '127.0.0.1', '2022-12-12 15:16:35'),
(2, 20, 'Inscription réussie.', '127.0.0.1', '2022-12-12 15:20:49'),
(3, 11, 'Authentification réussie.', '127.0.0.1', '2022-12-12 15:22:27'),
(4, 11, 'Authentification réussie.', '127.0.0.1', '2022-12-12 15:38:50');

-- --------------------------------------------------------

--
-- Structure de la table `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `billing_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `billing_postal_code` int(11) NOT NULL,
  `billing_city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shipping_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_postal_code` int(11) DEFAULT NULL,
  `shipping_city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `shipping_method` int(11) DEFAULT NULL,
  `payment_method` int(11) DEFAULT NULL,
  `shipping_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `packages` int(11) DEFAULT NULL,
  `shipping_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `order`
--

INSERT INTO `order` (`id`, `user_id`, `status`, `first_name`, `last_name`, `email`, `billing_address`, `billing_postal_code`, `billing_city`, `shipping_address`, `shipping_postal_code`, `shipping_city`, `created_at`, `shipping_method`, `payment_method`, `shipping_number`, `order_number`, `packages`, `shipping_code`, `phone`, `company`) VALUES
(1, 11, 8, 'admin', 'admin', 'admin@mail.fr', 'route de neuville', 59470, 'ville des admins', NULL, NULL, NULL, '2022-12-12 15:22:39', 3, 3, 'EXP1245488787545', '125548784', NULL, 'EXP1245488787545', '070000000', NULL),
(2, 11, 4, 'admin', 'admin', 'admin@mail.fr', 'route de neuville', 59470, 'ville des admins', NULL, NULL, NULL, '2022-12-12 15:48:28', 3, 3, NULL, '1254668', NULL, NULL, '070000000', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `order_item`
--

CREATE TABLE `order_item` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `plate_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `volume` double NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` double NOT NULL,
  `shape` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `thickness` int(11) DEFAULT NULL,
  `width` int(11) DEFAULT NULL,
  `length` int(11) DEFAULT NULL,
  `diameter` int(11) DEFAULT NULL,
  `cutted` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `order_item`
--

INSERT INTO `order_item` (`id`, `product_id`, `plate_id`, `order_id`, `title`, `volume`, `quantity`, `price`, `shape`, `thickness`, `width`, `length`, `diameter`, `cutted`) VALUES
(1, NULL, 2, 1, 'Polyéther - 40 kg - 15x170x200', 0.51, 1, 396.66, 'cube', 15, 170, 200, 0, 0),
(2, 10, NULL, 1, 'Fauteuil club enfant', 0.04, 1, 18, 'cube', NULL, 0, 0, 0, 0),
(3, NULL, NULL, 2, 'Découpe divers T40300', 0.018, 3, 44.20926, 'carre', 15, 120, 10, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `page`
--

CREATE TABLE `page` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `draft` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `page`
--

INSERT INTO `page` (`id`, `title`, `slug`, `content`, `draft`) VALUES
(6, 'Contenu de la page d\'accueil', 'contenu-de-la-page-d-accueil', '<p>TopMousse.net vous propose une gamme de mousse sur mesure sp&eacute;cialement &eacute;tudi&eacute;e pour chaque utilisation.</p>\r\n<p>- Mousse Poly&eacute;ther<br />- Mousse Haute R&eacute;silience<br />- Mousse Comfort Bultex&reg;</p>\r\n<p><strong>Ch&egrave;res clientes, chers clients, Notre d&eacute;lai de pr&eacute;paration actuel est de 4 &agrave; 6 jours (ouvr&eacute;s) Nos d&eacute;lais de livraison sont de 24/48h &agrave; domicile et de 2 &agrave; 3 jours en point relais.</strong></p>\r\n<p><strong>Cordialement, L\'&eacute;quipe Topmousse.net</strong></p>', 0),
(7, 'Conditions générales de vente', 'conditions-generales-de-vente', '<h2>1 - Identification du vendeur</h2>\r\n<p>Le site Topmousse (www.topmousse.net) est une enseigne de la soci&eacute;t&eacute; VIRTUASHOP,<br />SARL au capital de 1.000,00 &euro;<br />N&deg; Siret : 804.975.126.00017 - APE : 4791A<br />RCS : Lille M&eacute;tropole B 403 875 586<br />TVA Intracommunautaire : FR 804 975 126<br />SARL Virtuashop<br />12 Avenue de Menin ZI rouge Porte<br />59250 HALLUIN<br />03 20 23 23 74</p>\r\n<h2>2 - Heures d\'ouverture de l\'accueil t&eacute;l&eacute;phonique</h2>\r\n<p>Du lundi au vendredi de 9h &agrave; 12h. et de 14h &agrave; 17h<br />Ferm&eacute; les samedis, dimanches et jours f&eacute;ri&eacute;s</p>\r\n<h2>3 - Loi applicable - Litiges</h2>\r\n<p>Toute commande adress&eacute;e &agrave; VIRTUASHOP par quelque moyen que ce soit implique l&rsquo;acceptation sans r&eacute;serve des pr&eacute;sentes conditions g&eacute;n&eacute;rales de ventes. Il appartient &agrave; chaque client, professionnel ou particulier, de prendre connaissance des conditions g&eacute;n&eacute;rales de ventes de VIRTUASHOP avant de passer commande.</p>\r\n<p>Les commandes sont soumises &agrave; la loi fran&ccedil;aise. Les informations contractuelles sont pr&eacute;sent&eacute;es en langue fran&ccedil;aise et les produits propos&eacute;s &agrave; la vente sont conformes &agrave; la r&eacute;glementation fran&ccedil;aise. Le cas &eacute;ch&eacute;ant, il appartient au client &eacute;tranger de v&eacute;rifier aupr&egrave;s des autorit&eacute;s locales les possibilit&eacute;s d&rsquo;utilisation du produit qu&rsquo;il envisage de commander ; la responsabilit&eacute; de VIRTUASHOP ne saurait &ecirc;tre engag&eacute;e en cas de non-respect de la r&eacute;glementation d&rsquo;un pays &eacute;tranger o&ugrave; le produit est livr&eacute;. En cas de litige les tribunaux fran&ccedil;ais sont seuls comp&eacute;tents.</p>\r\n<p>Dans le cadre d&rsquo;un litige opposant VIRTUASHOP &agrave; un tiers, seule, la comp&eacute;tence exclusive des Tribunaux de l&rsquo;ordre judiciaire de Lille pourra &ecirc;tre retenue.</p>\r\n<h2>4 - Pr&eacute;sentation des produits</h2>\r\n<p>Les caract&eacute;ristiques des produits propos&eacute;s &agrave; la vente sont pr&eacute;sent&eacute;es sur le site Internet www.topmousse.net (ci-apr&egrave;s appel&eacute; &laquo; le site &raquo;). Les photographies n&rsquo;entrent pas dans le champ contractuel. La responsabilit&eacute; de VIRTUASHOP ne peut &ecirc;tre engag&eacute;e si des erreurs s&rsquo;y sont introduites. Tous les textes et images pr&eacute;sent&eacute;s sur le site sont r&eacute;serv&eacute;s, pour le monde entier, au titre des droits d&rsquo;auteur et de propri&eacute;t&eacute; intellectuelle ; leur reproduction, m&ecirc;me partielle est strictement interdite sans l&rsquo;accord formel de VIRTUASHOP. De m&ecirc;me, toute mise en place de liens hypertextes vers le site sans autorisation expresse du repr&eacute;sentant l&eacute;gal de l&rsquo;entreprise est formellement interdite.</p>\r\n<h2>5 - Dur&eacute;e de validit&eacute; des offres de vente</h2>\r\n<p>Les produits sont propos&eacute;s &agrave; la vente jusqu&rsquo;&agrave; &eacute;puisement du stock chez nos fournisseurs. En cas de commande d&rsquo;un produit devenu indisponible, VIRTUASHOP ne pourra en &ecirc;tre tenu pour responsable et le client en sera inform&eacute; de cette indisponibilit&eacute;, dans les meilleurs d&eacute;lais, par e-mail, par fax ou par courrier.</p>\r\n<h2>6 - Prix des produits</h2>\r\n<p>Le site indique les prix en euros toutes taxes comprises, hors frais de port.</p>\r\n<p>Le montant de la TVA et les frais de port apparaissent &agrave; l&rsquo;&eacute;cran &agrave; la fin de la s&eacute;lection des diff&eacute;rents produits par le client avant la validation de la commande.</p>\r\n<p>VIRTUASHOP se r&eacute;serve le droit de modifier ses prix &agrave; tout moment, les produits command&eacute;s sont factur&eacute;s au prix en vigueur lors de l&rsquo;enregistrement de la commande.</p>\r\n<p>La TVA est redevable pour toute commande pass&eacute;e sur le site www.topmousse.net. Seuls les r&eacute;sidents Suisse et des DOM-TOM, ainsi que les soci&eacute;t&eacute;s de la zone euro communiquant leur num&eacute;ro de TVA intracommunautaire pourront &ecirc;tre exon&eacute;r&eacute;s de TVA. Les frais de douane ainsi que les &eacute;ventuels droits et taxes restent enti&egrave;rement &agrave; la charge du client.</p>\r\n<h2>7 - Commandes</h2>\r\n<p>Le client valide sa commande lorsqu&rsquo;il active le lien &laquo; CONFIRMER LA COMMANDE &raquo; en bas de la page &laquo; ETAPE 3 VALIDATION &raquo; ;</p>\r\n<p>Il accepte alors le processus de commande et les pr&eacute;sentes conditions g&eacute;n&eacute;rales de vente.</p>\r\n<p>Le client re&ccedil;oit confirmation de sa commande par email ; cette confirmation, automatique, reprend tous les &eacute;l&eacute;ments de la commande. Apr&egrave;s traitement de la commande, VIRTUASHOP envoie au client un second email apportant &eacute;ventuellement des pr&eacute;cisions et indiquant les d&eacute;lais de livraison. Un troisi&egrave;me email est envoy&eacute; au client le jour de l&rsquo;exp&eacute;dition des produits.</p>\r\n<p>Les donn&eacute;es enregistr&eacute;es par VIRTUASHOP constituent la preuve de la nature, du contenu et de la date de la commande. Celle-ci est archiv&eacute;e par VIRTUASHOP ; le client peut acc&eacute;der &agrave; cet archivage en contactant le Service Client par email adress&eacute; &agrave; Topmousse.net@gmail.com</p>\r\n<p>Concernant les commandes par fax &eacute;manant d&rsquo;entreprises, seules les factures pro-forma ou devis de VIRTUASHOP d&ucirc;ment sign&eacute;s par un repr&eacute;sentant l&eacute;gal et accompagn&eacute;s de la mention &laquo; Bon pour accord, lu et approuv&eacute; &raquo; ainsi que du cachet de la soci&eacute;t&eacute; cliente seront pris en compte.</p>\r\n<h2>8 - Paiements</h2>\r\n<p>Le paiement peut-&ecirc;tre effectu&eacute; de trois mani&egrave;res :</p>\r\n<ul>\r\n<li>- Carte bancaire en ligne : La partie d&eacute;di&eacute;e au paiement en ligne du site www.topmousse.net est confi&eacute;e &agrave; PAYPAL. Apr&egrave;s validation de la commande, le client est dirig&eacute; sur le site s&eacute;curis&eacute; de PAYPAL pour saisir les informations n&eacute;cessaires &agrave; la transaction de paiement. VIRTUASHOP n\'intervient pas dans ce processus de paiement et n\'a aucune connaissance de vos coordonn&eacute;es bancaires.</li>\r\n<li>- Ch&egrave;que bancaire : Le ch&egrave;que, doit &ecirc;tre libell&eacute; &agrave; l&rsquo;ordre de VIRTUASHOP. il faudra accompagner le ch&egrave;que d\'une copie de l\'email de confirmation de commande que nous vous avons adress&eacute;, ou bien indiquer au dos du ch&egrave;que les r&eacute;f&eacute;rences de la commande. La commande sera mise en production d&egrave;s r&eacute;ception du r&egrave;glement.</li>\r\n<li>- Virement bancaire : Un virement correspondant au montant total de la commande devra &ecirc;tre effectu&eacute; sur le compte de Virtuashop, les coordonn&eacute;es n&eacute;cessaires &agrave; la transaction sont indiqu&eacute;es sur l\'email de confirmation de commande adress&eacute; au client apr&egrave;s validation &agrave; la fin du processus de commande.</li>\r\n</ul>\r\n<p>La validation d&eacute;finitive de la commande et la livraison de celle-ci sont subordonn&eacute;es &agrave; la r&eacute;ception d&rsquo;un virement d\'un montant correspondant au montant total en euros de la commande, les &eacute;ventuels frais dus au virement, quels qu\'ils soient, &eacute;tant int&eacute;gralement &agrave; la charge de l&rsquo;acheteur.</p>\r\n<h2>9 - Retour et Remboursements, droit de r&eacute;tractation.</h2>\r\n<p>Topmousse.net s\'associe avec des prestataires prestigieux pour vous offrir des produits de grandes qualit&eacute;s. Il se peut malgr&eacute; tous nos efforts que le client ne soit pas pleinement satisfait et souhaite retourner sa commande. Dans ce cas, Topmousse.net acc&egrave;dera &agrave; sa requ&ecirc;te dans ces conditions :</p>\r\n<p>Le client dispose de 14 jours de d&eacute;lai de r&eacute;traction comme pr&eacute;vu par la loi (article L121-20 du Code de la consommation) &agrave; r&eacute;ception de sa commande. Pass&eacute; ce d&eacute;lai, les articles command&eacute;s aupr&egrave;s de nos fournisseurs ne sont ni repris ni &eacute;chang&eacute;s sauf en cas de d&eacute;fauts de fabrication av&eacute;r&eacute;s. Dans ce cas nous proc&eacute;derons au remboursement total de la commande, les frais de livraison initiaux restant &agrave; la charge du client, dans les conditions ci-apr&egrave;s.<br />Le client doit contacter le service client pour obtenir un bon de retour qui lui sera envoy&eacute; par e-mail ou par voie postale. Il devra joindre ce bon de retour &agrave; son exp&eacute;dition sous peine de nullit&eacute; de sa requ&ecirc;te.<br />Le ou les articles doivent &ecirc;tre conserv&eacute;s dans leurs emballages d\'origine<br />Le client dispose de 8 jours &agrave; compter de la r&eacute;ception de sa commande pour retourner l\'article d&eacute;fectueux.<br />Les frais de r&eacute;exp&eacute;dition du colis seront &agrave; la charge du client.</p>\r\n<p>Exception : les frais de r&eacute;exp&eacute;dition seront pris en charge par Topmousse.net en cas de retour de produits d&eacute;fectueux ou de livraison de la mauvaise r&eacute;f&eacute;rence de produit command&eacute;. Le remboursement de ces frais se fera apr&egrave;s r&eacute;ception du produit.<br />Le remboursement ou l\'&eacute;change de l\'article d&eacute;fectueux se fera alors dans un d&eacute;lai maximal de 30 jours &agrave; r&eacute;ception de l\'article. Pass&eacute; ce d&eacute;lai, il appartient au client de recontacter le service client afin d\'obtenir satisfaction.<br />Le client peut se faire rembourser sous forme d\'avoir ou de virement bancaire.</p>\r\n<p>L&rsquo;exercice du droit de r&eacute;tractation n&rsquo;est pas possible pour les contrats :</p>\r\n<ul>\r\n<li>- De fourniture de biens confectionn&eacute;s selon les sp&eacute;cifications du consommateur ou nettement personnalis&eacute;s</li>\r\n<li>- De fourniture de biens susceptibles de se d&eacute;t&eacute;riorer ou de se p&eacute;rimer rapidement</li>\r\n<li>- De fourniture de biens qui, apr&egrave;s avoir &eacute;t&eacute; livr&eacute;s, et de par leur nature, sont m&eacute;lang&eacute;s de mani&egrave;re indissociable avec d&rsquo;autres articles</li>\r\n</ul>\r\n<p>De ce fait, les mousses d&eacute;coup&eacute;es sur mesure, sont exclus du champ d\'application du droit de r&eacute;tractation et de retour.<br />Pour ces produits, seul le cas de d&eacute;faut &eacute;vident constat&eacute; et admis par Topmousse.net pourra donner lieu &agrave; &eacute;change.</p>\r\n<h2>10 - Livraison</h2>\r\n<p>Les d&eacute;lais de livraisons sont donn&eacute;s &agrave; titre indicatif, ils peuvent varier selon le transporteur, le contexte politico-social et les conditions climatiques. Topmousse.net ne peut &ecirc;tre tenu pour responsable dans le retard de livraison de votre marchandise, en cas de difficult&eacute;s de livraison, le client devra s\'informer aupr&egrave;s du transporteur ou contacter notre service client&egrave;le. La livraison est effectu&eacute;e &agrave; l\'adresse de livraison fournie par le client lors de sa commande. Dans le cas o&ugrave; la commande serait livr&eacute;e en plusieurs fois, topmousse.net en informera par e-mail le client lors de l\'envoi de r&eacute;capitulatif de commande et lors de chaque exp&eacute;dition. Le colis sera r&eacute;put&eacute; non livr&eacute; 30 jours apr&egrave;s son exp&eacute;dition par Topmousse.net.</p>\r\n<h2>11 - Protection des donn&eacute;es personnelles</h2>\r\n<p>Topmousse.net enregistre vos donn&eacute;es lorsque vous cr&eacute;ez un compte, vous vous abonnez &agrave; nos newsletters ou commandez sur notre site. Ces donn&eacute;es sont conserv&eacute;es dans un fichier &agrave; usage unique de Topmousse.net afin de traiter votre commande ou d\'&eacute;tablir une relation commerciale avec vous et font l\'objet d\'une d&eacute;claration &agrave; la CNIL. Ces donn&eacute;es peuvent &ecirc;tre transmises aux fournisseurs ou aux transporteurs uniquement dans le cadre de traitement de vos commandes. Conform&eacute;ment &agrave; la loi du 6 janvier 1978, vous disposez d\'un droit d\'acc&egrave;s, de modification, de rectification et de suppression de ces donn&eacute;es par le biais de votre espace client, par e-mail &agrave; topmousse.net@gmail.com ou par courrier. Vous pouvez vous opposer &agrave; la divulgation de ces donn&eacute;es en adressant express&eacute;ment un courrier au si&egrave;ge de Topmousse.net.</p>\r\n<h2>12 - R&eacute;serve de propri&eacute;t&eacute;</h2>\r\n<p>Les produits vendus sur le site de Topmousse.net demeurent la propri&eacute;t&eacute; de Topmousse.net tant que le paiement des produits command&eacute;s n\'est pas effectif.</p>', 0);

-- --------------------------------------------------------

--
-- Structure de la table `plate`
--

CREATE TABLE `plate` (
  `id` int(11) NOT NULL,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `density` int(11) NOT NULL,
  `thickness` int(11) NOT NULL,
  `width` int(11) NOT NULL,
  `length` int(11) NOT NULL,
  `volume` double NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `price_ttc` double NOT NULL,
  `price_ht` double NOT NULL,
  `delivery` int(11) NOT NULL,
  `promo` int(11) NOT NULL,
  `best_seller` int(11) NOT NULL,
  `declination` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stock` int(11) NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `draft` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `plate`
--

INSERT INTO `plate` (`id`, `reference`, `title`, `density`, `thickness`, `width`, `length`, `volume`, `content`, `price_ttc`, `price_ht`, `delivery`, `promo`, `best_seller`, `declination`, `thumbnail`, `stock`, `slug`, `draft`, `created_at`, `type`) VALUES
(2, 'T40300 15CM', 'Mousse', 40, 15, 170, 200, 0.51, '<p>&nbsp;</p>\r\n<div>Caract&eacute;ristiques :</div>\r\n<div>\r\n<ul>\r\n<li>Mousse poly&eacute;ther</li>\r\n<li>Confort tr&egrave;s ferme (kpa : 7.50)</li>\r\n<li>Densit&eacute; tr&egrave;s forte</li>\r\n<li>Le rebord des plaques poss&egrave;de une cro&ucirc;te, il sera n&eacute;cessaire de les red&eacute;couper par vos soins</li>\r\n</ul>\r\n</div>\r\n<p class=\"MsoNormal\">Champs d\'application :</p>\r\n<ol>\r\n<li>Poufs</li>\r\n</ol>\r\n<div>Dimensions : 15cm x 170cm x 200cm</div>', 396.66, 330.55, 1, 0, 1, NULL, 'plaques-613f519a8dfb0.jpg', 2, 'mousse', 0, '2021-08-27 14:30:59', 'Polyéther'),
(3, 'T40300 12CM', 'Mousse', 40, 12, 170, 200, 0.408, '<p>&nbsp;</p>\r\n<div>Caract&eacute;ristiques :</div>\r\n<div>\r\n<ul>\r\n<li>Mousse poly&eacute;ther</li>\r\n<li>Confort tr&egrave;s ferme (kpa : 7.50)</li>\r\n<li>Densit&eacute; tr&egrave;s forte</li>\r\n<li>Le rebord des plaques poss&egrave;de une cro&ucirc;te, il sera n&eacute;cessaire de les red&eacute;couper par vos soins</li>\r\n</ul>\r\n</div>\r\n<p class=\"MsoNormal\">Champs d\'application :</p>\r\n<ol>\r\n<li>Poufs</li>\r\n</ol>\r\n<div>Dimensions : 12cm x 170cm x 200cm</div>', 317.32, 264.44, 1, 0, 1, NULL, 'plaques-6139f3c371ea3.jpg', 100, 'mousse', 0, '2021-08-27 14:32:15', 'Polyéther'),
(4, 'T40300 5CM', 'Mousse', 40, 5, 170, 200, 0.17, '<p>&nbsp;</p>\r\n<div>Caract&eacute;ristiques :</div>\r\n<div>\r\n<ul>\r\n<li>Mousse poly&eacute;ther</li>\r\n<li>Confort tr&egrave;s ferme (kpa : 7.50)</li>\r\n<li>Densit&eacute; tr&egrave;s forte</li>\r\n<li>Le rebord des plaques poss&egrave;de une cro&ucirc;te, il sera n&eacute;cessaire de les red&eacute;couper par vos soins</li>\r\n</ul>\r\n</div>\r\n<p class=\"MsoNormal\">Champs d\'application :</p>\r\n<ol>\r\n<li>Poufs</li>\r\n</ol>\r\n<div>Dimensions : 5cm x 170cm x 200cm</div>', 132.22, 110.18, 1, 0, 1, NULL, 'plaques-6139f3c778cd4.jpg', 95, 'mousse', 0, '2021-08-27 14:33:39', 'Polyéther'),
(5, 'T40300 10CM', 'Mousse', 40, 10, 170, 200, 0.34, '<p>&nbsp;</p>\r\n<div>Caract&eacute;ristiques :</div>\r\n<div>\r\n<ul>\r\n<li>Mousse poly&eacute;ther</li>\r\n<li>Confort tr&egrave;s ferme (kpa : 7.50)</li>\r\n<li>Densit&eacute; tr&egrave;s forte</li>\r\n<li>Le rebord des plaques poss&egrave;de une cro&ucirc;te, il sera n&eacute;cessaire de les red&eacute;couper par vos soins</li>\r\n</ul>\r\n</div>\r\n<p class=\"MsoNormal\">Champs d\'application :</p>\r\n<ol>\r\n<li>Poufs</li>\r\n</ol>\r\n<div>Dimensions : 10cm x 170cm x 200cm</div>', 264.44, 220.36, 0, 0, 1, NULL, 'plaques-6139f3cb3570f.jpg', 97, 'mousse', 0, '2021-08-27 14:34:56', 'Polyéther'),
(6, 'T40300 8CM', 'Mousse', 40, 8, 170, 200, 0.272, '<p>&nbsp;</p>\r\n<div>Caract&eacute;ristiques :</div>\r\n<div>\r\n<ul>\r\n<li>Mousse poly&eacute;ther</li>\r\n<li>Confort tr&egrave;s ferme (kpa : 7.50)</li>\r\n<li>Densit&eacute; tr&egrave;s forte</li>\r\n<li>Le rebord des plaques poss&egrave;de une cro&ucirc;te, il sera n&eacute;cessaire de les red&eacute;couper par vos soins</li>\r\n</ul>\r\n</div>\r\n<p class=\"MsoNormal\">Champs d\'application :</p>\r\n<ol>\r\n<li>Poufs</li>\r\n</ol>\r\n<div>Dimensions : 8cm x 170cm x 200cm</div>', 211.55, 176.29, 1, 0, 1, NULL, 'plaques-6139f3ced6999.jpg', 98, 'mousse', 0, '2021-08-27 14:36:03', 'Polyéther'),
(7, 'T30180 15CM', 'Mousse', 30, 15, 170, 200, 0.51, '<p>&nbsp;</p>\r\n<div>Caract&eacute;ristiques :</div>\r\n<div>\r\n<ul>\r\n<li>Mousse poly&eacute;ther</li>\r\n<li>Confort ferme (kpa +/- 4.50)</li>\r\n<li>Densit&eacute; Moyenne</li>\r\n<li>Le rebord des plaques poss&egrave;de une cro&ucirc;te, il sera n&eacute;cessaire de les red&eacute;couper par vos soins</li>\r\n</ul>\r\n</div>\r\n<p class=\"MsoNormal\">Champs d\'application :</p>\r\n<ol>\r\n<li>Galettes de Chaise</li>\r\n<li>Assises (fauteuil, caravane, camping car ou Mobil Home)</li>\r\n<li>Manchette de fauteuil</li>\r\n<li>Pouf</li>\r\n</ol>\r\n<div>Dimensions : 15cm x 170cm x 200cm</div>', 278.71, 232.26, 1, 0, 1, NULL, 'plaques-6139f3d2a63e9.jpg', 99, 'mousse', 0, '2021-08-27 14:37:09', 'Polyéther'),
(8, 'T30180 12CM', 'Mousse', 30, 12, 170, 200, 0.408, '<p>&nbsp;</p>\r\n<div>Caract&eacute;ristiques :</div>\r\n<div>\r\n<ul>\r\n<li>Mousse poly&eacute;ther</li>\r\n<li>Confort ferme (kpa +/- 4.50)</li>\r\n<li>Densit&eacute; Moyenne</li>\r\n<li>Le rebord des plaques poss&egrave;de une cro&ucirc;te, il sera n&eacute;cessaire de les red&eacute;couper par vos soins</li>\r\n</ul>\r\n</div>\r\n<p class=\"MsoNormal\">Champs d\'application :</p>\r\n<ol>\r\n<li>Galettes de Chaise</li>\r\n<li>Assises (fauteuil, caravane, camping car ou Mobil Home)</li>\r\n<li>Manchette de fauteuil</li>\r\n<li>Pouf</li>\r\n</ol>\r\n<div>Dimensions : 12cm x 170cm x 200cm</div>', 222.97, 185.81, 1, 0, 1, NULL, 'plaques-6139f3d66aa1b.jpg', 99, 'mousse', 0, '2021-08-27 14:38:05', 'Polyéther'),
(9, 'T30180 10CM', 'Mousse', 30, 10, 170, 200, 0.34, '<p>&nbsp;</p>\r\n<div>Caract&eacute;ristiques :</div>\r\n<div>\r\n<ul>\r\n<li>Mousse poly&eacute;ther</li>\r\n<li>Confort ferme (kpa +/- 4.50)</li>\r\n<li>Densit&eacute; Moyenne</li>\r\n<li>Le rebord des plaques poss&egrave;de une cro&ucirc;te, il sera n&eacute;cessaire de les red&eacute;couper par vos soins</li>\r\n</ul>\r\n</div>\r\n<p class=\"MsoNormal\">Champs d\'application :</p>\r\n<ol>\r\n<li>Galettes de Chaise</li>\r\n<li>Assises (fauteuil, caravane, camping car ou Mobil Home)</li>\r\n<li>Manchette de fauteuil</li>\r\n<li>Pouf</li>\r\n</ol>\r\n<div>Dimensions : 10cm x 170cm x 200cm</div>', 185.81, 154.84, 1, 0, 1, NULL, 'plaques-6139f3d9ebe9b.jpg', 100, 'mousse', 0, '2021-08-27 14:39:12', 'Polyéther'),
(10, 'T30180 5CM', 'Mousse', 30, 5, 170, 200, 0.17, '<p>&nbsp;</p>\r\n<div>Caract&eacute;ristiques :</div>\r\n<div>\r\n<ul>\r\n<li>Mousse poly&eacute;ther</li>\r\n<li>Confort ferme (kpa +/- 4.50)</li>\r\n<li>Densit&eacute; Moyenne</li>\r\n<li>Le rebord des plaques poss&egrave;de une cro&ucirc;te, il sera n&eacute;cessaire de les red&eacute;couper par vos soins</li>\r\n</ul>\r\n</div>\r\n<p class=\"MsoNormal\">Champs d\'application :</p>\r\n<ol>\r\n<li>Galettes de Chaise</li>\r\n<li>Assises (fauteuil, caravane, camping car ou Mobil Home)</li>\r\n<li>Manchette de fauteuil</li>\r\n<li>Pouf</li>\r\n</ol>\r\n<div>Dimensions : 5cm x 170cm x 200cm</div>', 92.9, 77.42, 1, 0, 1, NULL, 'plaques-6139f3dd783d0.jpg', 100, 'mousse', 0, '2021-08-27 14:41:48', 'Polyéther'),
(11, 'T30180 8CM', 'Mousse', 30, 8, 170, 200, 0.272, '<p>&nbsp;</p>\r\n<div>Caract&eacute;ristiques :</div>\r\n<div>\r\n<ul>\r\n<li>Mousse poly&eacute;ther</li>\r\n<li>Confort ferme (kpa +/- 4.50)</li>\r\n<li>Densit&eacute; Moyenne</li>\r\n<li>Le rebord des plaques poss&egrave;de une cro&ucirc;te, il sera n&eacute;cessaire de les red&eacute;couper par vos soins</li>\r\n</ul>\r\n</div>\r\n<p class=\"MsoNormal\">Champs d\'application :</p>\r\n<ol>\r\n<li>Galettes de Chaise</li>\r\n<li>Assises (fauteuil, caravane, camping car ou Mobil Home)</li>\r\n<li>Manchette de fauteuil</li>\r\n<li>Pouf</li>\r\n</ol>\r\n<div>Dimensions : 8cm x 170cm x 200cm</div>', 148.64, 123.87, 1, 0, 1, NULL, 'plaques-6139f3e10826c.jpg', 100, 'mousse', 0, '2021-08-27 14:42:44', 'Polyéther'),
(12, 'T17100 15CM', 'Mousse', 17, 15, 200, 200, 0.6, '<p>&nbsp;</p>\r\n<p class=\"MsoNormal\">Caract&eacute;ristiques :</p>\r\n<ul>\r\n<li>Mousse poly&eacute;ther</li>\r\n<li>Confort souple&nbsp;(Kpa +/- 2.50)</li>\r\n<li>Densit&eacute; faible</li>\r\n</ul>\r\n<p>Champs d\'application :</p>\r\n<ol>\r\n<li>Coussins</li>\r\n</ol>\r\n<p>Dimensions 15cm x 200cm x 200cm</p>\r\n<p class=\"MsoNormal\">Excellent rapport qualit&eacute; prix.</p>', 244.36, 203.64, 1, 0, 1, NULL, 'plaques-6139f3e6515b4.jpg', 100, 'mousse', 0, '2021-08-27 14:43:41', 'Polyéther'),
(13, 'T17100 12CM', 'Mousse', 17, 12, 200, 200, 0.48, '<p>&nbsp;</p>\r\n<p class=\"MsoNormal\">Caract&eacute;ristiques :</p>\r\n<ul>\r\n<li>Mousse poly&eacute;ther</li>\r\n<li>Confort souple&nbsp;(Kpa +/- 2.50)</li>\r\n<li>Densit&eacute; faible</li>\r\n</ul>\r\n<p class=\"MsoNormal\">Champs d\'application :</p>\r\n<ol>\r\n<li>Coussins</li>\r\n</ol>\r\n<p class=\"MsoNormal\">Dimensions 12cm x 200cm x 200cm</p>\r\n<p class=\"MsoNormal\">Excellent rapport qualit&eacute; prix.</p>', 195.49, 162.91, 1, 0, 1, NULL, 'plaques-6139f3ea1d525.jpg', 100, 'mousse', 0, '2021-08-27 14:44:38', 'Polyéther'),
(14, 'T171005CM', 'Mousse', 17, 5, 200, 200, 0.2, '<p>&nbsp;</p>\r\n<p class=\"MsoNormal\">Caract&eacute;ristiques :</p>\r\n<ul>\r\n<li>Mousse poly&eacute;ther</li>\r\n<li>Confort souple&nbsp;(Kpa +/- 2.50)</li>\r\n<li>Densit&eacute; faible</li>\r\n</ul>\r\n<p class=\"MsoNormal\">Champs d\'application :</p>\r\n<ol>\r\n<li>Coussins</li>\r\n</ol>\r\n<p class=\"MsoNormal\">Dimensions 5cm x 200cm x 200cm</p>\r\n<p class=\"MsoNormal\">Excellent rapport qualit&eacute; prix.</p>', 81.45, 67.88, 1, 0, 1, NULL, 'plaques-6139f3efa8dcd.jpg', 100, 'mousse', 0, '2021-08-27 14:45:28', 'Polyéther'),
(15, 'T17100 10CM', 'Mousse', 17, 10, 200, 200, 0.4, '<p>&nbsp;</p>\r\n<p class=\"MsoNormal\">Caract&eacute;ristiques :</p>\r\n<ul>\r\n<li>Mousse poly&eacute;ther</li>\r\n<li>Confort souple&nbsp;(Kpa +/- 2.50)</li>\r\n<li>Densit&eacute; faible</li>\r\n</ul>\r\n<p class=\"MsoNormal\">Champs d\'application :</p>\r\n<ol>\r\n<li>Coussins</li>\r\n</ol>\r\n<p class=\"MsoNormal\">Dimensions 10cm x 200cm x 200cm</p>\r\n<p class=\"MsoNormal\">Excellent rapport qualit&eacute; prix.</p>', 162.91, 135.76, 1, 0, 1, NULL, 'plaques-6139f3f36692d.jpg', 100, 'mousse', 0, '2021-08-27 14:46:18', 'Polyéther'),
(16, 'T17100 8CM', 'Mousse', 17, 8, 200, 200, 0.32, '<p>&nbsp;</p>\r\n<p class=\"MsoNormal\">Caract&eacute;ristiques :</p>\r\n<ul>\r\n<li>Mousse poly&eacute;ther</li>\r\n<li>Confort souple&nbsp;(Kpa +/- 2.50)</li>\r\n<li>Densit&eacute; faible</li>\r\n</ul>\r\n<p class=\"MsoNormal\">Champs d\'application :</p>\r\n<ol>\r\n<li>Coussins</li>\r\n</ol>\r\n<p class=\"MsoNormal\">Dimensions 8cm x 200cm x 200cm</p>\r\n<p class=\"MsoNormal\">Excellent rapport qualit&eacute; prix.</p>', 130.33, 108.61, 1, 0, 1, NULL, 'plaques-6139f3f705f42.jpg', 100, 'mousse', 0, '2021-08-27 14:47:09', 'Polyéther'),
(17, 'R35130 15CM', 'Mousse', 35, 15, 175, 200, 0.525, '<p>&nbsp;</p>\r\n<div>Caract&eacute;ristiques :</div>\r\n<div>\r\n<ul>\r\n<li>Mousse haute r&eacute;silience</li>\r\n<li>Confort M&eacute;dium (Kpa +/- 3.25)</li>\r\n<li>Densit&eacute; Forte</li>\r\n<li>Le rebord des plaques poss&egrave;de une cro&ucirc;te, il sera n&eacute;cessaire de les red&eacute;couper par vos soins</li>\r\n</ul>\r\n</div>\r\n<p class=\"MsoNormal\">Champs d\'application :</p>\r\n<ol>\r\n<li>Matelas et sur matelas</li>\r\n<li>Assises (fauteuil, caravane, camping car ou Mobil Home)</li>\r\n<li>Manchette de fauteuil</li>\r\n</ol>\r\n<div>Dimensions : 15cm x 175cm x 200cm</div>', 313.57, 261.31, 1, 0, 1, NULL, 'plaques-6139f3fa74ba2.jpg', 100, 'mousse', 0, '2021-08-27 14:48:01', 'Haute résistance'),
(18, 'R35130 12CM', 'Mousse', 35, 12, 175, 200, 0.42, '<p>&nbsp;</p>\r\n<div>Caract&eacute;ristiques :</div>\r\n<div>\r\n<ul>\r\n<li>Mousse haute r&eacute;silience</li>\r\n<li>Confort M&eacute;dium (Kpa +/- 3.25)</li>\r\n<li>Densit&eacute; Forte</li>\r\n<li>Le rebord des plaques poss&egrave;de une cro&ucirc;te, il sera n&eacute;cessaire de les red&eacute;couper par vos soins</li>\r\n</ul>\r\n</div>\r\n<p class=\"MsoNormal\">Champs d\'application :</p>\r\n<ol>\r\n<li>Matelas et sur matelas</li>\r\n<li>Assises (fauteuil, caravane, camping car ou Mobil Home)</li>\r\n<li>Manchette de fauteuil</li>\r\n</ol>\r\n<div>Dimensions : 12cm x 175cm x 200cm</div>', 250.86, 209.05, 1, 0, 1, NULL, 'plaques-6139f3fdb6443.jpg', 100, 'mousse', 0, '2021-08-27 14:48:53', 'Haute résistance'),
(19, 'R35130 5CM', 'Mousse', 35, 5, 175, 200, 0.175, '<p>&nbsp;</p>\r\n<div>Caract&eacute;ristiques :</div>\r\n<div>\r\n<ul>\r\n<li>Mousse haute r&eacute;silience</li>\r\n<li>Confort M&eacute;dium (Kpa +/- 3.25)</li>\r\n<li>Densit&eacute; Forte</li>\r\n<li>Le rebord des plaques poss&egrave;de une cro&ucirc;te, il sera n&eacute;cessaire de les red&eacute;couper par vos soins</li>\r\n</ul>\r\n</div>\r\n<p class=\"MsoNormal\">Champs d\'application :</p>\r\n<ol>\r\n<li>Matelas et sur matelas</li>\r\n<li>Assises (fauteuil, caravane, camping car ou Mobil Home)</li>\r\n<li>Manchette de fauteuil</li>\r\n</ol>\r\n<div>Dimensions : 5cm x 175cm x 200cm</div>', 104.52, 87.1, 1, 0, 1, NULL, 'plaques-6139f4012e950.jpg', 100, 'mousse', 0, '2021-08-27 14:49:47', 'Haute résistance'),
(20, 'R35130 10CM', 'Mousse', 35, 10, 175, 200, 0.35, '<p>&nbsp;</p>\r\n<div>Caract&eacute;ristiques :</div>\r\n<div>\r\n<ul>\r\n<li>Mousse haute r&eacute;silience</li>\r\n<li>Confort M&eacute;dium (Kpa +/- 3.25)</li>\r\n<li>Densit&eacute; Forte</li>\r\n<li>Le rebord des plaques poss&egrave;de une cro&ucirc;te, il sera n&eacute;cessaire de les red&eacute;couper par vos soins</li>\r\n</ul>\r\n</div>\r\n<p class=\"MsoNormal\">Champs d\'application :</p>\r\n<ol>\r\n<li>Matelas et sur matelas</li>\r\n<li>Assises (fauteuil, caravane, camping car ou Mobil Home)</li>\r\n<li>Manchette de fauteuil</li>\r\n</ol>\r\n<div>Dimensions : 10cm x 175cm x 200cm</div>', 209.05, 174.21, 1, 0, 1, NULL, 'plaques-6139f4049e4f1.jpg', 100, 'mousse', 0, '2021-08-27 14:50:42', 'Haute résistance'),
(21, 'R35130 8CM', 'Mousse', 35, 8, 175, 200, 0.28, '<p>&nbsp;</p>\r\n<div>Caract&eacute;ristiques :</div>\r\n<div>\r\n<ul>\r\n<li>Mousse haute r&eacute;silience</li>\r\n<li>Confort M&eacute;dium (Kpa +/- 3.25)</li>\r\n<li>Densit&eacute; Forte</li>\r\n<li>Le rebord des plaques poss&egrave;de une cro&ucirc;te, il sera n&eacute;cessaire de les red&eacute;couper par vos soins</li>\r\n</ul>\r\n</div>\r\n<p class=\"MsoNormal\">Champs d\'application :</p>\r\n<ol>\r\n<li>Matelas et sur matelas</li>\r\n<li>Assises (fauteuil, caravane, camping car ou Mobil Home)</li>\r\n<li>Manchette de fauteuil</li>\r\n</ol>\r\n<div>Dimensions : 8cm x 175cm x 200cm</div>', 167.24, 139.37, 1, 0, 1, NULL, 'plaques-6139f40856c38.jpg', 100, 'mousse', 0, '2021-08-27 14:52:21', 'Haute résistance'),
(22, 'B40160 15CM', 'Mousse', 40, 15, 175, 200, 0.525, '<p>&nbsp;</p>\r\n<div>Caract&eacute;ristiques :</div>\r\n<div>\r\n<ul>\r\n<li>Mousse BULTEX</li>\r\n<li>Confort Ferme (Kpa +/- 4.00)</li>\r\n<li>Densit&eacute; Forte</li>\r\n<li>Le rebord des plaques poss&egrave;de une cro&ucirc;te, il sera n&eacute;cessaire de les red&eacute;couper par vos soins</li>\r\n</ul>\r\n</div>\r\n<p class=\"MsoNormal\">Champs d\'application :</p>\r\n<ol>\r\n<li>Matelas et sur matelas</li>\r\n<li>Assises (fauteuil, caravane, camping car ou Mobil Home)</li>\r\n</ol>\r\n<div>Dimensions : 15cm x 175cm x 200cm</div>', 401.29, 334.41, 1, 0, 1, NULL, 'plaques-6139f40bdc07d.jpg', 100, 'mousse', 0, '2021-08-27 14:53:24', 'Bultex'),
(23, 'B40160 12CM', 'Mousse', 40, 12, 175, 200, 0.42, '<p>&nbsp;</p>\r\n<div>Caract&eacute;ristiques :</div>\r\n<div>\r\n<ul>\r\n<li>Mousse BULTEX</li>\r\n<li>Confort Ferme (Kpa +/- 4.00)</li>\r\n<li>Densit&eacute; Forte</li>\r\n<li>Le rebord des plaques poss&egrave;de une cro&ucirc;te, il sera n&eacute;cessaire de les red&eacute;couper par vos soins</li>\r\n</ul>\r\n</div>\r\n<p class=\"MsoNormal\">Champs d\'application :</p>\r\n<ol>\r\n<li>Matelas et sur matelas</li>\r\n<li>Assises (fauteuil, caravane, camping car ou Mobil Home)</li>\r\n</ol>\r\n<div>Dimensions : 12cm x 175cm x 200cm</div>', 321.03, 267.53, 1, 0, 1, NULL, 'plaques-6139f40f54966.jpg', 100, 'mousse', 0, '2021-08-27 14:54:10', 'Bultex'),
(24, 'B40160 5CM', 'Mousse', 40, 5, 175, 200, 0.175, '<p>&nbsp;</p>\r\n<div>Caract&eacute;ristiques :</div>\r\n<div>\r\n<ul>\r\n<li>Mousse BULTEX</li>\r\n<li>Confort Ferme (Kpa +/- 4.00)</li>\r\n<li>Densit&eacute; Forte</li>\r\n<li>Le rebord des plaques poss&egrave;de une cro&ucirc;te, il sera n&eacute;cessaire de les red&eacute;couper par vos soins</li>\r\n</ul>\r\n</div>\r\n<p class=\"MsoNormal\">Champs d\'application :</p>\r\n<ol>\r\n<li>Matelas et sur matelas</li>\r\n<li>Assises (fauteuil, caravane, camping car ou Mobil Home)</li>\r\n</ol>\r\n<div>Dimensions : 5cm x 175cm x 200cm</div>', 133.76, 111.47, 1, 0, 1, NULL, 'plaques-6139f412dcd2c.jpg', 100, 'mousse', 0, '2021-08-27 14:55:00', 'Bultex'),
(25, 'B40160 10CM', 'Mousse', 40, 10, 175, 200, 0.35, '<p>&nbsp;</p>\r\n<div>Caract&eacute;ristiques :</div>\r\n<div>\r\n<ul>\r\n<li>Mousse BULTEX</li>\r\n<li>Confort Ferme (Kpa +/- 4.00)</li>\r\n<li>Densit&eacute; Forte</li>\r\n<li>Le rebord des plaques poss&egrave;de une cro&ucirc;te, il sera n&eacute;cessaire de les red&eacute;couper par vos soins</li>\r\n</ul>\r\n</div>\r\n<p class=\"MsoNormal\">Champs d\'application :</p>\r\n<ol>\r\n<li>Matelas et sur matelas</li>\r\n<li>Assises (fauteuil, caravane, camping car ou Mobil Home)</li>\r\n</ol>\r\n<div>Dimensions : 10cm x 175cm x 200cm</div>', 267.53, 222.94, 1, 0, 1, NULL, 'plaques-6139f41666c12.jpg', 100, 'mousse', 0, '2021-08-27 14:55:43', 'Bultex'),
(26, 'B40160 8CM', 'Mousse', 40, 8, 175, 200, 0.28, '<p>&nbsp;</p>\r\n<div>Caract&eacute;ristiques :</div>\r\n<div>\r\n<ul>\r\n<li>Mousse BULTEX</li>\r\n<li>Confort Ferme (Kpa +/- 4.00)</li>\r\n<li>Densit&eacute; Forte</li>\r\n<li>Le rebord des plaques poss&egrave;de une cro&ucirc;te, il sera n&eacute;cessaire de les red&eacute;couper par vos soins</li>\r\n</ul>\r\n</div>\r\n<p class=\"MsoNormal\">Champs d\'application :</p>\r\n<ol>\r\n<li>Matelas et sur matelas</li>\r\n<li>Assises (fauteuil, caravane, camping car ou Mobil Home)</li>\r\n</ol>\r\n<div>Dimensions : 8cm x 175cm x 200cm</div>', 214.02, 178.35, 1, 0, 1, NULL, 'plaques-6139f419d18f0.jpg', 100, 'mousse', 0, '2021-08-27 14:56:31', 'Bultex'),
(27, 'B37130 15CM', 'Mousse', 37, 15, 175, 200, 0.525, '<p>&nbsp;</p>\r\n<div>Caract&eacute;ristiques :</div>\r\n<div>\r\n<ul>\r\n<li>Mousse BULTEX</li>\r\n<li>Confort M&eacute;dium (Kpa +/- 3.25)</li>\r\n<li>Densit&eacute; Forte</li>\r\n<li>Le rebord des plaques poss&egrave;de une cro&ucirc;te, il sera n&eacute;cessaire de les red&eacute;couper par vos soins</li>\r\n</ul>\r\n</div>\r\n<p class=\"MsoNormal\">Champs d\'application :</p>\r\n<ol>\r\n<li>Matelas et sur matelas</li>\r\n<li>Assises (fauteuil, caravane, camping car ou Mobil Home)</li>\r\n<li>Manchette de fauteuil</li>\r\n</ol>\r\n<div>Dimensions : 15cm x 175cm x 200cm</div>', 384.22, 320.18, 1, 0, 1, NULL, 'plaques-6139f41d4048f.jpg', 100, 'mousse', 0, '2021-08-27 14:57:44', 'Bultex'),
(28, 'B37130 12CM', 'Mousse', 37, 12, 175, 200, 0.42, '<p>&nbsp;</p>\r\n<div>Caract&eacute;ristiques :</div>\r\n<div>\r\n<ul>\r\n<li>Mousse BULTEX</li>\r\n<li>Confort M&eacute;dium (Kpa +/- 3.25)</li>\r\n<li>Densit&eacute; Forte</li>\r\n<li>Le rebord des plaques poss&egrave;de une cro&ucirc;te, il sera n&eacute;cessaire de les red&eacute;couper par vos soins</li>\r\n</ul>\r\n</div>\r\n<p class=\"MsoNormal\">Champs d\'application :</p>\r\n<ol>\r\n<li>Matelas et sur matelas</li>\r\n<li>Assises (fauteuil, caravane, camping car ou Mobil Home)</li>\r\n<li>Manchette de fauteuil</li>\r\n</ol>\r\n<div>Dimensions : 12cm x 175cm x 200cm</div>', 307.38, 256.15, 1, 0, 1, NULL, 'plaques-6139f4209c796.jpg', 100, 'mousse', 0, '2021-08-27 14:58:34', 'Bultex'),
(29, 'B37130 5CM', 'Mousse', 37, 5, 175, 200, 0.175, '<p>&nbsp;</p>\r\n<div>Caract&eacute;ristiques :</div>\r\n<div>\r\n<ul>\r\n<li>Mousse BULTEX</li>\r\n<li>Confort M&eacute;dium (Kpa +/- 3.25)</li>\r\n<li>Densit&eacute; Forte</li>\r\n<li>Le rebord des plaques poss&egrave;de une cro&ucirc;te, il sera n&eacute;cessaire de les red&eacute;couper par vos soins</li>\r\n</ul>\r\n</div>\r\n<p class=\"MsoNormal\">Champs d\'application :</p>\r\n<ol>\r\n<li>Matelas et sur matelas</li>\r\n<li>Assises (fauteuil, caravane, camping car ou Mobil Home)</li>\r\n<li>Manchette de fauteuil</li>\r\n</ol>\r\n<div>Dimensions : 5cm x 175cm x 200cm</div>', 128.07, 106.73, 1, 0, 1, NULL, 'plaques-6139f424596c8.jpg', 100, 'mousse', 0, '2021-08-27 14:59:18', 'Bultex'),
(30, 'B37130 8CM', 'Mousse', 37, 8, 175, 200, 0.28, '<p>&nbsp;</p>\r\n<div>Caract&eacute;ristiques :</div>\r\n<div>\r\n<ul>\r\n<li>Mousse BULTEX</li>\r\n<li>Confort M&eacute;dium (Kpa +/- 3.25)</li>\r\n<li>Densit&eacute; Forte</li>\r\n<li>Le rebord des plaques poss&egrave;de une cro&ucirc;te, il sera n&eacute;cessaire de les red&eacute;couper par vos soins</li>\r\n</ul>\r\n</div>\r\n<p class=\"MsoNormal\">Champs d\'application :</p>\r\n<ol>\r\n<li>Matelas et sur matelas</li>\r\n<li>Assises (fauteuil, caravane, camping car ou Mobil Home)</li>\r\n<li>Manchette de fauteuil</li>\r\n</ol>\r\n<div>Dimensions : 8cm x 175cm x 200cm</div>', 204.92, 170.77, 1, 0, 1, NULL, 'plaques-6139f4280e4c4.jpg', 100, 'mousse', 0, '2021-08-27 15:00:09', 'Bultex');

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `volume` double NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `price_ttc` double NOT NULL,
  `price_ht` double NOT NULL,
  `delivery` int(11) NOT NULL,
  `best_seller` int(11) NOT NULL,
  `declination` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stock` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `draft` int(11) NOT NULL,
  `promo` int(11) NOT NULL,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `product`
--

INSERT INTO `product` (`id`, `title`, `volume`, `content`, `price_ttc`, `price_ht`, `delivery`, `best_seller`, `declination`, `thumbnail`, `stock`, `created_at`, `slug`, `draft`, `promo`, `reference`) VALUES
(6, 'Fauteuil enfant 1 place', 0.082, '<p>Fauteuil enfant 1 place</p>\r\n<div>Fauteuil en mousse polyur&eacute;thane de haute densit&eacute; entre 30et35kg/m3 &agrave; habiller soi-m&ecirc;me. Le gabarit pour la d&eacute;coupe du tissu est fourni.</div>\r\n<div>Dimensions :</div>\r\n<div>Hauteur Total : 57cm.</div>\r\n<div>Base : 38cm x 38cm.</div>\r\n<div>Assise : &agrave; 15cm de hauteur.</div>\r\n<div>Profondeur : 31cm.</div>', 15, 12.5, 1, 0, NULL, 'mousse-big-61b66a6e83d80.jpg', 16, '2021-08-27 14:03:22', 'fauteuil-enfant-1-place', 0, 1, 'Fauteuil enfant 1 place'),
(7, '10 Galettes de Chaise Rondes', 0.048, '<p>Lot de 10 galettes de chaise Rondes &agrave; habiller soi-m&ecirc;me<br />Dimension : 40 X 3 cm</p>', 12, 10, 1, 0, NULL, '22-04-10170-61b66a8b8de73.jpg', 998, '2021-08-27 14:05:56', '10-galettes-de-chaise-rondes', 0, 1, '10 Galettes de Chaise Rondes'),
(8, '10 Galettes de chaise carrées', 0.048, '<p>Lot de 10 Galettes de Chaise carr&eacute;es en mousse &agrave; habiller soi-m&ecirc;me.<br />Dimension : 40 x 40 x 3 cm.</p>', 12, 10, 1, 1, NULL, '22-04-10170-61b66bd02e943.jpg', 973, '2021-08-27 14:06:53', '10-galettes-de-chaise-carrees', 0, 1, '10 Galettes de chaise carrées'),
(9, 'Lot de 10 éponges', 0.003, '<p>Eponge Magique, nettoie tout dans la maison, sans d&eacute;tergeant. <br />Avec simplement un peu d\'eau et un l&eacute;ger frottement, vous viendrez &agrave; bout des taches les plus tenaces.<br />Caract&eacute;ristiques :<br />Couleur Grise<br />5 &eacute;ponges dimensions 15X8X4 cm<br />5 &eacute;ponges dimensions 11X7X3 cm<br /><br /><br /></p>', 10, 8.33, 1, 1, NULL, 'eponge3-61b66be6b7f8f.jpg', 0, '2021-08-27 14:08:20', 'lot-de-10-eponges', 0, 0, 'Lot de 10 éponges'),
(10, 'Fauteuil club enfant', 0.04, '<p>Fauteuil club enfant</p>\r\n<div>Fauteuil en mousse polyur&eacute;thane de haute densit&eacute; entre 30et35kg/m3 &agrave; habiller soi-m&ecirc;me. Le gabarit pour la d&eacute;coupe du tissu est fourni.</div>\r\n<div>Dimensions :</div>\r\n<div>Hauteur Total : 43cm.</div>\r\n<div>Base : 36cm x 42.5cm.</div>\r\n<div>Assise : &agrave; 13cm de hauteur.</div>\r\n<div>Profondeur : 26cm.</div>', 18, 15, 1, 1, NULL, 'mousse-big-61b66c00cdff8.jpg', 6, '2021-08-27 14:10:29', 'fauteuil-club-enfant', 0, 0, 'Fauteuil club enfant');

-- --------------------------------------------------------

--
-- Structure de la table `question`
--

CREATE TABLE `question` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `display` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `relay_point_db`
--

CREATE TABLE `relay_point_db` (
  `id` int(11) NOT NULL,
  `one` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `three` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `four` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `five` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `six` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seven` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `eight` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nine` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ten` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `eleven` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twelve` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thirteen` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fourteen` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fifteen` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sixteen` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seventeen` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `eighteen` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nineteen` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twenty` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twentyone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twentytwo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twentythree` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twentyfour` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twentyfive` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twentysix` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twentyseven` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twentyeight` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twentynine` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thirty` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thirtyone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thirtytwo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thirtythree` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thirtyfour` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thirtyfive` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thirtysix` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thirtyseven` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thirtyeight` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thirtynine` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `forty` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fortyone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fortytwo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fortythree` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fortyfour` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `relay_point_db`
--

INSERT INTO `relay_point_db` (`id`, `one`, `two`, `three`, `four`, `five`, `six`, `seven`, `eight`, `nine`, `ten`, `eleven`, `twelve`, `thirteen`, `fourteen`, `fifteen`, `sixteen`, `seventeen`, `eighteen`, `nineteen`, `twenty`, `twentyone`, `twentytwo`, `twentythree`, `twentyfour`, `twentyfive`, `twentysix`, `twentyseven`, `twentyeight`, `twentynine`, `thirty`, `thirtyone`, `thirtytwo`, `thirtythree`, `thirtyfour`, `thirtyfive`, `thirtysix`, `thirtyseven`, `thirtyeight`, `thirtynine`, `forty`, `fortyone`, `fortytwo`, `fortythree`, `fortyfour`) VALUES
(1, NULL, '12554878420221212', 'adminadmin', NULL, NULL, NULL, NULL, NULL, 'FR', '070000000', NULL, 'admin@mail.fr', NULL, NULL, NULL, NULL, NULL, 'FR', NULL, 'FR', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, NULL, '12554878420221212', 'adminadmin', NULL, NULL, NULL, NULL, NULL, 'FR', '070000000', NULL, 'admin@mail.fr', NULL, NULL, NULL, NULL, NULL, 'FR', NULL, 'FR', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `reseller_order`
--

CREATE TABLE `reseller_order` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `billing_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `billing_postal_code` int(11) NOT NULL,
  `billing_city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shipping_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_postal_code` int(11) DEFAULT NULL,
  `shipping_city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_method` int(11) DEFAULT NULL,
  `shipping_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `payment_method` int(11) DEFAULT NULL,
  `shipping_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `packages` int(11) DEFAULT NULL,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reseller_order_item`
--

CREATE TABLE `reseller_order_item` (
  `id` int(11) NOT NULL,
  `reseller_order_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `thickness` double NOT NULL,
  `width` double NOT NULL,
  `length` double NOT NULL,
  `diameter` double NOT NULL,
  `volume` double NOT NULL,
  `price` double NOT NULL,
  `cutted` int(11) NOT NULL,
  `shape` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reset_password_request`
--

CREATE TABLE `reset_password_request` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `selector` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hashed_token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requested_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `expires_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postal_code` int(11) NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` int(11) NOT NULL,
  `shipping_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_postal_code` int(11) DEFAULT NULL,
  `shipping_city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `first_name`, `last_name`, `email`, `password`, `address`, `postal_code`, `city`, `country`, `phone`, `role`, `shipping_address`, `shipping_postal_code`, `shipping_city`, `shipping_code`) VALUES
(1, 'Flavien', 'Aymonnier', 'hello@flavien-aymonnier.fr', '$2y$13$vY4ETKT.sRJlrqrbrX2yd.brgLNlVm38tzxKbxlCEEN8fv8BRdlDu', '5 rue Clément Marot, résidence de la Pléiade', 59160, 'Lomme', 'France', '0785953813', 99, 'COCCI MARKET 21 RUE DU GENERAL LECLERC', 59120, 'LOOS', NULL),
(9, 'Flavien', 'Aymonnier', 'flavien.aym@gmail.com', '$2y$13$3cB.EIZfbCt3nZi6L119luaYlHhNF0JHVcvD4P6gBIt979plnfalu', '5 rue Clément Marot', 59160, 'Lomme', 'France', '0785953813', 2, 'SUPER FRAIS RUE JEAN JAURES 35', 59155, 'FACHES-THUMESNIL', NULL),
(10, 'clement', 'Verhille', 'epid.verhille.c@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$bTTjYic5f7h1Xb691EL+Gw$MRpNSWDu4EbOP+BFt4ts0sR9Bm3iiNyTKgrNT3cZOHY', '5 RUE DU TONNELIER', 59470, 'WORMHOUT', 'France', '0789598817', 99, NULL, NULL, NULL, NULL),
(11, 'admin', 'admin', 'admin@mail.fr', '$argon2id$v=19$m=65536,t=4,p=1$i4qAGeQ9bDBr7uu8Wy9mBQ$hcGaqO4gIQ9crfQkgQI2/21ud2I4WXcqwXmm0bib+ps', 'route de neuville', 59470, 'ville des admins', 'France', '070000000', 99, 'AGENCE MONDIAL RELAY HEM 9 AVENUE ANTOINE PINAY', 59510, 'HEM', '066974'),
(12, 'user', 'user', 'user@mail.fr', '$argon2id$v=19$m=65536,t=4,p=1$F/jJRnyaULzNNRZ+TfuUtQ$UoVMMoQ6o4/knzI3t7KpYzAKinPk7YcnXhnRZ4eXXus', 'rue des users', 59000, 'ville des users', 'France', '070000000', 1, NULL, NULL, NULL, NULL),
(13, 'ddugujhiu', 'fatinn', 'renard.piere185gmail@com', '$argon2id$v=19$m=65536,t=4,p=1$G/4IFjd7hECgOoLUaDmibg$FNlOX7da/YoMU77R6+m42nLF+U1v7mQXLG5evmq7WGs', '56564', 59000, 'lille', 'france', '156050504555', 1, NULL, NULL, NULL, NULL),
(14, 'kljjkl', 'jkljkl', '1@1.fr', '$argon2id$v=19$m=65536,t=4,p=1$8P//dpNEKRjgrEFfRy2b4A$XZEJR74HofmBskEaP/XdtjGJX5kOnfkB6NAMbGMpJZg', 'lkjljk', 59, 'kljlkj', 'jkhjhk', 'jhkhjkj', 1, NULL, NULL, NULL, NULL),
(15, 'kljjkl\'', 'jkljkl\"', '11@fr', '$argon2id$v=19$m=65536,t=4,p=1$ctTuF6qeKTu+aVmh6Mibpg$rbeukRpcc4fN3YsGsvpmAPTCqi22sYQ5istOIvraNtQ', 'lkjljk', 59, 'kljlkj', 'jkhjhk', 'jhkhjkj', 1, NULL, NULL, NULL, NULL),
(16, 'Aurélien', 'VIGIER', 'topmousse.net@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$bfdQ0tbc1hHHw6msEL93vg$Me0r8r8c7nzfr6T8keFLLvXQTsOeZWfxwKwkPJ7/aKI', '12 avenue de menin', 59250, 'HALLUIN', 'France', '0320232374', 1, NULL, NULL, NULL, NULL),
(17, 'Aurélien', 'VIGIER', 'topmousse.net@gmai.com', '$argon2id$v=19$m=65536,t=4,p=1$+l06sitoALJJu4SgEmcqMw$PmSmfTGLrhdAb3Z3b7iPrVQsYmdOlgRE1NgWv8VFnwA', '12 avenue de menin', 59250, '59250', 'France', '0320232374', 1, NULL, NULL, NULL, NULL),
(18, 'jeremy', 'renard', 'production@topmousse.fr', '$argon2id$v=19$m=65536,t=4,p=1$/xsOjLuhjAEl6IF0yleygg$LvRlcA/xfpW53QzLI48bEAKjOrnqdfCH8n9QY3KlGVU', '27 rue anatole france', 59185, 'Provin', 'France', '0603301906', 1, NULL, NULL, NULL, NULL),
(19, 'axel', 'vallier', 'axelvallier.dev@gmail.com', '$2y$13$zSf5ZZfIiY0qXFW738G1eOofIzj8ehFYhZ7GJ/zqzm7.f2DqVjcea', '75 rue des all blacks', 34070, 'Montpellier', 'FRANCE', '0659631174', 1, NULL, NULL, NULL, NULL),
(20, 'asas', 'iuiui', 'test@mail.fr', '$2y$13$vZfG3J5xBqID7/8GgO3QM.1A/gX/W60WkiQHFoCob2.UCZbeHv21O', 'iuiiu', 75252, 'iuiu', 'fr', '0659631174', 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `wrap`
--

CREATE TABLE `wrap` (
  `id` int(11) NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `package_numbers` int(11) DEFAULT NULL,
  `weight` double DEFAULT NULL,
  `package_max_numbers` int(11) DEFAULT NULL,
  `length_max` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `wrap_item`
--

CREATE TABLE `wrap_item` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `answer`
--
ALTER TABLE `answer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_DADD4A25D249A887` (`feedback_id`);

--
-- Index pour la table `cart_item`
--
ALTER TABLE `cart_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_F0FE25274584665A` (`product_id`),
  ADD KEY `IDX_F0FE2527DF66E98B` (`plate_id`),
  ADD KEY `IDX_F0FE2527A76ED395` (`user_id`);

--
-- Index pour la table `configuration`
--
ALTER TABLE `configuration`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `cutting`
--
ALTER TABLE `cutting`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_FB7C26CDA76ED395` (`user_id`);

--
-- Index pour la table `cutting_item`
--
ALTER TABLE `cutting_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_7C4120CF4584665A` (`product_id`),
  ADD KEY `IDX_7C4120CFDF66E98B` (`plate_id`),
  ADD KEY `IDX_7C4120CF8D9F6D38` (`order_id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D2294458A76ED395` (`user_id`);

--
-- Index pour la table `foam`
--
ALTER TABLE `foam`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `invoice_article`
--
ALTER TABLE `invoice_article`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_F0E338B52989F1FD` (`invoice_id`);

--
-- Index pour la table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_8F3F68C5A76ED395` (`user_id`);

--
-- Index pour la table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_F5299398A76ED395` (`user_id`);

--
-- Index pour la table `order_item`
--
ALTER TABLE `order_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_52EA1F094584665A` (`product_id`),
  ADD KEY `IDX_52EA1F09DF66E98B` (`plate_id`),
  ADD KEY `IDX_52EA1F098D9F6D38` (`order_id`);

--
-- Index pour la table `page`
--
ALTER TABLE `page`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `plate`
--
ALTER TABLE `plate`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `relay_point_db`
--
ALTER TABLE `relay_point_db`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `reseller_order`
--
ALTER TABLE `reseller_order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_E7922928A76ED395` (`user_id`);

--
-- Index pour la table `reseller_order_item`
--
ALTER TABLE `reseller_order_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_811DD8C1A58BF0C` (`reseller_order_id`);

--
-- Index pour la table `reset_password_request`
--
ALTER TABLE `reset_password_request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_7CE748AA76ED395` (`user_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `wrap`
--
ALTER TABLE `wrap`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `wrap_item`
--
ALTER TABLE `wrap_item`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `answer`
--
ALTER TABLE `answer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `cart_item`
--
ALTER TABLE `cart_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `configuration`
--
ALTER TABLE `configuration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `cutting`
--
ALTER TABLE `cutting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `cutting_item`
--
ALTER TABLE `cutting_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `foam`
--
ALTER TABLE `foam`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT pour la table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `invoice_article`
--
ALTER TABLE `invoice_article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `log`
--
ALTER TABLE `log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `order_item`
--
ALTER TABLE `order_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `page`
--
ALTER TABLE `page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `plate`
--
ALTER TABLE `plate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT pour la table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `question`
--
ALTER TABLE `question`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `relay_point_db`
--
ALTER TABLE `relay_point_db`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `reseller_order`
--
ALTER TABLE `reseller_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `reseller_order_item`
--
ALTER TABLE `reseller_order_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `reset_password_request`
--
ALTER TABLE `reset_password_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `wrap`
--
ALTER TABLE `wrap`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `wrap_item`
--
ALTER TABLE `wrap_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `answer`
--
ALTER TABLE `answer`
  ADD CONSTRAINT `FK_DADD4A25D249A887` FOREIGN KEY (`feedback_id`) REFERENCES `feedback` (`id`);

--
-- Contraintes pour la table `cart_item`
--
ALTER TABLE `cart_item`
  ADD CONSTRAINT `FK_F0FE25274584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `FK_F0FE2527A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_F0FE2527DF66E98B` FOREIGN KEY (`plate_id`) REFERENCES `plate` (`id`);

--
-- Contraintes pour la table `cutting`
--
ALTER TABLE `cutting`
  ADD CONSTRAINT `FK_FB7C26CDA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `cutting_item`
--
ALTER TABLE `cutting_item`
  ADD CONSTRAINT `FK_7C4120CF4584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `FK_7C4120CF8D9F6D38` FOREIGN KEY (`order_id`) REFERENCES `cutting` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_7C4120CFDF66E98B` FOREIGN KEY (`plate_id`) REFERENCES `plate` (`id`);

--
-- Contraintes pour la table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `FK_D2294458A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `invoice_article`
--
ALTER TABLE `invoice_article`
  ADD CONSTRAINT `FK_F0E338B52989F1FD` FOREIGN KEY (`invoice_id`) REFERENCES `invoice` (`id`);

--
-- Contraintes pour la table `log`
--
ALTER TABLE `log`
  ADD CONSTRAINT `FK_8F3F68C5A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `FK_F5299398A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `order_item`
--
ALTER TABLE `order_item`
  ADD CONSTRAINT `FK_52EA1F094584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `FK_52EA1F098D9F6D38` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`),
  ADD CONSTRAINT `FK_52EA1F09DF66E98B` FOREIGN KEY (`plate_id`) REFERENCES `plate` (`id`);

--
-- Contraintes pour la table `reseller_order`
--
ALTER TABLE `reseller_order`
  ADD CONSTRAINT `FK_E7922928A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `reseller_order_item`
--
ALTER TABLE `reseller_order_item`
  ADD CONSTRAINT `FK_811DD8C1A58BF0C` FOREIGN KEY (`reseller_order_id`) REFERENCES `reseller_order` (`id`);

--
-- Contraintes pour la table `reset_password_request`
--
ALTER TABLE `reset_password_request`
  ADD CONSTRAINT `FK_7CE748AA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;