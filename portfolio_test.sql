-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-12-2024 a las 19:46:20
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


CREATE DATABASE IF NOT EXISTS portfolio;
USE portfolio;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `address`
--

CREATE TABLE `address` (
  `id` int(11) NOT NULL,
  `street` varchar(400) NOT NULL,
  `details` varchar(500) NOT NULL,
  `zip_code` varchar(5) NOT NULL,
  `city` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `recipient` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `address`
--

INSERT INTO `address` (`id`, `street`, `details`, `zip_code`, `city`, `province`, `user_id`, `recipient`, `phone`) VALUES
(7, 'Calle José Gil Sánchez', 'Bloque 2, 1º A', '11100', 'San Fernando', 'Cádiz', 11, 'Samuel Urbina Flor', '+34 6229387439'),
(26, 'Calle San Marcos', '23', '11200', 'Sanfernando', 'Cadiz', 2, 'Ana maria estrada', '+34 622039286');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `artwork`
--

CREATE TABLE `artwork` (
  `id` int(11) NOT NULL,
  `work_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `creation_date` date DEFAULT NULL,
  `price` double DEFAULT NULL,
  `sold` tinyint(1) NOT NULL,
  `display` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `artwork`
--

INSERT INTO `artwork` (`id`, `work_id`, `order_id`, `title`, `creation_date`, `price`, `sold`, `display`) VALUES
(1, 1, NULL, 'Descanso I', '2022-01-01', 169, 0, 'simple'),
(2, 1, NULL, 'Descanso II', '2022-01-01', 267, 0, 'simple'),
(5, 1, NULL, 'Cabeza I', '2022-01-01', 167, 0, 'simple'),
(6, 1, NULL, 'Cabeza II', '2022-01-01', 175, 0, 'simple'),
(7, 1, NULL, 'Descanso III', '2022-01-01', 279, 0, 'simple'),
(8, 1, NULL, 'Descanso IV', '2022-01-01', 160, 0, 'simple'),
(9, 1, NULL, 'Cabeza III', '2022-01-01', 123, 0, 'simple'),
(10, 2, NULL, 'Camarón', '2021-01-01', 171, 0, 'diptych'),
(11, 2, NULL, 'Gata Cattana', '2021-01-01', 154, 0, 'simple'),
(12, 2, NULL, 'Blas Infante', '2021-01-01', 296, 0, 'simple'),
(13, 2, NULL, 'Lola Flores', '2021-01-01', 249, 0, 'simple'),
(14, 2, NULL, 'Picasso', '2021-01-01', 168, 0, 'simple'),
(15, 2, NULL, 'Paco de Lucía', '2021-01-01', 145, 0, 'simple'),
(16, 2, NULL, 'Rocío Jurado', '2021-01-01', 109, 0, 'simple'),
(17, 2, NULL, 'Juan Ramón Jiménez', '2021-01-01', 238, 0, 'simple');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_amount` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `total_amount`) VALUES
(3, 2, 0),
(4, 6, 0),
(7, 11, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cart_artwork`
--

CREATE TABLE `cart_artwork` (
  `id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `artwork_id` int(11) NOT NULL,
  `selected` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
('DoctrineMigrations\\Version20241201162358', '2024-12-01 17:24:06', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `email_config`
--

CREATE TABLE `email_config` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pwd` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `email_config`
--

INSERT INTO `email_config` (`id`, `email`, `pwd`) VALUES
(1, 'samuelurbinaflor@gmail.com', 'gmbqsbcgizgdgtdv');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favorites`
--

CREATE TABLE `favorites` (
  `user_id` int(11) NOT NULL,
  `artwork_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(105, 'Tinta china'),
(111, 'Gouache'),
(112, 'Ferricianuro de potasio'),
(114, 'Citrato de amonio e hierro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_amount` double NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `status` varchar(10) NOT NULL,
  `address` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT '(DC2Type:json)' CHECK (json_valid(`address`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, 1, 'Descanso I', 118.9, 84.1, NULL, '[\"67251afad3fc2.jpg\"]'),
(2, 2, 'Descanso II', 118.9, 84.1, NULL, '[\"6725192a07d6d.jpg\"]'),
(3, 5, 'Cabeza I', 118.9, 84.1, NULL, '[\"67251b153752f.jpg\"]'),
(4, 6, 'Cabeza II', 118.9, 84.1, NULL, '[\"67251d2b45111.jpg\"]'),
(5, 7, 'Descanso III', 118.9, 84.1, NULL, '[\"67251d4109905.jpg\"]'),
(6, 8, 'Descanso IV', 118.9, 84.1, NULL, '[\"67251d594960b.jpg\"]'),
(7, 9, 'Cabeza III', 118.9, 84.1, NULL, '[\"67251d6cd453d.jpg\"]'),
(8, 10, 'Retrato de camaron', 42, 29.7, NULL, '[\"67251fa543336.jpg\"]'),
(9, 10, 'Iconografía de Camarón', 42, 29.7, NULL, '[\"67251fd3ba8c6.jpg\"]'),
(10, 11, 'Retrato de Gata Cattana', 42, 29.7, NULL, '[\"67251febdf3ff.jpg\"]'),
(11, 11, 'Iconografía de Gata Cattana', 42, 29.7, NULL, '[\"6725200421016.jpg\"]'),
(12, 12, 'Retrato de Blas Infante', 42, 29.7, NULL, '[\"67252017b84a0.jpg\"]'),
(13, 12, 'Iconografía de Blas Infante', 42, 29.7, NULL, '[\"6725202465a94.jpg\"]'),
(14, 13, 'Retrato de Lola Flores', 42, 29.7, NULL, '[\"6725203f969c6.jpg\"]'),
(15, 13, 'Iconografía de Lola Flores', 42, 29.7, NULL, '[\"67252053c1507.jpg\"]'),
(16, 14, 'Retrato de Picasso', 42, 29.7, NULL, '[\"6725207265f96.jpg\"]'),
(17, 14, 'Iconografía de Picasso', 42, 29.7, NULL, '[\"67252081314d5.jpg\"]'),
(18, 15, 'Retrato de Paco de Lucía', 42, 29.7, NULL, '[\"6725209d5b929.jpg\"]'),
(19, 15, 'Iconografía de Paco de Lucía', 42, 29.7, NULL, '[\"672520aedfe2c.jpg\"]'),
(20, 16, 'Retrato de Rocío Jurado', 42, 29.7, NULL, '[\"672520d288aa7.jpg\"]'),
(21, 16, 'Iconografía de Rocío Jurado', 42, 29.7, NULL, '[\"672520dfc9c55.jpg\"]'),
(22, 17, 'Retrato de Juan Ramón Jiménez', 42, 29.7, NULL, '[\"67252106d7458.jpg\"]'),
(23, 17, 'Iconografía de Juan Ramón Jiménez', 42, 29.7, NULL, '[\"6725213502076.jpg\"]');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `piece_materials`
--

CREATE TABLE `piece_materials` (
  `piece_id` int(11) NOT NULL,
  `materials_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `piece_materials`
--

INSERT INTO `piece_materials` (`piece_id`, `materials_id`) VALUES
(1, 112),
(1, 114),
(2, 112),
(2, 114),
(3, 112),
(3, 114),
(4, 112),
(4, 114),
(5, 112),
(5, 114),
(6, 112),
(6, 114),
(7, 112),
(7, 114),
(8, 105),
(8, 111),
(9, 105),
(9, 111),
(10, 105),
(10, 111),
(11, 105),
(11, 111),
(12, 105),
(12, 111),
(13, 105),
(13, 111),
(14, 105),
(14, 111),
(15, 105),
(15, 111),
(16, 105),
(16, 111),
(17, 105),
(17, 111),
(18, 105),
(18, 111),
(19, 105),
(19, 111),
(20, 105),
(20, 111),
(21, 105),
(21, 111),
(22, 105),
(22, 111),
(23, 105),
(23, 111);

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
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT '(DC2Type:json)' CHECK (json_valid(`roles`)),
  `token` varchar(700) DEFAULT NULL,
  `is_valid_t` tinyint(1) DEFAULT NULL,
  `address_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `name`, `surname`, `nick`, `phone`, `roles`, `token`, `is_valid_t`, `address_id`) VALUES
(2, 'samuelurbinaflor@gmail.com', '$2y$13$AVaoXV3jpFMSdas6ik97ZeOWO.pqmJ6kL1d0Qph0iwqcX.a1z0WTi', 'prueba', 'prueba', 'prueba', '987987987', '[]', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE3MzMwNzQ5NTEsImV4cCI6MTczMzA3ODU1MSwicm9sZXMiOlsiUk9MRV9BRE1JTiIsIlJPTEVfVVNFUiJdLCJ1c2VybmFtZSI6InBydWViYUBnbWFpbC5jb20ifQ.HkIKMWGG5GkY4yTY4oLlm_tDCtSv4boN-_-iP-8DcHDb08etzSGgkP1mq9qG8v9eibwF7e5_KZhII_8r2uZiwIqd40WS4uR2_AYu4xNFNv8kzwgzTcrY_aYOHOYX-EIUPjdDlrnW7ddDOuMPMDw_kixlwv1ZMBPAXz6LH1MZNsbwsUcSGN4_uybq-9OaoJMl6Z9Ktc9xIlnYkhTMzpijw12Yg0JD0G58qU_0mIbdjIrix2oTYUPlNXXb4rBaf8D5YH8tU9DXIUoE9PO0xhi_LvHTVkblz3GeBUVjy9EvVbrkEzAtUjDSeERYu-xisymi2QhP9NfSyNG5vXm3_9n_PA', 1, 26),
(6, 'aesmart@gmail.com', '$2y$13$G3LhGcHSX8jP2IeyEnlYiem6TdPdWBAKDrHVvNZxkg3vasH9DzrdW', 'AESMART', 'Administración', 'AESMART', '622039221', '[\"ROLE_ADMIN\"]', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE3MzEzNDU5NjAsImV4cCI6MTczMTM0OTU2MCwicm9sZXMiOlsiUk9MRV9BRE1JTiIsIlJPTEVfVVNFUiJdLCJ1c2VybmFtZSI6ImFlc21hcnRAZ21haWwuY29tIn0.h2qyyNg-6k4gTMh_oCkF3elzM3tNRfz1tCaZjPi-lh1ZMswOWz_uNJjao-_aHws4F7hg2cmJ02yFD4Hr4TdGpqWGROjWetrD-8CV6V7Q-Zs0wqcMRXEHM_r5rxWeNYhIpVEMYIZWRlWpOMPlKlCNBw-X4ty2xhkYv_eMe3EZfOuiFVpThXpabATNbbOPN-Drp2A5n6TBmuxQUp6_v8WIZd7wEAjgWsQfZvbSQeV5xcltgF2Nmz6mmB3K118IR-wru9GpMNaCYX_L18qvNBa3P0Nf5GCQU9Kv021C3jwI3N5Qx7j52-Fn3kPb66QguaIeguaDDRyU3lbmjdfbLO_dqg', 1, NULL),
(11, 'samurbinx@gmail.com', '$2y$13$ClAT30knDKxkRNNMZS4Ek.J2tpufBddTguT3hBumB4XM7YXJyrQsW', 'Samuel', 'Urbina Flor', 'Samuel', '622039286', '[\"ROLE_ADMIN\"]', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE3MzI5NzI3MzgsImV4cCI6MTczMjk3NjMzOCwicm9sZXMiOlsiUk9MRV9BRE1JTiIsIlJPTEVfVVNFUiJdLCJ1c2VybmFtZSI6InNhbXVyYmlueEBnbWFpbC5jb20ifQ.g9elKBppVMcd4osTyDJVzNEdI1kPcERYPlMuQt_nWwQPS2XYmhJ314yfsBj0ArHm6R2H73XWUSQkaKQiszj0fq46uNTC4e8dtRI-HczSDr_5jyRG_X6y1IPli9GF8Q2Gtb1H5EHZhiZDS-uNnE4Y_y0buMdb-kiuwAlbwaj-NP0ckvZlyPZ0sEVlBIVbfk0AbR54r0sGi6T5cq1q-rwb7cmxhwZiGgVcDehBusmIpjldT8nGC5SdQrMCq_zUVxd4ekpnT06qXieYUUso8Ykume7jS2xtcy6HZEQvQbgi8CAE0ymOtIhiiUuOojDK7Tv0k5HbBmw3M983-p45YnBpcQ', 1, 7);

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
(1, 'Oasis', 'Ramifico mis pensamientos intrusivos a la velocidad de la luz, al igual que una célula cancerosa por el cuerpo, esas ideas atraviesan toda mi cabeza. Me siento perseguida por mi misma en una carrera que no acaba.\r\nLo que más me sirve para callar mi cabeza es tumbarme al sol, su calor recorre todo mi cuerpo, sintiéndome como si estuviera en una incubadora. Cuando ya me siento mejor, cuando ya hay silencio, abro los ojos y veo todo azul a causa del sol.\r\n\r\nPor este color, que me ha acompañado en tantos momentos de autorregulación emocional, elegí la cianotipia como material para trabajar. Es una mezcla de citrato férrico amoniacal y ferricianuro prosaico.\r\n\r\nAl hacer las primeras pruebas con el material me sentí identificada con él. Cuando se hace la mezcla de estas dos sustancias tóxicas, se crea un color verde radiactivo, ácido y agresivo. Cuando el líquido ya está seco en el soporte es hora de sacarlo al sol, rápidamente me pongo encima de él, aplasto todo mi cuerpo mi cuerpo sobre el papel, y a la vez contra el suelo . Poco a poco su tono cambia de un azul tenue a uno más intenso, pero aún sigue sucio. No es hasta que lo baño en agua oxigenada, cuando se ven los colores de la cianotipia. Ahí es cuando abro los ojos y veo el mundo de una tonalidad azul apacible.', 'Cianotípia', 'oasis-portada-672518d62261a.jpg'),
(2, 'Andalucía', 'Este proyecto consta de diez retratos de artistas andaluces, hechos con un falso grabado, y otros diez dibujos, que representan lo que me inspiran esos artistas y el sitio donde nacieron, haciendo así un “tour” por toda Andalucía. Por lo que, en este proyecto no me he inspirado en un artista en concreto sino en cada bailaora, cantao’, poeta o pintor andaluz. Por lo que cada retrato va de la mano con su respectiva ilustración en la que se describe visualmente al artista y la pureza de su ciudad natal.\r\n\r\nEn este proyecto quiero contar el amor que tenemos los andaluces por nuestro hogar, costumbres y raíces. Por ello he escogido retratar a Lola flores, una jerezana y representación de todas las bailaoras y cantaoras, ellas difundieron un mensaje que iba más allá de las palabras y que representó en sus orígenes el lamento del pueblo gitano y morisco. Por otra parte, hay retratos de folclóricas como Rocío Jurado, la piedra más dura de Chipiona a ella ningún hombre le hizo sombra y artísticamente era una grandísima creadora. También tenemos a Gata Cattana, una Cordobesa, poetisa, rapera y politóloga , la representa sus letras cargados con mensajes feministas y contra la andaluzofobia. No nos puede faltar, el retrato de Blas Infante, poeta y político que luchó, y consiguió la independencia de Andalucía, su bandera y su himno. Para terminar nombraremos a los artistas andaluces más reconocidos como Lorca, Camarón, Juan Ramón Jimenez, Paco de Lucia, Picasso o Velazquez.\r\n\r\nEste trabajo, a parte de ser un listado de los grandes artistas andaluces, también es una queja a la a la andaluzofobia y a las típicas ideas que se tiene de los andaluces, en Andalucía se aprende, se vive y sobre todo se lucha.', 'Falso grabado', 'andalucia-portada-672523d02f695.jpg');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D4E6F81A76ED395` (`user_id`);

--
-- Indices de la tabla `artwork`
--
ALTER TABLE `artwork`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_881FC576BB3453DB` (`work_id`),
  ADD KEY `IDX_881FC5768D9F6D38` (`order_id`);

--
-- Indices de la tabla `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_BA388B7A76ED395` (`user_id`);

--
-- Indices de la tabla `cart_artwork`
--
ALTER TABLE `cart_artwork`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_73C50D711AD5CDBFDB8FFA4` (`cart_id`,`artwork_id`),
  ADD KEY `IDX_73C50D711AD5CDBF` (`cart_id`),
  ADD KEY `IDX_73C50D71DB8FFA4` (`artwork_id`);

--
-- Indices de la tabla `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indices de la tabla `email_config`
--
ALTER TABLE `email_config`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`user_id`,`artwork_id`),
  ADD KEY `IDX_E46960F5A76ED395` (`user_id`),
  ADD KEY `IDX_E46960F5DB8FFA4` (`artwork_id`);

--
-- Indices de la tabla `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_F5299398A76ED395` (`user_id`);

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
  ADD UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`),
  ADD UNIQUE KEY `UNIQ_8D93D649F5B7AF75` (`address_id`);

--
-- Indices de la tabla `work`
--
ALTER TABLE `work`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `address`
--
ALTER TABLE `address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `artwork`
--
ALTER TABLE `artwork`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de la tabla `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `cart_artwork`
--
ALTER TABLE `cart_artwork`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=281;

--
-- AUTO_INCREMENT de la tabla `email_config`
--
ALTER TABLE `email_config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `materials`
--
ALTER TABLE `materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT de la tabla `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT de la tabla `page`
--
ALTER TABLE `page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `piece`
--
ALTER TABLE `piece`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `work`
--
ALTER TABLE `work`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `FK_D4E6F81A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Filtros para la tabla `artwork`
--
ALTER TABLE `artwork`
  ADD CONSTRAINT `FK_881FC5768D9F6D38` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`),
  ADD CONSTRAINT `FK_881FC576BB3453DB` FOREIGN KEY (`work_id`) REFERENCES `work` (`id`);

--
-- Filtros para la tabla `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `FK_BA388B7A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Filtros para la tabla `cart_artwork`
--
ALTER TABLE `cart_artwork`
  ADD CONSTRAINT `FK_73C50D711AD5CDBF` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`id`),
  ADD CONSTRAINT `FK_73C50D71DB8FFA4` FOREIGN KEY (`artwork_id`) REFERENCES `artwork` (`id`);

--
-- Filtros para la tabla `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `FK_E46960F5A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_E46960F5DB8FFA4` FOREIGN KEY (`artwork_id`) REFERENCES `artwork` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `FK_F5299398A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

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

--
-- Filtros para la tabla `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_8D93D649F5B7AF75` FOREIGN KEY (`address_id`) REFERENCES `address` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
