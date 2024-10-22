-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-10-2024 a las 10:34:53
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
-- Base de datos: `portfolio`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `artwork`
--

CREATE TABLE `artwork` (
  `id` int(11) NOT NULL,
  `work_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `creation_date` date DEFAULT NULL,
  `price` double DEFAULT NULL,
  `sold` tinyint(1) NOT NULL,
  `display` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `artwork`
--

INSERT INTO `artwork` (`id`, `work_id`, `title`, `creation_date`, `price`, `sold`, `display`) VALUES
(34, 10, 'Camarón', '2024-10-18', 300, 0, 'diptych');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20241017183518', '2024-10-17 20:35:21', 85),
('DoctrineMigrations\\Version20241017184109', '2024-10-17 20:41:13', 6),
('DoctrineMigrations\\Version20241017202114', '2024-10-17 22:21:37', 23),
('DoctrineMigrations\\Version20241017213808', '2024-10-17 23:38:12', 62);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materials`
--

CREATE TABLE `materials` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `materials`
--

INSERT INTO `materials` (`id`, `name`) VALUES
(51, 'a vbe'),
(55, 'asa'),
(53, 'asas'),
(54, 'ddd'),
(48, 'Nueviismo'),
(56, 's');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `page`
--

CREATE TABLE `page` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `subtitle` varchar(5000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `page`
--

INSERT INTO `page` (`id`, `name`, `image`, `title`, `subtitle`) VALUES
(1, 'Inicio', 'IMG-2241-1-11zon-66f67b03af28a.jpg', NULL, NULL),
(2, 'Contacto', '71b10217-8e02-4add-b61b-351ef32ac36e-11zon-66f67b5bdba53.jpg', 'Hola!', 'Si desea colaboración, encargo o información sobre mis obras. \r\n!Siéntase libre de escribirme!'),
(3, 'Sobre mí', 'IMG-4988-6665d3f9466f9-666992270540b.jpg', 'Ana Estrada Macías (Cádiz, 2002)', 'Actualmente estudiante de Bellas Artes en la facultad de La Laguna, anteriormente ha realizado el Bachillerato de Artes plásticas. \r\nLe interesa lo poético, lo emocional y la naturaleza humana. Viendo arte en los detalles de lo cotidiano. Desde el atractivo de estos conceptos, crea desde dibujos hasta piezas objetuales, pasando por pequeñas instalaciones y esculturas. En estas piezas, cobra protagonismo el material, dándole a este gran importancia conceptual.\r\n\r\nEn este momento, cuenta con tres exposiciones, dos de ellas realizadas en la Facultad de Bellas Artes de La Laguna. Exposición Conjunta del Taller de Construcción, una muestra del trabajo realizado durante el curso que se celebró en Abril de 2024. Por otra parte, también participó en una exposición conjunta en la inauguración del Centro de Investigación y Prácticas Artísticas (CIPA), un conjunto de espacios y actividades enmarcadas en su inmueble, realizada en mayo de 2024.  Por último, participó en el concurso Cajacanarias 2024, siendo seleccionada y por tanto exponiendo en la sala de La Laguna.'),
(4, 'Login', 'cinta-1-6664ce36d6f23.jpg', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `piece`
--

CREATE TABLE `piece` (
  `id` int(11) NOT NULL,
  `artwork_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `height` double DEFAULT NULL,
  `width` double DEFAULT NULL,
  `depth` double DEFAULT NULL,
  `images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT '(DC2Type:json)' CHECK (json_valid(`images`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `piece`
--

INSERT INTO `piece` (`id`, `artwork_id`, `title`, `height`, `width`, `depth`, `images`) VALUES
(50, 34, 'Retrato de Camarón', 42, 12, NULL, '[\"67127c64eab05.jpg\"]'),
(52, 34, 'Iconografía de Camarón', 12, 23, NULL, '[\"671284fd88468.jpg\"]');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `piece_materials`
--

CREATE TABLE `piece_materials` (
  `piece_id` int(11) NOT NULL,
  `materials_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `nick` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT '(DC2Type:json)' CHECK (json_valid(`roles`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `name`, `surname`, `nick`, `phone`, `roles`) VALUES
(1, 'samurbinx@gmail.com', '$2y$13$kQUHp8LTiAI0XRMbXDL7Tew1Dr.cF7utq5cf5bFPxQars5KvlfJ2y', 'Samuel', 'Urbina Flor', 'Surbinx', '622039286', '[\"ROLE_ADMIN\"]'),
(2, 'prueba@gmail.com', '$2y$13$xDKXsQDu2NAbMIOETrH7OeMLmtuaguPzpB4YuM7vADNPG7Eq0ovpm', 'prueba', 'prueba', 'prueba', '987987987', '[\"ROLE_ADMIN\"]'),
(5, 'movil@gmail.com', '$2y$13$dW25L8AbI4EKqj4ACEJEt.xYv/XElATxiATq8b6OJBmkS5voneuh6', 'Movil', 'Movil', 'movilmovil', '31298998', '[]'),
(6, 'aesmart@gmail.com', '$2y$13$G3LhGcHSX8jP2IeyEnlYiem6TdPdWBAKDrHVvNZxkg3vasH9DzrdW', 'AESMART', 'Administración', 'AESMART', '622039221', '[\"ROLE_ADMIN\"]');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `work`
--

CREATE TABLE `work` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `statement` varchar(5000) DEFAULT NULL,
  `description` varchar(45) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `work`
--

INSERT INTO `work` (`id`, `title`, `statement`, `description`, `image`) VALUES
(10, 'Andalucía', 'Andalucía es una tierra llena de....', 'Falso grabado', 'andalucia-portada-67128e3332d4a.jpg');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `artwork`
--
ALTER TABLE `artwork`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_881FC576BB3453DB` (`work_id`);

--
-- Indices de la tabla `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indices de la tabla `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indices de la tabla `page`
--
ALTER TABLE `page`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `piece`
--
ALTER TABLE `piece`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_44CA0B23DB8FFA4` (`artwork_id`);

--
-- Indices de la tabla `piece_materials`
--
ALTER TABLE `piece_materials`
  ADD PRIMARY KEY (`piece_id`,`materials_id`),
  ADD KEY `IDX_AB969B33C40FCFA8` (`piece_id`),
  ADD KEY `IDX_AB969B333A9FC940` (`materials_id`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`);

--
-- Indices de la tabla `work`
--
ALTER TABLE `work`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `artwork`
--
ALTER TABLE `artwork`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `materials`
--
ALTER TABLE `materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT de la tabla `page`
--
ALTER TABLE `page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `piece`
--
ALTER TABLE `piece`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `work`
--
ALTER TABLE `work`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `artwork`
--
ALTER TABLE `artwork`
  ADD CONSTRAINT `FK_881FC576BB3453DB` FOREIGN KEY (`work_id`) REFERENCES `work` (`id`);

--
-- Filtros para la tabla `piece`
--
ALTER TABLE `piece`
  ADD CONSTRAINT `FK_44CA0B23DB8FFA4` FOREIGN KEY (`artwork_id`) REFERENCES `artwork` (`id`);

--
-- Filtros para la tabla `piece_materials`
--
ALTER TABLE `piece_materials`
  ADD CONSTRAINT `FK_AB969B333A9FC940` FOREIGN KEY (`materials_id`) REFERENCES `materials` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_AB969B33C40FCFA8` FOREIGN KEY (`piece_id`) REFERENCES `piece` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
