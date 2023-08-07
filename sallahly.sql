-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 01 août 2023 à 22:51
-- Version du serveur : 10.4.27-MariaDB
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `sallahly`
--

-- --------------------------------------------------------

--
-- Structure de la table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `product_price` int(50) NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `qty` int(50) NOT NULL,
  `total_price` int(100) NOT NULL,
  `product_code` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `parent_id` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `parent_id`, `name`, `image`) VALUES
(86, 'informatique', 'imprimante', 'imprimantes.png'),
(88, 'informatique', 'téléphone', 'téléph.jfif'),
(89, 'informatique', 'machine d\'extration', 'téléchargement.jpg'),
(90, '', 'medicaux', 'médicales.png'),
(91, 'medicaux', 'tensiomètre', 'Tensiomètre.jpg'),
(92, 'medicaux', 'ECG', 'ECG.jpg'),
(93, 'medicaux', 'Scanner  ou Radiographie', 'Scanner ou radiographie.jpg'),
(94, 'medicaux', 'Echographie ', 'Échographe cardiaque d’argent.jpg'),
(95, '', 'Electronique', 'éléctronique.png'),
(96, 'Electronique', 'réfrigérateur', 'rfrigrateurs-1.jpg'),
(97, 'Electronique', 'Micro-onde', 'micro ond 2.jpg'),
(98, 'Electronique', 'Cuisinière', 'Cuisinière.jpg'),
(99, 'Electronique', 'machine à laver', 'lave.png');

-- --------------------------------------------------------

--
-- Structure de la table `messageries`
--

CREATE TABLE `messageries` (
  `id` int(11) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `products` varchar(255) NOT NULL,
  `amount_paid` varchar(100) NOT NULL,
  `uaddress` varchar(255) NOT NULL,
  `pmode` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `product_brand` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `quantity` int(50) NOT NULL,
  `offer` int(50) NOT NULL,
  `product_category` varchar(200) NOT NULL,
  `product_price` int(50) NOT NULL,
  `product_image` varchar(100) NOT NULL,
  `product_code` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reparations`
--

CREATE TABLE `reparations` (
  `id` int(11) NOT NULL,
  `brand` varchar(50) NOT NULL,
  `model` varchar(50) NOT NULL,
  `type_repear` varchar(50) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `description` varchar(255) NOT NULL,
  `methode_payment` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `reparations`
--

INSERT INTO `reparations` (`id`, `brand`, `model`, `type_repear`, `firstname`, `lastname`, `email`, `phone`, `description`, `methode_payment`) VALUES
(6, 'téléphone', 'Batterie', 'A domicile', 'imen', 'belkahla', 'imenbn15@gmail.com', '0781084756', 'il ya un problème de batterie de mon téléphone \"samsung M12\"', 'cash');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(100) NOT NULL,
  `address` varchar(200) NOT NULL,
  `willaya` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `mobile`, `address`, `willaya`, `password`, `image`, `role`) VALUES
(57, 'imen', 'blk', 'imenibn8@gmail.com', '00781084753', '', '', 'd41d8cd98f00b204e9800998ecf8427e', 'pogo.png', 'admin'),
(58, 'yassmin', 'taan', 'imenblk420@gmail.com', '0676540239', '', '', '8cc92957056f8a2312b079ba066b3042', 'pogo.png', 'user'),
(59, 'fatiha', 'hamraras', 'fati12@gmail.com', '0676540239', '', '', '92e3364c1dd5949ba547e7e784e0284c', 'pogo.png', 'user'),
(61, 'imen2', 'belk', 'imen14@gmail.com', '0676540239', 'Hai dardara', 'Ain defla', 'f385e77dffdacd3a86ee310465f92ddb', 'pogo.png', 'admin'),
(63, 'imen', 'bbn17', 'imenbb17@gmail.com', '0676540239', '', '', '1c9f6fc415b7a01034908b357d952dc0', 'pogo.png', 'user'),
(64, 'wiwi', 'bnk', 'wiwibnk17@gmail.com', '0781084739', '', '', '0c165d8401318d1ab417d35869ef88b4', 'pogo.png', 'admin'),
(65, 'imen', 'kk', 'imenkk220@gmail.com', '00781084756', 'Hai dardara', '', 'd41d8cd98f00b204e9800998ecf8427e', 'pogo.png', 'admin'),
(66, 'imen', 'bn12', 'imenbn15@gmail.com', '0770445221', '', '', '5163aa6e9fe38ccc1d0f4410ea9abd49', '', 'user'),
(67, 'imen', 'bnk', 'imen147@gmail.com', '0770445221', '', '', 'dcf93776be60b2385047aad2c8f8ceab', '', 'admin'),
(68, 'imenblk', '2020', 'imenblk2020@gmail.com', '0720141530', '', '', '8cc92957056f8a2312b079ba066b3042', '', 'admin'),
(69, 'imen', 'bb12', 'imenbb13@gmail.com', '0720121514', '', '', '0c42b0de7da8ec7ad083ade985b203df', '', 'user');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `messageries`
--
ALTER TABLE `messageries`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `reparations`
--
ALTER TABLE `reparations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT pour la table `messageries`
--
ALTER TABLE `messageries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT pour la table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `reparations`
--
ALTER TABLE `reparations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
