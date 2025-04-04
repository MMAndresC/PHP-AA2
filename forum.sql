-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-04-2025 a las 19:56:36
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `forum`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sub_thread`
--

CREATE TABLE `sub_thread` (
  `id` int(11) NOT NULL,
  `thread_id` int(11) NOT NULL,
  `author` varchar(50) DEFAULT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `main` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `sub_thread`
--

INSERT INTO `sub_thread` (`id`, `thread_id`, `author`, `content`, `created_at`, `updated_at`, `main`) VALUES
(1, 1, 'admin@example.com', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2025-04-04 17:55:54', '2025-04-04 17:55:54', 1),
(2, 1, 'gg@example.com', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2025-04-04 17:55:54', '2025-04-04 17:55:54', 0),
(3, 2, 'super_pro99@example.com', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2025-04-04 17:55:54', '2025-04-04 17:55:54', 1),
(4, 3, 'gg@example.com', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2025-04-04 17:55:54', '2025-04-04 17:55:54', 1),
(5, 4, 'gg@example.com', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2025-04-04 17:55:54', '2025-04-04 17:55:54', 1),
(6, 5, 'gg@example.com', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2025-04-04 17:55:54', '2025-04-04 17:55:54', 1),
(7, 6, 'gg@example.com', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2025-04-04 17:55:54', '2025-04-04 17:55:54', 1),
(8, 7, 'super_pro99@example.com', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2025-04-04 17:55:54', '2025-04-04 17:55:54', 1),
(9, 8, 'super_pro99@example.com', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2025-04-04 17:55:54', '2025-04-04 17:55:54', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `theme`
--

CREATE TABLE `theme` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `description` varchar(200) DEFAULT NULL,
  `banner` varchar(100) DEFAULT 'banner_default.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `theme`
--

INSERT INTO `theme` (`id`, `name`, `created_at`, `description`, `banner`) VALUES
(1, 'Cocina española', '2025-04-04 17:55:54', 'Comparte todas tus recetas, consejos y dudas', 'banner_spanish.png'),
(2, 'Cocina mediterranea', '2025-04-04 17:55:54', 'Cocina tradicional mediterranea', 'banner_mediterranean.png'),
(3, 'Cocina criolla', '2025-04-04 17:55:54', 'La gastronomía o cocina criolla es un estilo de cocina nacido en la época colonial, de la fusión entre las culturas europea, africana y América precolombina', 'banner_criolla.png'),
(4, 'Cocina japonesa', '2025-04-04 17:55:54', 'Comparte todas tus recetas, consejos y dudas', 'banner_japanese.png'),
(5, 'Cocina coreana', '2025-04-04 17:55:54', 'Comparte todas tus recetas, consejos y dudas', 'banner_korean.png'),
(6, 'Cocina europea', '2025-04-04 17:55:54', 'Comparte todas tus recetas, consejos y dudas', 'banner_european.png'),
(7, 'Cocina china', '2025-04-04 17:55:54', 'Comparte todas tus recetas, consejos y dudas', 'banner_chinese.png'),
(8, 'Cocina mejicana', '2025-04-04 17:55:54', 'Comparte todas tus recetas, consejos y dudas', 'banner_mexican.png'),
(9, 'Cocina paises suramericana', '2025-04-04 17:55:54', 'Comparte todas tus recetas, consejos y dudas', 'banner_default.png'),
(10, 'Cocina paises asiaticos', '2025-04-04 17:55:54', 'Comparte todas tus recetas, consejos y dudas', 'banner_default.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `thread`
--

CREATE TABLE `thread` (
  `id` int(11) NOT NULL,
  `theme_id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `status` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` varchar(50) DEFAULT NULL,
  `last_updater` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `thread`
--

INSERT INTO `thread` (`id`, `theme_id`, `title`, `status`, `created_at`, `updated_at`, `created_by`, `last_updater`) VALUES
(1, 1, 'Cual es la mejor tortilla de patata', 'active', '2025-04-04 17:55:54', '2025-04-04 17:55:54', 'admin@example.com', 'gg@example.com'),
(2, 1, 'Mi receta de cocido', 'active', '2025-04-04 17:55:54', '2025-04-04 17:55:54', 'super_pro99@example.com', 'super_pro99@example.com'),
(3, 1, 'Los mejores macarrones', 'active', '2025-04-04 17:55:54', '2025-04-04 17:55:54', 'gg@example.com', 'gg@example.com'),
(4, 1, 'Receta de flan', 'active', '2025-04-04 17:55:54', '2025-04-04 17:55:54', 'super_pro99@example.com', 'super_pro99@example.com'),
(5, 1, 'Arroz con leche. Mejores trucos', 'active', '2025-04-04 17:55:54', '2025-04-04 17:55:54', 'gg@example.com', 'gg@example.com'),
(6, 1, 'Echarle guisantes a la paella', 'active', '2025-04-04 17:55:54', '2025-04-04 17:55:54', 'super_pro99@example.com', 'super_pro99@example.com'),
(7, 4, 'La mejor manera de cocinar sushi', 'active', '2025-04-04 17:55:54', '2025-04-04 17:55:54', 'super_pro99@example.com', 'super_pro99@example.com'),
(8, 3, 'La mejor receta criolla', 'active', '2025-04-04 17:55:54', '2025-04-04 17:55:54', 'super_pro99@example.com', 'super_pro99@example.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `username` varchar(20) NOT NULL,
  `name` varchar(30) NOT NULL,
  `surname` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(70) NOT NULL,
  `role` varchar(10) NOT NULL,
  `image_name` varchar(100) DEFAULT NULL,
  `verified` tinyint(1) DEFAULT 0,
  `verification_token` char(64) DEFAULT NULL,
  `verification_expires` datetime DEFAULT NULL,
  `reset_token` char(100) DEFAULT NULL,
  `reset_token_expires` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`username`, `name`, `surname`, `email`, `password`, `role`, `image_name`, `verified`, `verification_token`, `verification_expires`, `reset_token`, `reset_token_expires`) VALUES
('controller', 'johnny', 'doe', 'admin@example.com', '$2y$10$LorRJoglol750PCv7fEyhuD68Gde/OE5zIzx7uDcUT8dV05nG9jPm', 'admin', NULL, 1, NULL, NULL, NULL, NULL),
('anonimo97', 'Anna', 'Doe', 'gg@example.com', '$2y$10$LorRJoglol750PCv7fEyhuD68Gde/OE5zIzx7uDcUT8dV05nG9jPm', 'user', NULL, 1, NULL, NULL, NULL, NULL),
('Super Pro', 'Jane', 'Doe', 'super_pro99@example.com', '$2y$10$LorRJoglol750PCv7fEyhuD68Gde/OE5zIzx7uDcUT8dV05nG9jPm', 'moderator', NULL, 1, NULL, NULL, NULL, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `sub_thread`
--
ALTER TABLE `sub_thread`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author` (`author`),
  ADD KEY `thread_id` (`thread_id`);

--
-- Indices de la tabla `theme`
--
ALTER TABLE `theme`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `thread`
--
ALTER TABLE `thread`
  ADD PRIMARY KEY (`id`),
  ADD KEY `theme_id` (`theme_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `last_updater` (`last_updater`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `sub_thread`
--
ALTER TABLE `sub_thread`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `theme`
--
ALTER TABLE `theme`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `thread`
--
ALTER TABLE `thread`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `sub_thread`
--
ALTER TABLE `sub_thread`
  ADD CONSTRAINT `sub_thread_ibfk_1` FOREIGN KEY (`author`) REFERENCES `user` (`email`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `sub_thread_ibfk_2` FOREIGN KEY (`thread_id`) REFERENCES `thread` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `thread`
--
ALTER TABLE `thread`
  ADD CONSTRAINT `thread_ibfk_1` FOREIGN KEY (`theme_id`) REFERENCES `theme` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `thread_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `user` (`email`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `thread_ibfk_3` FOREIGN KEY (`last_updater`) REFERENCES `user` (`email`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
