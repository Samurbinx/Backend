-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-11-2024 a las 10:00:27
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
  `order_id_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `creation_date` date DEFAULT NULL,
  `price` double DEFAULT NULL,
  `sold` tinyint(1) NOT NULL,
  `display` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `artwork`
--

INSERT INTO `artwork` (`id`, `work_id`, `order_id_id`, `title`, `creation_date`, `price`, `sold`, `display`) VALUES
(1, 1, NULL, 'Descanso I', '2022-01-01', 169, 0, 'simple'),
(2, 1, NULL, 'Descanso II', '2022-01-01', 267, 0, 'simple'),
(5, 1, NULL, 'Cabeza I', '2022-01-01', 167, 1, 'simple'),
(6, 1, NULL, 'Cabeza II', '2022-01-01', 175, 0, 'simple'),
(7, 1, NULL, 'Descanso III', '2022-01-01', 279, 0, 'simple'),
(8, 1, NULL, 'Descanso IV', '2022-01-01', 160, 0, 'simple'),
(9, 1, NULL, 'Cabeza III', '2022-01-01', 123, 1, 'simple'),
(10, 2, NULL, 'Camarón', '2021-01-01', 171, 1, 'simple'),
(11, 2, NULL, 'Gata Cattana', '2021-01-01', 154, 1, 'simple'),
(12, 2, NULL, 'Blas Infante', '2021-01-01', 296, 1, 'simple'),
(13, 2, NULL, 'Lola Flores', '2021-01-01', 249, 1, 'simple'),
(14, 2, NULL, 'Picasso', '2021-01-01', 168, 0, 'simple'),
(15, 2, NULL, 'Paco de Lucía', '2021-01-01', 145, 0, 'simple'),
(16, 2, NULL, 'Rocío Jurado', '2021-01-01', 109, 1, 'simple'),
(17, 2, NULL, 'Juan Ramón Jiménez', '2021-01-01', 238, 0, 'simple'),
(18, 2, NULL, 'Lorca', '2021-01-01', 259, 1, 'simple'),
(19, 2, NULL, 'Velazquez', '2021-01-01', 109, 1, 'simple'),
(20, 3, NULL, 'Autorretrato', '2021-01-01', 194, 0, 'simple'),
(24, 3, NULL, NULL, NULL, NULL, 1, 'detail'),
(25, 4, NULL, 'Jaula frágil', '2022-01-01', 155, 0, 'simple'),
(29, 4, NULL, NULL, NULL, NULL, 1, 'covercarousel'),
(30, 4, NULL, 'Piel rota', '2022-01-01', 152, 0, 'simple'),
(31, 4, NULL, NULL, NULL, NULL, 1, 'detail'),
(32, 4, NULL, 'Rotura I', '2022-01-01', 163, 1, 'simple'),
(33, 4, NULL, 'Rotura II', '2022-01-01', 181, 0, 'simple'),
(34, 4, NULL, 'Rotura III', '2022-01-01', 238, 1, 'simple'),
(35, 4, NULL, 'Rotura IV', '2022-01-01', 118, 1, 'simple'),
(36, 5, NULL, 'Camino', '2024-01-01', NULL, 1, 'diptych'),
(38, 5, NULL, 'Costras', '2024-01-01', NULL, 0, 'diptych'),
(39, 5, NULL, 'Herida II', NULL, NULL, 1, 'simple'),
(40, 5, NULL, NULL, '2024-01-01', NULL, 0, NULL),
(41, 5, NULL, NULL, '2024-01-01', NULL, 0, NULL),
(42, 5, NULL, NULL, '2024-01-01', NULL, 0, NULL),
(43, 5, NULL, NULL, '2024-01-01', NULL, 0, NULL),
(44, 6, NULL, 'Cuna', '2022-01-01', 261, 0, 'simple');

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
(1, 9, 0),
(2, 1, 0),
(3, 2, 0),
(4, 6, 0),
(5, 5, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cart_artwork`
--

CREATE TABLE `cart_artwork` (
  `cart_id` int(11) NOT NULL,
  `artwork_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cart_artwork`
--

INSERT INTO `cart_artwork` (`cart_id`, `artwork_id`) VALUES
(1, 1),
(1, 2),
(1, 6),
(1, 7),
(1, 8),
(1, 17),
(1, 30),
(3, 1),
(3, 2),
(3, 6),
(3, 7),
(3, 8),
(4, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favorites`
--

CREATE TABLE `favorites` (
  `user_id` int(11) NOT NULL,
  `artwork_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `favorites`
--

INSERT INTO `favorites` (`user_id`, `artwork_id`) VALUES
(2, 1),
(2, 2),
(2, 9),
(2, 10),
(2, 14),
(9, 1),
(9, 2),
(9, 5);

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
(104, 'Óleo'),
(105, 'Tinta china'),
(107, 'Acuarela'),
(111, 'Gouache'),
(112, 'Ferricianuro de potasio'),
(114, 'Citrato de amonio e hierro'),
(116, 'Escayola'),
(117, 'Tela'),
(118, 'Grafito'),
(119, 'Betadine'),
(120, 'Madera'),
(121, 'Cinta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_amount` double NOT NULL
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
(23, 17, 'Iconografía de Juan Ramón Jiménez', 42, 29.7, NULL, '[\"6725213502076.jpg\"]'),
(24, 18, 'Iconografía de Lorca', 42, 29.7, NULL, '[\"6725215bc89dd.jpg\"]'),
(25, 19, 'Retrato de Velazquez', 42, 29.7, NULL, '[\"67252246449a2.jpg\"]'),
(26, 20, 'Autorretrato', 80, 60, 5, '[\"6725246e718d7.jpg\"]'),
(28, 25, 'Jaula frágil', 125, 100, 140, '[\"6725258d54287.jpg\"]'),
(29, 29, NULL, NULL, NULL, NULL, '[\"672525b68af7d.jpg\",\"672525b68b662.jpg\",\"672525b68b96d.jpg\",\"672525b68bc99.jpg\",\"672525b68bf68.jpg\",\"672525b68c26c.jpg\",\"672525b68c5f0.jpg\",\"672525b68c95a.jpg\"]'),
(30, 30, 'Piel rota', 60, 87, NULL, '[\"6725260e2cdaf.jpg\"]'),
(31, 31, NULL, NULL, NULL, NULL, '[\"67252636cfde3.jpg\",\"67252636d04b2.jpg\",\"67252636d0854.jpg\",\"67252636d0bd3.jpg\",\"67252636d0e77.jpg\"]'),
(32, 32, 'Rotura I', 42, 29.7, NULL, '[\"6725267aefe3f.jpg\"]'),
(33, 33, 'Rotura II', 42, 29.7, NULL, '[\"67252695a5008.jpg\"]'),
(34, 34, 'Rotura III', 42, 29.7, NULL, '[\"672526ad61928.jpg\"]'),
(35, 35, 'Rotura IV', 42, 29.7, NULL, '[\"672526c0d1a71.jpg\"]'),
(36, 36, NULL, NULL, NULL, NULL, '[\"67252710f0d2d.jpg\",\"67252710f13a1.jpg\"]'),
(37, 38, 'Herida I', 30, 20, 2, '[\"6725272c4f2d5.jpg\"]'),
(39, 40, NULL, NULL, NULL, NULL, '[\"6725274c97e77.jpg\"]'),
(40, 41, NULL, NULL, NULL, NULL, '[\"672527835b3a4.jpg\"]'),
(41, 42, NULL, NULL, NULL, NULL, '[\"67252796e0a52.jpg\"]'),
(42, 43, NULL, NULL, NULL, NULL, '[\"672527a6b689b.jpg\"]'),
(43, 44, 'Cuna', NULL, NULL, NULL, '[]'),
(102, 18, 'Retrato de Lorca', 42, 29.7, NULL, '[\"6725238097d82.jpg\"]'),
(103, 24, NULL, NULL, NULL, NULL, '[\"672524ab2082f.jpg\",\"672524ab20fb0.jpg\",\"672524ab2138a.jpg\"]'),
(105, 56, NULL, NULL, NULL, NULL, '[\"672529740b1cd.jpg\"]'),
(106, 39, 'Herida II', 30, 20, 2, '[\"67252a6565956.jpg\"]');

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
(23, 111),
(24, 105),
(24, 111),
(25, 105),
(25, 111),
(26, 104),
(28, 116),
(30, 117),
(32, 118),
(33, 118),
(34, 118),
(35, 118),
(36, 120),
(36, 121),
(37, 119),
(102, 105),
(102, 111),
(106, 119);

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
  `is_valid_t` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `name`, `surname`, `nick`, `phone`, `roles`, `token`, `is_valid_t`) VALUES
(1, 'samurbinx@gmail.com', '$2y$13$kQUHp8LTiAI0XRMbXDL7Tew1Dr.cF7utq5cf5bFPxQars5KvlfJ2y', 'Samuel', 'Urbina Flor', 'Surbinx', '622039286', '[\"ROLE_ADMIN\"]', NULL, NULL),
(2, 'prueba@gmail.com', '$2y$13$xDKXsQDu2NAbMIOETrH7OeMLmtuaguPzpB4YuM7vADNPG7Eq0ovpm', 'prueba', 'prueba', 'prueba', '987987987', '[\"ROLE_ADMIN\"]', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE3MzEzNDg3ODgsImV4cCI6MTczMTM1MjM4OCwicm9sZXMiOlsiUk9MRV9BRE1JTiIsIlJPTEVfVVNFUiJdLCJ1c2VybmFtZSI6InBydWViYUBnbWFpbC5jb20ifQ.VCfIyWqQpBFYUB2eNmCVC2Iu_GJ4V-373tOy-Jz9qoRXRNqW2-M6v3VgCxU_R28WQ8gtqp101lBLdv97ljYkG-9bmcMHaelntfDElyhxqyZ0BFNqAbnrG5jA67-aODizXN5HrQKEqUT0O7RDag-0VSl2B93JWVwbkuj6sL3DjQCwl2ff7EKYYTqyMcbYGHYhksa3mESStkDraLypWr9daRcDA-ntlP5jt0Jrfurhqx2C92MljPsDLlbAtS0179pRCwvEFs2HiCl4NQ1zvqq1OrHUXR_NxS2wKKo-sl5hQW0pjyE8wWY31liB3HmQSZob2tZDNc1-fASEbpxxeYF3-w', 1),
(5, 'movil@gmail.com', '$2y$13$dW25L8AbI4EKqj4ACEJEt.xYv/XElATxiATq8b6OJBmkS5voneuh6', 'Movil', 'Movil', 'movilmovil', '31298998', '[]', NULL, NULL),
(6, 'aesmart@gmail.com', '$2y$13$G3LhGcHSX8jP2IeyEnlYiem6TdPdWBAKDrHVvNZxkg3vasH9DzrdW', 'AESMART', 'Administración', 'AESMART', '622039221', '[\"ROLE_ADMIN\"]', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE3MzEzNDU5NjAsImV4cCI6MTczMTM0OTU2MCwicm9sZXMiOlsiUk9MRV9BRE1JTiIsIlJPTEVfVVNFUiJdLCJ1c2VybmFtZSI6ImFlc21hcnRAZ21haWwuY29tIn0.h2qyyNg-6k4gTMh_oCkF3elzM3tNRfz1tCaZjPi-lh1ZMswOWz_uNJjao-_aHws4F7hg2cmJ02yFD4Hr4TdGpqWGROjWetrD-8CV6V7Q-Zs0wqcMRXEHM_r5rxWeNYhIpVEMYIZWRlWpOMPlKlCNBw-X4ty2xhkYv_eMe3EZfOuiFVpThXpabATNbbOPN-Drp2A5n6TBmuxQUp6_v8WIZd7wEAjgWsQfZvbSQeV5xcltgF2Nmz6mmB3K118IR-wru9GpMNaCYX_L18qvNBa3P0Nf5GCQU9Kv021C3jwI3N5Qx7j52-Fn3kPb66QguaIeguaDDRyU3lbmjdfbLO_dqg', 1),
(9, 'holaa@gmail.com', '$2y$13$I9mf1FLxCTRZtkk7NcGgS.YwJXHLTAtyLPJnHmZN3EQ2Q/THS/ox2', 'holaa', 'holaa', 'holaaa', '12334543645', '[]', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE3MzExNzMyNjgsImV4cCI6MTczMTE3Njg2OCwicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoiaG9sYWFAZ21haWwuY29tIn0.HvDM7q2V_tuyd_-bbbM3LJiRxfPTAzs0QZEPCMtmOMrEs2bGyV16QUcS_5NHOb7tWDQFqOX-MnbFAkN_4fpLOxZMQzypksgm2oTWxaWJldaRZTFMe_ZhRYUgF0ZtF4jQTDYBr6Lw8VjpHl7AYVQkDPwD86toee-2x-q2AGeqF5JQhDJUBKyX0xzL4u08VHKcn9bY8ezwNqIB86GjtGMJHku4zpitB1Bxvj5WWI6fZy-2BTuMmQNzn6fWokjA19zoiYNN-ypT982GY9U7qmytXz9WhOxCv3yzYr330RrRm3AjrWPGwszQ8QMUiJLazcCO2a_BYy2CSvXRRNDxYltP3A', 1);

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
(2, 'Andalucía', 'Este proyecto consta de diez retratos de artistas andaluces, hechos con un falso grabado, y otros diez dibujos, que representan lo que me inspiran esos artistas y el sitio donde nacieron, haciendo así un “tour” por toda Andalucía. Por lo que, en este proyecto no me he inspirado en un artista en concreto sino en cada bailaora, cantao’, poeta o pintor andaluz. Por lo que cada retrato va de la mano con su respectiva ilustración en la que se describe visualmente al artista y la pureza de su ciudad natal.\r\n\r\nEn este proyecto quiero contar el amor que tenemos los andaluces por nuestro hogar, costumbres y raíces. Por ello he escogido retratar a Lola flores, una jerezana y representación de todas las bailaoras y cantaoras, ellas difundieron un mensaje que iba más allá de las palabras y que representó en sus orígenes el lamento del pueblo gitano y morisco. Por otra parte, hay retratos de folclóricas como Rocío Jurado, la piedra más dura de Chipiona a ella ningún hombre le hizo sombra y artísticamente era una grandísima creadora. También tenemos a Gata Cattana, una Cordobesa, poetisa, rapera y politóloga , la representa sus letras cargados con mensajes feministas y contra la andaluzofobia. No nos puede faltar, el retrato de Blas Infante, poeta y político que luchó, y consiguió la independencia de Andalucía, su bandera y su himno. Para terminar nombraremos a los artistas andaluces más reconocidos como Lorca, Camarón, Juan Ramón Jimenez, Paco de Lucia, Picasso o Velazquez.\r\n\r\nEste trabajo, a parte de ser un listado de los grandes artistas andaluces, también es una queja a la a la andaluzofobia y a las típicas ideas que se tiene de los andaluces, en Andalucía se aprende, se vive y sobre todo se lucha.', 'Falso grabado', 'andalucia-portada-672523d02f695.jpg'),
(3, 'Autorretrato', NULL, 'Cuadro único', 'autorretrato-portada-67252548a3d0b.jpg'),
(4, 'Jaula frágil', 'Partí de la idea de la feminidad. Quise, en un primer momento, describir este término a nivel social. No llegué a nada claro, así que acoté el rango y decidí hablar de que era la feminidad para mí. Escribí en relación. Mi concepto de lo femenino, pero cada frase que escribía la terminaba tachando. Entre en un bucle intenso donde buscaba las palabras concretas para poder captaresa idea. Al final me di por vencida, no encontré las palabras. No me daba cuenta que no podía escribir las palabras correctas cuando no las hay. No se pueden buscar palabras que no existen. Seguramente, si yo me siento mujer es porque me han educado para ser una.\r\n\r\nEn ese bucle en el que entré, en el momento me incomodaba, pero ahora veo un gran tema donde indagar. Esa es una de las primeras ideas, ese bucle y la tensión que me generó.\r\nPor otra parte veo necesario tratar el género.Tanto lo femenino como lo masculino son construcciones sociales, esa idea la tenía clara, de ahí venían mis contradicciones mentales al querer tratar en un inicio la “feminidad”. Se nos asigna un género al nacer, normalmente a partir de nuestro sexo. Luego, según este, se nos educa de una u otra manera, creando roles discriminatorios y etiquetas que nos encierran en algo que, realmente, no existe.\r\nEl género es la idea primaria del proyecto, pero otra muy importante es la de encierro. Aunque me quiera salir de la “jaula” género femenino, me metería en otra ya sea de no fluido o de trans masculino. Aquí se repite ese bucle que es necesario romper.\r\n\r\nBourdieu habla sobre el habitús. El habitus es como nuestra forma de ser que aprendemos de la sociedad. Son las cosas que hacemos y pensamos porque así nos han enseñado desde pequeños. Nuestra mente y cuerpo se acostumbran a estas formas de actuar y pensar. Aunque parece que nacemos con ello, en realidad lo aprendemos de cómo la sociedad funciona. Se refiere a lo que aprendemos y queda con nosotros por mucho tiempo. El género obviamente está muy implicado en este término.\r\nPara mi, contra más conscientes seamos del habitus, de los roles de género y del mal de estos, más fácil se nos hará salir de esas construcciones. Pudiendo así movernos con más libertad.', 'Escultura, arte textil y cuerpo.', 'jaula-fragil-portada-6725255d6f2da.jpg'),
(5, 'Un intento más', 'Arreglar algo roto, algo que está tan destruido, derrumbado y en la ruina que es completamente inútil e inservible. Pero haces todo lo que esté en tu mano para, por lo\r\nmenos, intentar repararlo. ¿Por qué esa fijación por desear curar lo incurable? ¿Por qué querer tanto arreglar aquello que está obviamente destrozado, poniendo tanto de ti que llegue hasta herirte? Yo lo veo como un acto melancólico, un deseo a que todo esté como antes, como antes de que se rompiera.Y que, con gestos de de mimo, cuidado y ternura, pueda llegar a estar como nuevo, pero eso nunca sucede. \r\n\r\nSe juntan ideas contrarias, lo irreparable y la reparación, creando así piezas utópicas en las que se refleja la angustia del querer y no poder. El modo de trabajo acompaña totalmente a esta acción o intento descontrolado de reparar. Se crean piezas a través de la basura pero primero estas pasan por un filtro humano(el mío). Cuando la recojo siento que dejan de estar abandonadas, pienso en ella, la atiendo, la cuido, intento ver lo que necesita para que vuelva a ser algo más que basura. Intento que sean válidas, útiles, reformadas, pero mis intentos quedan en nada, sigue siendo basura.\r\nEl resultado son unas piezas que, aunque, son de materiales duros como la madera o la escayola, dan la sensación de fragilidad.Se ha creado así una atmósfera cálida en la que, evoca a las ruinas y los escombros pero a la vez a la carnalidad de una herida que se está curando lentamente.\r\n\r\nEn el mundo ya hay suficiente dolor. Prácticamente todos los días escuchamos que se ha iniciado una nueva guerra, un nuevo asesinato, una nueva injusticia. Hay tanto\r\ndolor que se está resquebrajando todo, empeorando la situación a cada día que pasa. Sumando, que vivimos en una sociedad que nos exige la rapidez continua, en la\r\nque ni siquiera podemos pararnos a pensar que está pasando realmente. Y mucho menos podemos pararnos a intentar arreglar lo que está ocurriendo.\r\nPersonalmente, cuando me entero de algunas de las desgracias que rompen el mundo un poco más, me atropella un sentimiento de impotencia. ¿Y yo que puedo hacer\r\npara solucionarlo? Normalmente me enfado porque no puedo arreglar nada, la solución no está en mi mano, así que prefiero mirar a otro lado, esperar que alguien lo\r\nsolucione.\r\n\r\nEste proyecto nace de esta frustración. Decido arreglar, curar, mimar, reparar con ternura lo que necesite de mi ayuda.\r\nCreo pequeñas intervenciones, piezas objetuales, dibujo y esculturas que giran en torno a este tema. Un tema que se ramifica desembocando en otros en forma de eco o resuene. Creo una conjunto de piezas cálidas que desembocan en lo humano, aunque el material no sea muy cárnico, como por ejemplo la cinta es plástica y fría pero se hacen arrugas que llegan a parecer piel.\r\n\r\nOlga Tokarczuk, en su escrito El narrador tierno habla de la importancia de la ternura y el mimo, como no podré escribirlo mejor que ella dejo aquí un pedacito de su\r\ntexto: “La ternura es la forma más modesta de amor. Es el tipo de amor que no aparece en las Escrituras o en los evangelios, nadie lo jura, nadie lo cita. No tiene\r\nemblemas o símbolos especiales, ni conduce a la delincuencia ni a la envidia inmediata.\r\nAparece donde miramos de cerca y con cuidado a otro ser, a algo que no es nuestro «yo».\r\nLa ternura es espontánea y desinteresada; va mucho más allá del sentimiento de empatía. En cambio, es el compartir consciente, aunque quizás un poco melancólico,\r\ndel destino común. La ternura es una profunda preocupación emocional por otro ser, su fragilidad, su naturaleza única y su falta de inmunidad al sufrimiento y los efectos\r\ndel tiempo. La ternura percibe los lazos que nos conectan, las similitudes y la similitud entre nosotros. Es una forma de mirar que muestra al mundo como vivo,\r\ninterconectado, cooperando y codependiente de sí mismo.”\r\nMe gusta pensar que con este cuidado al prójimo, en mi caso al objeto que “salvo” del olvido. Con ese tiempo que dedico en cuidar, mimar, reparo y rescato también me\r\nestoy rescatando a mi .', 'Objeto e instalación', 'un-intento-mas-portada-672526e4333f2.jpg'),
(6, 'Cuna', 'Es curioso que una sombra por más dura o difusa que sea siempre nos dice que justo ahí está corriendo algo, que algo está presente. Podemos estar mirando al suelo, ver una sombra, mirar para arriba y sorprendernos con un árbol. Las sombras caminan, se mueven, dan la vuelta o simplemente están quietas en su sitio y es el contacto de la Tierra con el Sol las que las cambia. Hay veces en las que estamos rodeados de sombras, y donde ser capaces de ver el árbol es realmente complicado. Lo que ocurre es que aún así, mirando el suelo, me puedo imaginar que allí arriba se encuentra un árbol. Un árbol que desde su altura también me está mirando a mí y aunque yo solo vea su sombra, lo importante es que los dos nos estamos mirando. Y que los dos sabemos que estamos ahí.\r\n\r\nHay veces que ver es complicado, o más que complicado, incierto. Sobre todo cuando no sabemos muy bien qué está pasando. Si en algún momento miras a tu alrededor, y no ves nada, recuerda que en algún sitio estará la sombra de la hoja de un árbol dando vueltas por ahí. Sin dejar de moverse.', 'Objeto y performance', 'cuna-portada-67252884c0bf5.jpg');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `artwork`
--
ALTER TABLE `artwork`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_881FC576BB3453DB` (`work_id`),
  ADD KEY `IDX_881FC576FCDAEAAA` (`order_id_id`);

--
-- Indices de la tabla `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_BA388B7A76ED395` (`user_id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `cart_artwork`
--
ALTER TABLE `cart_artwork`
  ADD PRIMARY KEY (`cart_id`,`artwork_id`),
  ADD KEY `IDX_73C50D711AD5CDBF` (`cart_id`),
  ADD KEY `IDX_73C50D71DB8FFA4` (`artwork_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de la tabla `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `materials`
--
ALTER TABLE `materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT de la tabla `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `page`
--
ALTER TABLE `page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `piece`
--
ALTER TABLE `piece`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `work`
--
ALTER TABLE `work`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `artwork`
--
ALTER TABLE `artwork`
  ADD CONSTRAINT `FK_881FC576BB3453DB` FOREIGN KEY (`work_id`) REFERENCES `work` (`id`),
  ADD CONSTRAINT `FK_881FC576FCDAEAAA` FOREIGN KEY (`order_id_id`) REFERENCES `order` (`id`);

--
-- Filtros para la tabla `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `FK_BA388B7A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Filtros para la tabla `cart_artwork`
--
ALTER TABLE `cart_artwork`
  ADD CONSTRAINT `FK_73C50D711AD5CDBF` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_73C50D71DB8FFA4` FOREIGN KEY (`artwork_id`) REFERENCES `artwork` (`id`) ON DELETE CASCADE;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
