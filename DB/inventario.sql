-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 30-05-2023 a las 03:31:51
-- Versión del servidor: 8.0.28
-- Versión de PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `inventario`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `categoria_id` int NOT NULL,
  `categoria_nombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `categoria_ubicacion` varchar(150) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`categoria_id`, `categoria_nombre`, `categoria_ubicacion`) VALUES
(1, 'Refrescos', 'Nevera 1 Coca cola'),
(2, 'Sabritas', 'Pasillo puerta'),
(3, 'Enlatados', 'pasillo 8'),
(4, 'Aseo personal', 'pasillo 10'),
(5, 'Galletas', 'Pasillo 2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `producto_id` int NOT NULL,
  `producto_codigo` varchar(70) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `producto_nombre` varchar(70) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `producto_precio` decimal(30,2) NOT NULL,
  `producto_stock` int NOT NULL,
  `producto_foto` varchar(500) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `categoria_id` int NOT NULL,
  `usuario_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`producto_id`, `producto_codigo`, `producto_nombre`, `producto_precio`, `producto_stock`, `producto_foto`, `categoria_id`, `usuario_id`) VALUES
(1, '20202229020', 'Coca Cola 3 litros No retornable', 48.00, 15, 'Coca_Cola_3_litros_No_retornable_67.jpg', 1, 1),
(2, '0947892467', 'Ruffles queso 120 g', 17.00, 10, 'Ruffles_queso_120_g_89.jpg', 2, 1),
(3, '1345236542', 'Cheetos torciditos', 17.00, 10, 'Cheetos_79.jpg', 2, 1),
(4, '1094567894', 'Pepsi lata 440 ml', 16.00, 10, 'Pepsi_1_5_litros_63.png', 1, 1),
(5, '2738449123809812', 'Coca Cola Lata', 18.00, 10, 'Coca_Cola_Lata_17.png', 1, 1),
(6, '393204990', 'Jabon corporal de barra', 19.00, 25, 'Jabón_corporal_53.jpg', 4, 1),
(7, '2357892321', 'Cepillos de dientes', 21.00, 35, 'Cepillos_de_dientes_74.png', 4, 1),
(8, '4536980654', 'Doritos nacho 65 g', 15.00, 13, 'Doritos_nacho_65_g_62.png', 2, 1),
(9, '8769567843', 'Frijol bayos refritos 455 g', 18.00, 15, 'Frijol_bayos_refritos_455_g_12.png', 3, 1),
(10, '6453897634', 'Atun', 15.00, 15, 'Atún_Ancla_0.png', 3, 1),
(11, '9840874365', 'Granos de elotes HERDEZ', 16.00, 16, 'Granos_de_elotes_HERDEZ_8.jpg', 3, 1),
(12, '4657932765', 'Shampoo 850 ml', 35.00, 15, 'Shampoo_850_ml_99.png', 4, 1),
(13, '5797547907', 'Galletas Chokis', 16.00, 10, 'Galletas_Chokis_26.png', 5, 1),
(14, '7653908646', 'Galletas Polvorones', 16.00, 10, 'Galletas_Polvorones_14.png', 5, 1),
(15, '2447990578', 'Galleta Giro', 16.00, 10, 'Galleta_Giro_97.png', 5, 1),
(16, '27194917492', 'Galleta Oreo', 16.00, 10, 'Galleta_Oreo_50.png', 5, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `usuario_id` int NOT NULL,
  `usuario_nombre` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `usuario_apellido` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `usuario_usuario` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `usuario_clave` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `usuario_email` varchar(70) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`usuario_id`, `usuario_nombre`, `usuario_apellido`, `usuario_usuario`, `usuario_clave`, `usuario_email`) VALUES
(1, 'Administrador', 'Principal', 'Administrador', '$2y$10$EPY9LSLOFLDDBriuJICmFOqmZdnDXxLJG8YFbog5LcExp77DBQvgC', ''),
(3, 'Jorge', 'Chi', 'Admin1', '$2y$10$OzJoo9uof5p59ncrHss.vO8MqY7NllePr3ZiSq75k.fsa64eLZLH.', 'jorgeluischichable48@gmail.com'),
(4, 'Jannet', 'Sarmiento Guzmán', 'Admin2', '$2y$10$v7DgnARtFflo6H7/4UwHheRmN3N.0wzL5GFkqStfqrUPKcyWPTT7W', 'sarmientojannet81@gmail.com'),
(5, 'Mew', 'Suppasit', 'Mew3702', '$2y$10$tOU9NV7AvNNFpE1WQirlS.5i.n5gko59a/Tq6i5Vd6CxeipXZH.lO', 'l20830113@china.tecnm.mx');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`categoria_id`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`producto_id`),
  ADD KEY `categoria_id` (`categoria_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usuario_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `categoria_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `producto_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usuario_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`categoria_id`),
  ADD CONSTRAINT `producto_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`usuario_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
