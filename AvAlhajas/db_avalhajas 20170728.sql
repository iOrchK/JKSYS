-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-07-2017 a las 21:10:17
-- Versión del servidor: 10.1.19-MariaDB
-- Versión de PHP: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_avalhajas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados_fisicos`
--

CREATE TABLE `estados_fisicos` (
  `id_estado_fisico` int(11) NOT NULL,
  `descripcion` varchar(30) NOT NULL,
  `caracteristicas` varchar(100) NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `estados_fisicos`
--

INSERT INTO `estados_fisicos` (`id_estado_fisico`, `descripcion`, `caracteristicas`, `estado`) VALUES
(1, 'Prenda(s) Nueva(s)', 'Prendas integras, prendas de moda.', 1),
(2, 'Retaceria', 'Prendas rotas, quebradas, incompletas, pasadas de moda.', 1),
(3, 'Lote', 'Conjunto de varias prendas y/o retaceria.', 0),
(4, 'Prenda(s) Seminueva(s)', 'Prendas usadas, con detalles de estetica. ', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `metales`
--

CREATE TABLE `metales` (
  `id_metal` int(11) NOT NULL,
  `descripcion` varchar(30) NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `metales`
--

INSERT INTO `metales` (`id_metal`, `descripcion`, `estado`) VALUES
(1, 'Oro 8K (Muy Bajo)', 0),
(2, 'Oro 10K Rojo', 1),
(3, 'Oro 10K Amarillo', 1),
(4, 'Oro 14K (Bueno)', 1),
(5, 'Oro 18K (Fino)', 1),
(6, 'Oro 24K (Puro)', 1),
(7, 'Plata 720 (Muy baja)', 0),
(8, 'Plata 900 (Baja)', 0),
(9, 'Plata 925 (Esterlina)', 1),
(10, 'Plata 999 (Pura)', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `valuaciones`
--

CREATE TABLE `valuaciones` (
  `id_valuacion` int(11) NOT NULL,
  `id_metal` int(11) NOT NULL,
  `id_estado_fisico` int(11) NOT NULL,
  `valor_comercial` int(6) NOT NULL,
  `valor_empeno` int(6) NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `valuaciones`
--

INSERT INTO `valuaciones` (`id_valuacion`, `id_metal`, `id_estado_fisico`, `valor_comercial`, `valor_empeno`, `estado`) VALUES
(1, 2, 1, 450, 200, 1),
(2, 2, 2, 230, 180, 1),
(3, 3, 1, 550, 250, 1),
(4, 3, 2, 250, 200, 1),
(5, 4, 1, 600, 300, 1),
(6, 4, 2, 280, 230, 1),
(7, 5, 1, 700, 350, 1),
(8, 5, 2, 300, 250, 1),
(9, 6, 1, 720, 400, 1),
(10, 6, 2, 350, 300, 1),
(11, 9, 1, 70, 15, 1),
(12, 9, 2, 15, 5, 1),
(13, 10, 1, 15, 9, 1),
(14, 10, 2, 10, 5, 1),
(15, 2, 4, 400, 200, 1),
(16, 3, 4, 500, 250, 1),
(17, 4, 4, 550, 280, 1),
(18, 5, 4, 650, 350, 1),
(19, 6, 4, 680, 350, 1),
(20, 9, 4, 30, 10, 1),
(21, 10, 4, 10, 5, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `estados_fisicos`
--
ALTER TABLE `estados_fisicos`
  ADD PRIMARY KEY (`id_estado_fisico`);

--
-- Indices de la tabla `metales`
--
ALTER TABLE `metales`
  ADD PRIMARY KEY (`id_metal`);

--
-- Indices de la tabla `valuaciones`
--
ALTER TABLE `valuaciones`
  ADD PRIMARY KEY (`id_valuacion`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `estados_fisicos`
--
ALTER TABLE `estados_fisicos`
  MODIFY `id_estado_fisico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `metales`
--
ALTER TABLE `metales`
  MODIFY `id_metal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `valuaciones`
--
ALTER TABLE `valuaciones`
  MODIFY `id_valuacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
