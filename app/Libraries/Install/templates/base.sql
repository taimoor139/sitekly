SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
DROP TABLE IF EXISTS `Emails`, `Packages`, `Payments`, `Settings`, `Sites`, `Templates`, `Tokens`, `Users`;
CREATE TABLE `Emails` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `site` int(11) NOT NULL,
  `name` varchar(256) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `Packages` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `space` int(11) NOT NULL,
  `ads` tinyint(1) NOT NULL,
  `domain` tinyint(1) NOT NULL,
  `subdomain` int(11) NOT NULL DEFAULT 1,
  `emails` int(3) NOT NULL,
  `site_limit` int(1) NOT NULL,
  `price` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `Packages` (`id`, `name`, `space`, `ads`, `domain`, `subdomain`, `emails`, `site_limit`, `price`) VALUES
(1, 'Trial', 20, 0, 0, 1, 0, 2, '0'),
(2, 'Free', 10, 1, 0, 1, 0, 2, '0'),
(3, 'Start', 50, 0, 1, 1, 2, -1, '19'),
(4, 'Medium', 100, 0, 1, 1, 5, -1, '29'),
(5, 'Large', 200, 0, 1, 1, 10, -1, '39');


CREATE TABLE `Payments` (
  `id` int(11) NOT NULL,
  `site` int(6) NOT NULL,
  `amount` varchar(6) NOT NULL,
  `currency` varchar(5) NOT NULL,
  `control` varchar(32) NOT NULL,
  `package` int(2) NOT NULL,
  `time` int(3) NOT NULL,
  `method` varchar(11) NOT NULL,
  `transaction` varchar(30) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `Settings` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `Settings` (`id`, `name`, `value`) VALUES
(1, 'version', '1.01'),
(2, 'exports_lang', '{\"sectionCategories\":{\"About\":[\"Informacje\"],\"Brands\":[\"Marki\"],\"Call to action\":[\"Wezwanie do dzia\\u0142ania\"],\"Contact\":[\"Kontakt\"],\"Faq\":[\"Faq\"],\"Footer\":[\"Stopka\"],\"Header\":[\"Nag\\u0142\\u00f3wek\"],\"Hero\":[\"Hero\"],\"Pricing\":[\"Cennik\"],\"Products\":[\"Produkty\"],\"Services\":[\"Us\\u0142ugi\"],\"Stats\":[\"Statystyki\"],\"Team\":[\"Zesp\\u00f3\\u0142\"],\"Testimonials\":[\"Opinie\"]},\"pageCategories\":{\"Contact\":[\"Kontakt\"],\"Home\":[\"Start\"],\"Menu\":[\"Menu\"],\"Services\":[\"Us\\u0142ugi\"]},\"themes\":{\"Blank project\":[\"Pusty projekt\"],\"Gym\":[\"Si\\u0142ownia\"],\"Restaurant\":[\"Restauracja\"],\"Architecture\":[\"Architektura\"],\"Marketing\":[\"Marketing\"],\"Design\":[\"Projektowanie\"],\"Grad school\":[\"Edukacja\"],\"Restaurant 2\":[\"Restauracja 2\"],\"Technology\":[\"Technologia\"],\"Finance\":[\"Finanse\"],\"Events\":[\"Wydarzenia\"]}}');

CREATE TABLE `Sites` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `directory` varchar(256) NOT NULL,
  `domain` varchar(256) NOT NULL,
  `name` varchar(100) NOT NULL,
  `theme` int(11) NOT NULL,
  `package` int(2) NOT NULL,
  `media` varchar(20) NOT NULL,
  `panel_reseller` varchar(20) NOT NULL,
  `panel_login` varchar(20) NOT NULL,
  `panel_password` varchar(200) NOT NULL,
  `status` int(1) NOT NULL,
  `created_at` int(11) NOT NULL,
  `expire` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `Templates` (
  `id` int(11) NOT NULL,
  `uid` varchar(16) NOT NULL,
  `created_at` int(11) NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT 1,
  `status` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `Templates` (`id`, `uid`, `created_at`, `type`, `status`) VALUES
(1, 'f930533257d79378', 1604957316, 1, 1),
(2, '0c9847dff4dc71c1', 1604957316, 1, 1),
(3, '44fa088f287f22cb', 1604957316, 1, 1),
(4, 'b49b48d0c06b7670', 1604957316, 1, 1),
(5, '18942f97162b5663', 1604957316, 1, 1),
(6, '353d343ebf51debf', 1604957316, 1, 1),
(7, '95a9253c380052c9', 1610571021, 1, 1),
(8, '791359dd9727e252', 1610571134, 1, 1),
(9, 'e4c8b5a716eb0b1a', 1610571218, 1, 1),
(10, 'aa5d59d6c0950380', 1610571283, 1, 1),
(11, '3cc53c3b2776bcff', 1610571418, 2, 1),
(12, '13885cb7388e83d7', 1610572276, 1, 1),
(13, '47968ec528586933', 1628890794, 1, 1);

CREATE TABLE `Tokens` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `action` varchar(20) NOT NULL,
  `token` varchar(16) NOT NULL,
  `expire` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `Users` (
  `id` int(11) NOT NULL,
  `username` varchar(200) NOT NULL,
  `firstname` varchar(60) NOT NULL,
  `lastname` varchar(60) NOT NULL,
  `password` varchar(60) NOT NULL,
  `email` varchar(255) NOT NULL,
  `status` varchar(15) NOT NULL,
  `created_at` int(11) NOT NULL,
  `last_visit` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `Users` (`id`, `username`, `firstname`, `lastname`, `password`, `email`, `status`, `created_at`, `last_visit`) VALUES
(1, 'admin', '', '', '$2y$10$LPxtzgL0fCsZhp1uZjscIuCevZrIiSp9MhuCU0h.N8lYaA/sOymSS', '', 'admin', 0, 0);

--
ALTER TABLE `Emails`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `Packages`
  ADD UNIQUE KEY `PackageId` (`id`);


ALTER TABLE `Payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `Control` (`control`);

ALTER TABLE `Settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name_2` (`name`),
  ADD KEY `name` (`name`);

ALTER TABLE `Sites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Directory` (`directory`),
  ADD KEY `user` (`user`);

ALTER TABLE `Templates`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `uid` (`uid`);


ALTER TABLE `Tokens`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `Users`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `Emails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `Packages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;


ALTER TABLE `Payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `Settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;


ALTER TABLE `Sites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `Templates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

ALTER TABLE `Tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `Users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;