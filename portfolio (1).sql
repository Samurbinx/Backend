-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-10-2024 a las 16:31:42
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
('DoctrineMigrations\\Version20240610112708', '2024-06-10 13:27:20', 99);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `illustration`
--

CREATE TABLE `illustration` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `image` varchar(45) DEFAULT NULL,
  `price` float NOT NULL,
  `stock` int(11) DEFAULT NULL,
  `collection` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `illustration`
--

INSERT INTO `illustration` (`id`, `title`, `image`, `price`, `stock`, `collection`) VALUES
(1, 'Amanecer en la Montaña', '66fbf92253965.png', 15, 10, 'Naturaleza'),
(2, 'Olas en la Playa', '66fbe8dddfba4.webp', 20, 5, 'Verano'),
(3, 'Bosque Encantado', '66fbe8ece61f2.webp', 10, 8, 'Naturaleza'),
(4, 'Aurora Boreal', '66fbf92eb69d0.png', 25, 12, 'Cielo'),
(5, 'Atardecer en la Ciudad', 'atardecer_en_la_ciudad.jpg', 18, 7, 'Urbano'),
(6, 'Cascada Escondida', '66fbf90298277.png', 22, 15, 'Naturaleza'),
(7, 'La Magia de la Noche', 'la_magia_de_la_noche.jpg', 14, 10, 'Cielo'),
(8, 'Misterios del Bosque', '66fbfa5641cf0.png', 11, 20, 'Naturaleza'),
(9, 'Sueños de Verano', 'suenos_de_verano.jpg', 19, 6, 'Verano'),
(10, 'Horizonte Infinito', 'horizonte_infinito.jpg', 21, 4, 'Fantasía'),
(11, 'Noche Estrellada', 'noche_estrellada.jpg', 16, 9, 'Cielo'),
(12, 'Luz de Luna', 'luz_de_luna.jpg', 12, 11, 'Naturaleza'),
(13, 'Días de Playa', 'dias_de_playa.jpg', 17, 3, 'Verano'),
(14, 'Senderos Ocultos', 'senderos_ocultos.jpg', 13, 8, 'Naturaleza'),
(15, 'Reflejos en el Lago', 'reflejos_en_el_lago.jpg', 24, 5, 'Naturaleza'),
(16, 'Cielo de Primavera', 'cielo_de_primavera.jpg', 15, 10, 'Cielo'),
(17, 'Siluetas Urbanas', 'siluetas_urbanas.jpg', 23, 7, 'Urbano'),
(18, 'Plenitud Floral', 'plenitud_floral.jpg', 9, 14, 'Naturaleza'),
(19, 'Río Serpenteante', 'rio_serpenteante.jpg', 20, 6, 'Naturaleza'),
(20, 'Sombras de la Ciudad', 'sombras_de_la_ciudad.jpg', 12, 12, 'Urbano'),
(21, 'Mar en Tempestad', 'mar_en_tempestad.jpg', 22, 3, 'Verano'),
(22, 'Paz del Atardecer', 'paz_del_atardecer.jpg', 15, 9, 'Naturaleza'),
(23, 'Cielo de Otoño', 'cielo_de_otono.jpg', 19, 8, 'Cielo'),
(24, 'Estrellas Brillantes', 'estrellas_brillantes.jpg', 10, 15, 'Cielo'),
(25, 'Colores del Océano', 'colores_del_oceano.jpg', 21, 4, 'Verano'),
(26, 'Miradas de Ciudad', 'miradas_de_ciudad.jpg', 14, 7, 'Urbano'),
(27, 'Encanto del Invierno', 'encanto_del_invierno.jpg', 11, 20, 'Naturaleza'),
(28, 'Rincones de la Naturaleza', 'rincones_de_la_naturaleza.jpg', 18, 6, 'Naturaleza'),
(29, 'Viaje a la Luna', 'viaje_a_la_luna.jpg', 24, 5, 'Cielo'),
(30, 'Montañas Nevadas', 'montanas_nevadas.jpg', 16, 10, 'Naturaleza'),
(31, 'Caminos de Tierra', 'caminos_de_tierra.jpg', 13, 9, 'Naturaleza'),
(32, 'Reflejos de Sol', 'reflejos_de_sol.jpg', 20, 3, 'Verano'),
(33, 'Verde Esperanza', 'verde_esperanza.jpg', 15, 11, 'Naturaleza'),
(34, 'El Susurro del Viento', 'el_susurro_del_viento.jpg', 17, 8, 'Cielo'),
(35, 'Bailarinas de la Noche', 'bailarinas_de_la_noche.jpg', 22, 6, 'Cielo'),
(36, 'Mariposas en el Jardín', 'mariposas_en_el_jardin.jpg', 12, 12, 'Naturaleza'),
(37, 'Ríos de Color', 'rios_de_color.jpg', 19, 5, 'Naturaleza'),
(38, 'Danza de los Pinos', 'danza_de_los_pinos.jpg', 14, 7, 'Naturaleza'),
(39, 'Cielo en Movimiento', 'cielo_en_movimiento.jpg', 25, 4, 'Cielo'),
(40, 'Reflejos del Pasado', 'reflejos_del_pasado.jpg', 20, 8, 'Urbano'),
(41, 'Cascadas de Ensueño', 'cascadas_de_ensueno.jpg', 11, 15, 'Naturaleza'),
(42, 'Colores del Amanecer', 'colores_del_amanecer.jpg', 18, 3, 'Cielo'),
(43, 'Tiempos de Verano', 'tiempos_de_verano.jpg', 16, 9, 'Verano'),
(44, 'Senderos de Primavera', 'senderos_de_primavera.jpg', 21, 10, 'Naturaleza'),
(45, 'Sombras de Primavera', 'sombras_de_primavera.jpg', 22, 5, 'Cielo'),
(46, 'Estación de Flores', 'estacion_de_flores.jpg', 19, 7, 'Naturaleza'),
(47, 'Cielo Enrojecido', 'cielo_enrojecido.jpg', 12, 11, 'Cielo'),
(48, 'Nubes de Algodón', 'nubes_de_algodon.jpg', 24, 2, 'Cielo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cost` float NOT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `order_has_illustration`
--

CREATE TABLE `order_has_illustration` (
  `order_id` int(11) NOT NULL,
  `illustration_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `work_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `creation_date` date DEFAULT NULL,
  `materials` varchar(255) DEFAULT NULL,
  `height` double DEFAULT NULL,
  `width` double DEFAULT NULL,
  `depht` double DEFAULT NULL,
  `images` longtext DEFAULT NULL COMMENT '(DC2Type:json)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `piece`
--

INSERT INTO `piece` (`id`, `work_id`, `title`, `creation_date`, `materials`, `height`, `width`, `depht`, `images`) VALUES
(1, 1, 'Descanso I', '2023-01-01', 'Cianotípia sobre papel', 100, 70, NULL, '[\"6664935586e33.jpg\"]'),
(2, 1, 'Descanso II', '2023-01-01', 'Cianotípia sobre papel', 100, 70, NULL, '[\"6664936c539ad.jpg\"]'),
(5, 1, 'Cabeza I', '2023-01-01', 'Cianotípia sobre papel', 42, 59.4, NULL, '[\"666493d0108e8.jpg\"]'),
(6, 1, 'Cabeza II', '2023-01-01', 'Cianotípia sobre papel', 42, 59.4, NULL, '[\"666493eeaa878.jpg\"]'),
(7, 1, 'Descanso III', '2023-01-01', 'Cianotípia sobre papel', 100, 70, NULL, '[\"666493ff48691.jpg\"]'),
(8, 1, 'Descanso IIII', '2023-01-01', 'Cianotípia sobre papel', 100, 70, NULL, '[\"6664941049ecf.jpg\"]'),
(9, 1, 'Cabeza III', '2023-01-01', 'Cianotípia sobre papel', 42, 59.4, NULL, '[\"6664942a6beb2.jpg\"]'),
(10, 2, 'Camarón', '2021-01-01', 'Tinta china y gouache sobre papel', 47, 72, NULL, '[\"6664964230d58.jpg\",\"6664964231507.jpg\"]'),
(11, 2, 'Gata Cattana', '2021-01-01', 'Tinta china y gouache sobre papel', 47, 72, NULL, '[\"6664966d83455.jpg\",\"6664966d83b3e.jpg\"]'),
(12, 2, 'Blas Infante', '2021-01-01', 'Tinta china y gouache sobre papel', 47, 72, NULL, '[\"6664968843f10.jpg\",\"66649688445d4.jpg\"]'),
(13, 2, 'Lola Flores', '2021-01-01', 'Tinta china y gouache sobre papel', 47, 72, NULL, '[\"6664969f2ea4d.jpg\",\"6664969f2f0eb.jpg\"]'),
(14, 2, 'Picasso', '2021-01-01', 'Tinta china y gouache sobre papel', 47, 72, NULL, '[\"666496b71fd70.jpg\",\"666496b72044f.jpg\"]'),
(15, 2, 'Paco de Lucía', '2021-01-01', 'Tinta china y gouache sobre papel', 47, 72, NULL, '[\"666496e3ea25f.jpg\",\"666496e3ea8ac.jpg\"]'),
(16, 2, 'Rocío Jurado', '2021-01-01', 'Tinta china y gouache sobre papel', 47, 72, NULL, '[\"66649732e6c3a.jpg\",\"66649732e75de.jpg\"]'),
(17, 2, 'Juan Ramón Jiménez', '2021-01-01', 'Tinta china y gouache sobre papel', 47, 72, NULL, '[\"666497786f06d.jpg\",\"666497786f819.jpg\"]'),
(18, 2, 'Lorca', '2021-01-01', 'Tinta china y gouache sobre papel', 47, 72, NULL, '[\"666497982c259.jpg\"]'),
(19, 2, 'Velazquez', '2021-01-01', 'Tinta china y gouache sobre papel', 47, 72, NULL, '[\"666497ae4efed.jpg\"]'),
(20, 3, 'Autorretrato', '2022-01-01', 'Óleo sobre lienzo', 55, 46, NULL, '[\"6664984b61cec.jpg\"]'),
(24, 3, NULL, NULL, NULL, NULL, NULL, NULL, '[\"66649ab721a95.jpg\",\"66649ab7221bc.jpg\",\"66649ab7225a1.jpg\"]'),
(25, 4, 'Jaula frágil', '2024-01-01', 'Escayola', 104, 75, NULL, '[\"66649bab18e4a.jpg\"]'),
(29, 4, 'CarruselPortada', NULL, NULL, NULL, NULL, NULL, '[\"6664af62e430b.jpg\",\"6664af62e4abb.jpg\",\"6664af62e4e8e.jpg\",\"6664af62e524f.jpg\",\"6664af62e558e.jpg\",\"6664af62e590e.jpg\",\"6664af62e5c36.jpg\",\"6664af62e5f99.jpg\"]'),
(30, 4, 'Piel rota', '2024-01-01', 'Tela e hilo', 156, 140, NULL, '[\"6664b0410805f.jpg\"]'),
(31, 4, 'Detalle', NULL, NULL, NULL, NULL, NULL, '[\"6664b63a342a5.jpg\",\"6664b63a349ca.jpg\",\"6664b63a34d91.jpg\",\"6664b63a35180.jpg\",\"6664b63a354a4.jpg\"]'),
(32, 4, 'Rotura I', '2024-01-01', 'Grafito sobre papel', 42, 29.7, NULL, '[\"6664b7e618594.jpg\"]'),
(33, 4, 'Rotura II', '2024-01-01', 'Grafito sobre papel', 42, 29.7, NULL, '[\"6664b7fcb2c3a.jpg\"]'),
(34, 4, 'Rotura III', '2024-01-01', 'Grafito sobre papel', 42, 29.7, NULL, '[\"6664b8128eeb5.jpg\"]'),
(35, 4, 'Rotura IV', '2024-01-01', 'Grafito sobre papel', 42, 29.7, NULL, '[\"6664b834f3292.jpg\"]'),
(36, 5, NULL, '2024-01-01', 'Cinta', 647, 507, NULL, '[\"6664ba5b4ffe6.jpg\",\"6664ba5b5065c.jpg\"]'),
(38, 5, NULL, '2024-01-01', 'Betadine y escayola', 40, 54, 12, '[\"6664bae9565f7.jpg\"]'),
(39, 5, NULL, '2024-01-01', 'Betadine y escayola', 28, 30, 12, '[\"6664bc156a2d0.jpg\"]'),
(40, 5, NULL, '2024-01-01', 'Madera, clavos, tornillos y grapas', 237, 110, 15, '[\"6664bc512bb3d.jpg\"]'),
(41, 5, NULL, '2024-01-01', 'Madera, sal, tornillos e hilo', 39, 59, 12, '[\"6664bc7f403e2.jpg\"]'),
(42, 5, NULL, '2024-01-01', 'Madera, hierro, óxido, plastilina, cinta y yeso', 59, 37, 20, '[\"6664bca669588.jpg\"]'),
(43, 5, NULL, '2024-01-01', 'Tela', 175, 136, 36, '[\"6664bcc1dd3a6.jpg\"]'),
(44, 6, 'Cuna', '2024-01-01', 'Papel, aceite y madera', 240, 100, NULL, '[]'),
(48, 3, 'CarruselPortada', NULL, NULL, NULL, NULL, NULL, '[\"6669b283082d6.jpg\",\"6669b28308a61.jpg\",\"6669b28308e7a.jpg\"]');

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
  `roles` longtext NOT NULL COMMENT '(DC2Type:json)'
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
(1, 'Oasis', 'Ramifico mis pensamientos intrusivos a la velocidad de la luz, al igual que una célula cancerosa por el cuerpo, esas ideas atraviesan toda mi cabeza. Me siento perseguida por mi misma en una carrera que no acaba.\r\nLo que más me sirve para callar mi cabeza es tumbarme al sol, su calor recorre todo mi cuerpo, sintiéndome como si estuviera en una incubadora. Cuando ya me siento mejor, cuando ya hay silencio, abro los ojos y veo todo azul a causa del sol.\r\n\r\nPor este color, que me ha acompañado en tantos momentos de autorregulación emocional, elegí la cianotipia como material para trabajar. Es una mezcla de citrato férrico amoniacal y ferricianuro prosaico.\r\n\r\nAl hacer las primeras pruebas con el material me sentí identificada con él. Cuando se hace la mezcla de estas dos sustancias tóxicas, se crea un color verde radiactivo, ácido y agresivo. Cuando el líquido ya está seco en el soporte es hora de sacarlo al sol, rápidamente me pongo encima de él, aplasto todo mi cuerpo mi cuerpo sobre el papel, y a la vez contra el suelo . Poco a poco su tono cambia de un azul tenue a uno más intenso, pero aún sigue sucio. No es hasta que lo baño en agua oxigenada, cuando se ven los colores de la cianotipia. Ahí es cuando abro los ojos y veo el mundo de una tonalidad azul apacible.', 'Cianotípia', 'oasis-portada-6664932d0012d.jpg'),
(2, 'Andalucía', 'Este proyecto consta de diez retratos de artistas andaluces, hechos con un falso grabado, y otros diez dibujos, que representan lo que me inspiran esos artistas y el sitio donde nacieron, haciendo así un “tour” por toda Andalucía. Por lo que, en este proyecto no me he inspirado en un artista en concreto sino en cada bailaora, cantao’, poeta o pintor andaluz. Por lo que cada retrato va de la mano con su respectiva ilustración en la que se describe visualmente al artista y la pureza de su ciudad natal.\r\n\r\nEn este proyecto quiero contar el amor que tenemos los andaluces por nuestro hogar, costumbres y raíces. Por ello he escogido retratar a Lola flores, una jerezana y representación de todas las bailaoras y cantaoras, ellas difundieron un mensaje que iba más allá de las palabras y que representó en sus orígenes el lamento del pueblo gitano y morisco. Por otra parte, hay retratos de folclóricas como Rocío Jurado, la piedra más dura de Chipiona a ella ningún hombre le hizo sombra y artísticamente era una grandísima creadora. También tenemos a Gata Cattana, una Cordobesa, poetisa, rapera y politóloga , la representa sus letras cargados con mensajes feministas y contra la andaluzofobia. No nos puede faltar, el retrato de Blas Infante, poeta y político que luchó, y consiguió la independencia de Andalucía, su bandera y su himno. Para terminar nombraremos a los artistas andaluces más reconocidos como Lorca, Camarón, Juan Ramón Jimenez, Paco de Lucia, Picasso o Velazquez.\r\n\r\nEste trabajo, a parte de ser un listado de los grandes artistas andaluces, también es una queja a la a la andaluzofobia y a las típicas ideas que se tiene de los andaluces, en Andalucía se aprende, se vive y sobre todo se lucha.', 'Falso grabado', 'andalucia-portada-66649573aa8ff.jpg'),
(3, 'Autorretrato', NULL, 'Cuadro único', 'autorretrato-portada-6664982e5a571.jpg'),
(4, 'Jaula frágil', 'Partí de la idea de la feminidad. Quise, en un primer momento, describir este término a nivel social. No llegué a nada claro, así que acoté el rango y decidí hablar de que era la feminidad para mí. Escribí en relación. Mi concepto de lo femenino, pero cada frase que escribía la terminaba tachando. Entre en un bucle intenso donde buscaba las palabras concretas para poder captaresa idea. Al final me di por vencida, no encontré las palabras. No me daba cuenta que no podía escribir las palabras correctas cuando no las hay. No se pueden buscar palabras que no existen. Seguramente, si yo me siento mujer es porque me han educado para ser una.\r\n\r\nEn ese bucle en el que entré, en el momento me incomodaba, pero ahora veo un gran tema donde indagar. Esa es una de las primeras ideas, ese bucle y la tensión que me generó.\r\nPor otra parte veo necesario tratar el género.Tanto lo femenino como lo masculino son construcciones sociales, esa idea la tenía clara, de ahí venían mis contradicciones mentales al querer tratar en un inicio la “feminidad”. Se nos asigna un género al nacer, normalmente a partir de nuestro sexo. Luego, según este, se nos educa de una u otra manera, creando roles discriminatorios y etiquetas que nos encierran en algo que, realmente, no existe.\r\nEl género es la idea primaria del proyecto, pero otra muy importante es la de encierro. Aunque me quiera salir de la “jaula” género femenino, me metería en otra ya sea de no fluido o de trans masculino. Aquí se repite ese bucle que es necesario romper.\r\n\r\nBourdieu habla sobre el habitús. El habitus es como nuestra forma de ser que aprendemos de la sociedad. Son las cosas que hacemos y pensamos porque así nos han enseñado desde pequeños. Nuestra mente y cuerpo se acostumbran a estas formas de actuar y pensar. Aunque parece que nacemos con ello, en realidad lo aprendemos de cómo la sociedad funciona. Se refiere a lo que aprendemos y queda con nosotros por mucho tiempo. El género obviamente está muy implicado en este término.\r\nPara mi, contra más conscientes seamos del habitus, de los roles de género y del mal de estos, más fácil se nos hará salir de esas construcciones. Pudiendo así movernos con más libertad.', 'Escultura, arte textil y cuerpo.', 'jaula-fragil-portada-66649c2bc24ee.jpg'),
(5, 'Un intento más', 'Arreglar algo roto, algo que está tan destruido, derrumbado y en la ruina que es completamente inútil e inservible. Pero haces todo lo que esté en tu mano para, por lo\r\nmenos, intentar repararlo. ¿Por qué esa fijación por desear curar lo incurable? ¿Por qué querer tanto arreglar aquello que está obviamente destrozado, poniendo tanto de ti que llegue hasta herirte? Yo lo veo como un acto melancólico, un deseo a que todo esté como antes, como antes de que se rompiera.Y que, con gestos de de mimo, cuidado y ternura, pueda llegar a estar como nuevo, pero eso nunca sucede. \r\n\r\nSe juntan ideas contrarias, lo irreparable y la reparación, creando así piezas utópicas en las que se refleja la angustia del querer y no poder. El modo de trabajo acompaña totalmente a esta acción o intento descontrolado de reparar. Se crean piezas a través de la basura pero primero estas pasan por un filtro humano(el mío). Cuando la recojo siento que dejan de estar abandonadas, pienso en ella, la atiendo, la cuido, intento ver lo que necesita para que vuelva a ser algo más que basura. Intento que sean válidas, útiles, reformadas, pero mis intentos quedan en nada, sigue siendo basura.\r\nEl resultado son unas piezas que, aunque, son de materiales duros como la madera o la escayola, dan la sensación de fragilidad.Se ha creado así una atmósfera cálida en la que, evoca a las ruinas y los escombros pero a la vez a la carnalidad de una herida que se está curando lentamente.\r\n\r\nEn el mundo ya hay suficiente dolor. Prácticamente todos los días escuchamos que se ha iniciado una nueva guerra, un nuevo asesinato, una nueva injusticia. Hay tanto\r\ndolor que se está resquebrajando todo, empeorando la situación a cada día que pasa. Sumando, que vivimos en una sociedad que nos exige la rapidez continua, en la\r\nque ni siquiera podemos pararnos a pensar que está pasando realmente. Y mucho menos podemos pararnos a intentar arreglar lo que está ocurriendo.\r\nPersonalmente, cuando me entero de algunas de las desgracias que rompen el mundo un poco más, me atropella un sentimiento de impotencia. ¿Y yo que puedo hacer\r\npara solucionarlo? Normalmente me enfado porque no puedo arreglar nada, la solución no está en mi mano, así que prefiero mirar a otro lado, esperar que alguien lo\r\nsolucione.\r\n\r\nEste proyecto nace de esta frustración. Decido arreglar, curar, mimar, reparar con ternura lo que necesite de mi ayuda.\r\nCreo pequeñas intervenciones, piezas objetuales, dibujo y esculturas que giran en torno a este tema. Un tema que se ramifica desembocando en otros en forma de eco o resuene. Creo una conjunto de piezas cálidas que desembocan en lo humano, aunque el material no sea muy cárnico, como por ejemplo la cinta es plástica y fría pero se hacen arrugas que llegan a parecer piel.\r\n\r\nOlga Tokarczuk, en su escrito El narrador tierno habla de la importancia de la ternura y el mimo, como no podré escribirlo mejor que ella dejo aquí un pedacito de su\r\ntexto: “La ternura es la forma más modesta de amor. Es el tipo de amor que no aparece en las Escrituras o en los evangelios, nadie lo jura, nadie lo cita. No tiene\r\nemblemas o símbolos especiales, ni conduce a la delincuencia ni a la envidia inmediata.\r\nAparece donde miramos de cerca y con cuidado a otro ser, a algo que no es nuestro «yo».\r\nLa ternura es espontánea y desinteresada; va mucho más allá del sentimiento de empatía. En cambio, es el compartir consciente, aunque quizás un poco melancólico,\r\ndel destino común. La ternura es una profunda preocupación emocional por otro ser, su fragilidad, su naturaleza única y su falta de inmunidad al sufrimiento y los efectos\r\ndel tiempo. La ternura percibe los lazos que nos conectan, las similitudes y la similitud entre nosotros. Es una forma de mirar que muestra al mundo como vivo,\r\ninterconectado, cooperando y codependiente de sí mismo.”\r\nMe gusta pensar que con este cuidado al prójimo, en mi caso al objeto que “salvo” del olvido. Con ese tiempo que dedico en cuidar, mimar, reparo y rescato también me\r\nestoy rescatando a mi .', 'Objeto e instalación', 'un-intento-mas-portada-6664ba9a50687.jpg'),
(6, 'Cuna', 'Es curioso que una sombra por más dura o difusa que sea siempre nos dice que justo ahí está corriendo algo, que algo está presente. Podemos estar mirando al suelo, ver una sombra, mirar para arriba y sorprendernos con un árbol. Las sombras caminan, se mueven, dan la vuelta o simplemente están quietas en su sitio y es el contacto de la Tierra con el Sol las que las cambia. Hay veces en las que estamos rodeados de sombras, y donde ser capaces de ver el árbol es realmente complicado. Lo que ocurre es que aún así, mirando el suelo, me puedo imaginar que allí arriba se encuentra un árbol. Un árbol que desde su altura también me está mirando a mí y aunque yo solo vea su sombra, lo importante es que los dos nos estamos mirando. Y que los dos sabemos que estamos ahí.\r\n\r\nHay veces que ver es complicado, o más que complicado, incierto. Sobre todo cuando no sabemos muy bien qué está pasando. Si en algún momento miras a tu alrededor, y no ves nada, recuerda que en algún sitio estará la sombra de la hoja de un árbol dando vueltas por ahí. Sin dejar de moverse.', 'Objeto y performance', 'cuna-portada-6664bd4bc2b1e.jpg');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indices de la tabla `illustration`
--
ALTER TABLE `illustration`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title_UNIQUE` (`title`);

--
-- Indices de la tabla `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_order_user_idx` (`user_id`) USING BTREE;

--
-- Indices de la tabla `order_has_illustration`
--
ALTER TABLE `order_has_illustration`
  ADD KEY `fk_table1_illustration1_idx` (`illustration_id`),
  ADD KEY `fk_table1_order1_idx` (`order_id`) USING BTREE;

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
  ADD KEY `IDX_44CA0B23BB3453DB` (`work_id`);

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
-- AUTO_INCREMENT de la tabla `illustration`
--
ALTER TABLE `illustration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `work`
--
ALTER TABLE `work`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `fk_weborder_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `order_has_illustration`
--
ALTER TABLE `order_has_illustration`
  ADD CONSTRAINT `fk_table1_illustration1` FOREIGN KEY (`illustration_id`) REFERENCES `illustration` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_table1_weborder1` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `piece`
--
ALTER TABLE `piece`
  ADD CONSTRAINT `FK_44CA0B23BB3453DB` FOREIGN KEY (`work_id`) REFERENCES `work` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
