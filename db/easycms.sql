-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : jeu. 14 déc. 2023 à 13:12
-- Version du serveur : 5.7.36
-- Version de PHP : 8.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `easycms`
--

-- --------------------------------------------------------

--
-- Structure de la table `contents`
--

CREATE TABLE `contents` (
  `id` int(11) NOT NULL,
  `content_name` varchar(255) NOT NULL,
  `content_description` varchar(255) NOT NULL,
  `creation_date` datetime NOT NULL,
  `modification_date` datetime NOT NULL,
  `is_published` tinyint(1) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_content_type` int(11) NOT NULL,
  `id_position` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `contents`
--

INSERT INTO `contents` (`id`, `content_name`, `content_description`, `creation_date`, `modification_date`, `is_published`, `id_user`, `id_content_type`, `id_position`) VALUES
(1, 'Titre page d\'accueil', 'Accueil', '2023-12-14 14:00:09', '2023-12-14 14:00:09', 1, 1, 1, 2),
(2, 'Article page d\'accueil', 'Lorem Ipsum', '2023-12-14 13:00:17', '2023-12-14 13:00:17', 1, 1, 2, 3),
(3, 'Titre Annexe', 'Annexe', '2023-12-14 14:02:05', '2023-12-14 14:02:05', 1, 1, 1, 7),
(4, 'Article annexe', 'Lorem Ipsum Ipsum', '2023-12-14 14:08:52', '2023-12-14 14:08:52', 0, 1, 2, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `content_types`
--

CREATE TABLE `content_types` (
  `id` int(11) NOT NULL,
  `content_type_name` varchar(255) NOT NULL,
  `content_type_description` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `content_types`
--

INSERT INTO `content_types` (`id`, `content_type_name`, `content_type_description`) VALUES
(1, 'titre', '<title></title>'),
(2, 'article', '<article></article>'),
(3, 'image', '<img src=\"\" alt=\"\"/>'),
(4, 'lien', '<a href=\"\"></a> ');

-- --------------------------------------------------------

--
-- Structure de la table `navigations`
--

CREATE TABLE `navigations` (
  `id` int(11) NOT NULL,
  `nav_name` varchar(255) NOT NULL,
  `creation_date` datetime NOT NULL,
  `modification_date` datetime NOT NULL,
  `is_published` tinyint(1) NOT NULL,
  `id_page` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_position` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `navigations`
--

INSERT INTO `navigations` (`id`, `nav_name`, `creation_date`, `modification_date`, `is_published`, `id_page`, `id_user`, `id_position`) VALUES
(1, 'Accueil', '2023-12-14 14:10:41', '2023-12-14 14:10:41', 1, 1, 1, NULL),
(2, 'Annexe', '2023-12-14 14:10:41', '2023-12-14 14:10:41', 1, 2, 1, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `page_name` varchar(255) NOT NULL,
  `is_home_page` tinyint(1) NOT NULL,
  `creation_date` datetime NOT NULL,
  `modification_date` datetime NOT NULL,
  `is_published` tinyint(1) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `pages`
--

INSERT INTO `pages` (`id`, `page_name`, `is_home_page`, `creation_date`, `modification_date`, `is_published`, `id_user`) VALUES
(1, 'Accueil', 1, '2023-12-14 14:05:19', '2023-12-14 14:05:19', 1, 1),
(2, 'Annexe', 0, '2023-12-14 14:05:19', '2023-12-14 14:05:19', 1, 1),
(3, 'Annexe 2', 0, '2023-12-14 14:09:22', '2023-12-14 14:09:22', 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `positions`
--

CREATE TABLE `positions` (
  `id` int(11) NOT NULL,
  `position_number` int(11) NOT NULL,
  `id_page` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `positions`
--

INSERT INTO `positions` (`id`, `position_number`, `id_page`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 4, 1),
(5, 5, 1),
(6, 1, 2),
(7, 2, 2),
(8, 3, 2),
(9, 4, 2),
(10, 5, 2);

-- --------------------------------------------------------

--
-- Structure de la table `rights`
--

CREATE TABLE `rights` (
  `id` int(11) NOT NULL,
  `right_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `rights`
--

INSERT INTO `rights` (`id`, `right_name`) VALUES
(1, 'admin'),
(2, 'editor');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `id_right` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `id_right`) VALUES
(1, 'test', 'test', 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `contents`
--
ALTER TABLE `contents`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_id_position` (`id_position`),
  ADD KEY `idx_content_id_user` (`id_user`),
  ADD KEY `idx_content_id_content_type` (`id_content_type`);

--
-- Index pour la table `content_types`
--
ALTER TABLE `content_types`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `navigations`
--
ALTER TABLE `navigations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_nav_id_page` (`id_page`),
  ADD KEY `idx_nav_id_user` (`id_user`),
  ADD KEY `idx_nav_id_position` (`id_position`);

--
-- Index pour la table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_page_id_user` (`id_user`);

--
-- Index pour la table `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_position_id_page` (`id_page`);

--
-- Index pour la table `rights`
--
ALTER TABLE `rights`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id_right` (`id_right`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `contents`
--
ALTER TABLE `contents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `content_types`
--
ALTER TABLE `content_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `navigations`
--
ALTER TABLE `navigations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `positions`
--
ALTER TABLE `positions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `rights`
--
ALTER TABLE `rights`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `contents`
--
ALTER TABLE `contents`
  ADD CONSTRAINT `idx_content_id_content_type` FOREIGN KEY (`id_content_type`) REFERENCES `content_types` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `idx_content_id_position` FOREIGN KEY (`id_position`) REFERENCES `positions` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `idx_content_id_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `navigations`
--
ALTER TABLE `navigations`
  ADD CONSTRAINT `idx_nav_id_page` FOREIGN KEY (`id_page`) REFERENCES `pages` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `idx_nav_id_position` FOREIGN KEY (`id_position`) REFERENCES `positions` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `idx_nav_id_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `pages`
--
ALTER TABLE `pages`
  ADD CONSTRAINT `idx_page_id_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `positions`
--
ALTER TABLE `positions`
  ADD CONSTRAINT `idx_position_id_page` FOREIGN KEY (`id_page`) REFERENCES `pages` (`id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `idx_user_id_right` FOREIGN KEY (`id_right`) REFERENCES `rights` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
