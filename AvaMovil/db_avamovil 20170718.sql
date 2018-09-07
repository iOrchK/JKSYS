-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-07-2017 a las 19:23:15
-- Versión del servidor: 10.1.19-MariaDB
-- Versión de PHP: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_avamovil`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `accesorios_incluidos`
--

CREATE TABLE `accesorios_incluidos` (
  `id_accesorios` int(11) NOT NULL,
  `descripcion` varchar(15) NOT NULL,
  `caracteristicas` varchar(100) NOT NULL,
  `estado` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `accesorios_incluidos`
--

INSERT INTO `accesorios_incluidos` (`id_accesorios`, `descripcion`, `caracteristicas`, `estado`) VALUES
(1, 'Completos', 'Tiene Caja, Cargador, Cable USB y Audifonos (opcional)', 1),
(2, 'Incompletos', 'Falta Caja y/o Cargador y/o Cable USB', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `devaluacion_antiguedad`
--

CREATE TABLE `devaluacion_antiguedad` (
  `id_devaluacion_antiguedad` int(11) NOT NULL,
  `descripcion` varchar(10) NOT NULL,
  `porcentaje` float NOT NULL,
  `estado` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `devaluacion_antiguedad`
--

INSERT INTO `devaluacion_antiguedad` (`id_devaluacion_antiguedad`, `descripcion`, `porcentaje`, `estado`) VALUES
(1, '70%', 0.8, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `devaluacion_estado`
--

CREATE TABLE `devaluacion_estado` (
  `id_devaluacion_estado` int(11) NOT NULL,
  `descripcion` varchar(4) NOT NULL,
  `porcentaje` float NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `devaluacion_estado`
--

INSERT INTO `devaluacion_estado` (`id_devaluacion_estado`, `descripcion`, `porcentaje`, `estado`) VALUES
(1, '75%', 0.75, 1),
(2, '60%', 0.625, 1),
(3, '60%', 0.625, 1),
(4, '50%', 0.5, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados_fisicos`
--

CREATE TABLE `estados_fisicos` (
  `id_estado_fisico` int(11) NOT NULL,
  `descripcion` varchar(15) NOT NULL,
  `caracteristicas` varchar(100) NOT NULL,
  `estado` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `estados_fisicos`
--

INSERT INTO `estados_fisicos` (`id_estado_fisico`, `descripcion`, `caracteristicas`, `estado`) VALUES
(1, 'Nuevo', 'Empaque sellado o Recien Abierto, Equipo Impecable, Sin Fallas Fisicas.', 1),
(2, 'Seminuevo', 'Empaque sin sello, Sin Fallas Fisicas, Lijeros Desgastes y/o golpes en el Dispositivo.', 1),
(3, 'Deteriorado', 'Desgastes y/o roturas graves, Fallas Fisicas en el Dispositivo.', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `moviles`
--

CREATE TABLE `moviles` (
  `id_movil` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `year` int(4) NOT NULL,
  `precio_nuevo` int(5) NOT NULL,
  `estado` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `moviles`
--

INSERT INTO `moviles` (`id_movil`, `descripcion`, `year`, `precio_nuevo`, `estado`) VALUES
(1, 'Celular Sony Xperia XZ (F8332): Audio Estero HD, Lector de Huellas, USB-C, Android 7, Mem. Int. 32 GB, Max. Micro SD 256 GB, RAM 3 GB, Cam. Front. 13 MP, Cam. Post. 23 MP.', 2017, 15909, 1),
(2, 'Celular LG Magna (H500): Android 5, Mem. Int. 8 GB, RAM 1 GB, Max. Micro SD 32 GB, Cam. Front. 5 MP, Cam. Post. 8 MP, Micro USB 2.0.', 2015, 2500, 1),
(3, 'Celular Samsung Galaxy Grand Prime+ (Prime Plus, J2 Prime, SM-G532): Android 6, Mem. Int. 8 GB, RAM 1.5 GB, Max. Micro SD 256 GB, Cam. Front 5 MP, Cam Post. 8 MP, Micro USB 2.0.', 2016, 3500, 1),
(4, 'Celular ZTE Blade V6 Max (A610): Android 5, Mem. Int. 16 GB, RAM 2 GB, Max. Micro SD 32 GB, Cam. Front. 5 MP, Cam. Post. 13 MP, Micro USB 2.0.', 2015, 3000, 1),
(5, 'Celular ZTE Blade V7: Android 6, Mem. Int. 16 GB, RAM 2 GB, Max. Micro SD 128 GB, Cam. Front. 5 MP, Cam. Post. 13 MP, Micro USB 2.0.', 2016, 3900, 1),
(6, 'Celular Sony Xperia X Compact (F5321): Android 6, Mem. Int. 32 GB, RAM 3 GB, Max. Micro SD 256 GB, Cam. Front. 5 MP, Cam. Post, 23 MP, USB-C.', 2016, 5800, 1),
(7, 'Celular LG G6: Android 7, Mem. Int. 32/64 GB, RAM 3 GB, Max. Micro SD 2 TB, Cam. Front. 5 MP, Cam. Post. 13 MP Dual, USB-C.', 2016, 10000, 1),
(8, 'Celular Huawei Mate 9 (MHA-L09): Android 7, Mem. Int. 64 GB, RAM 4 GB, Max. Micro SD 256 GB, Cam. Front. 8 MP, Cam. Post. 12MP + 20MP Dual, USB-C.', 2016, 9700, 1),
(9, 'Celular Huawei P9 (EVA-L09): Android 6, Mem. Int. 32/64 GB, RAM 2/3 GB, Max. Micro SD 28 GB, Cam. Front. 8 MP, Cam. Post. 12 MP Dual, USB-C.', 2016, 13500, 1),
(10, 'Celular Lanix Ilium L200: Android 5, Mem. Int. 16/32 GB, Max. Micro SD 32 GB, RAM 2 GB, Cam. Front. 5 MP, Cam. Post. 13 MP, Micro USB 2.0.', 2016, 4100, 1),
(11, 'Celular Alcatel Idol 4 (6055BVR): Android 6, Mem. Int. 16 GB, RAM 3 GB, Max. Micro SD 512 GB, Cam. Front. 8 MP, Cam. Post. 13 MP, Micro USB 2.0.', 2016, 5500, 1),
(12, 'Celular HTC One 9: Android 6, Mem. Int. 16/32 GB, RAM 2 GB, Max. Micro SD 1 TB, Cam. Front. 4 MP, Cam. Post. 13 MP, Micro USB 2.0.', 2015, 11900, 1),
(13, 'Celular Samsung Galaxy S8 (SM-G950F): Android 7, Lector de Huellas, Lector de Iris, Sensor de Ritmo Cardiaco, Mem. Int. 64 GB, RAM 4 GB, Max. Micro SD 256 GB, Cam. Front. 8 MP, Cam. Post. 12 MP Dual, USB-C. ', 2017, 17299, 1),
(14, 'Celular LG V20 (H990T): Android 7, Mem. Int. 64 GB, RAM 4 GB, Max. Micro SD 1 TB, Cam. Front. 5 MP, Cam. Post. 16 MP+8MP Dual, USB-C.', 2016, 17300, 1),
(15, 'Celular LG K10 (M250H): Android 5, Mem. Int. 8/16 GB, RAM 1/1.5/2 GB, Max. Micro SD 32 GB, Cam. Front. 5 MP, Cam. Post. 13 MP, Micro USB 2.0.', 2016, 4300, 1),
(16, 'Celular M4Tel Dream (SS4452): Android 5, Mem. Int. 8 GB, RAM 1 GB, Max. Micro SD 128 GB, Cam. Front. 5 MP, Cam. Post. 8 MP, Micro USB 2.0.', 2016, 2300, 1),
(17, 'Celular Samsung Galaxy A5 2017 (SM-A520F): Android 6, Lector de Huellas, Resistencia al Agua, Mem. Int. 32 GB, RAM 3 GB, Max. Micro SD 512 GB, Cam. Front. 16 MP, Cam. Post 16 MP, USB-C.', 2017, 9000, 1),
(18, 'iPhone 6s Plus (A1688) 16 GB: Siri, iOS 10,  Mem. Int. 16-128 GB, No Mem. Ext., Cam. Front. 5 MP, Cam. Post. 12 MP, USB Lightning.', 2015, 11800, 1),
(19, 'iPhone 6s Plus (A1687) 32 GB: Siri, iOS 10,  Mem. Int. 16-128 GB, No Mem. Ext., Cam. Front. 5 MP, Cam. Post. 12 MP, USB Lightning.', 2015, 13600, 1),
(20, 'iPhone 5s (A1533) 16 GB: iOS 7, Siri, Mem. Int. 8-64 GB, RAM 1 GB, No Mem. Ext., Cam. Front. 1.2 MP, Cam. Post. 8 MP, USB Lightning.', 2013, 6000, 1),
(21, 'iPhone 6 Plus (A1549) 16 GB: iOS 10, Siri, Mem. Int. 16-128 GB, RAM 1 GB, No Mem. Ext., Cam. Front. 1.3 MP, Cam. Post. 8 MP, USB Lightning.', 2014, 15000, 1),
(22, 'iPhone 7 Plus (A1661) 32 GB: iOS 10, Siri, Mem. Int.32-256 GB, RAM 2 GB, No Mem. Ext., Cam. Front. 7 MP, Cam. Post. 13 MP Dual, USB Lightning.', 2016, 19000, 1),
(23, 'Celular Sony Xperia XA (F3113): Android 6, Carga Rapida, Mem. Int.16 GB, RAM 2 GB, Max. Micro SD , Cam. Front. 8 MP, Cam. Post. 13 MP, USB-C.', 2016, 6800, 1),
(24, 'Celular LG V10 (H960P): Android 5, Lector de Huellas, Carga RÃ¡pida, Mem. Int. 32/64 GB, RAM 4 GB, Max. Micro SD 2 TB, Cam. Front. 5 MP, Cam. Post. 16 MP, Micro USB 2.0.', 2015, 18900, 1),
(25, 'Celular Sony Xperia E3 (F3313): Android 6, Mem. Int. 16 GB, RAM 1.5 GB, Max. Micro SD 128 GB, Cam. Front. 5 MP, Cam. Post. 13 MP, Micro USB 2.0.', 2016, 4000, 1),
(26, 'Celular Lenovo Motorola Moto G5 Plus (XT1680): Android 7, Lector de Huellas, Carga RÃ¡pida, ProtecciÃ³n Contra Salpicaduras, Mem. Int. 32 GB, RAM 3 GB, Max. Micro SD 128 GB, Cam. Front. 5 MP, Cam. Post. 12 MP, Micro USB.', 2017, 6500, 1),
(27, 'Celular Motorola Moto E2 2015 (XT1511): Android 5, Mem. Int. 8 GB , RAM 1 GB, Max. Micro SD 32 GB, Cam. Front. 0.3 MP, Cam. Post. 5 MP, Micro USB.', 2015, 1500, 1),
(28, 'Celular Samsung Galaxy J7 2016 (SM-J700M): Android 6, Mem. Int. 16 GB, RAM 2 GB, Max. Micro SD 128 GB, Cam. Front. 5 MP, Cam. Post. 13 MP, Micro USB 2.0.', 2016, 5000, 1),
(29, 'Celular Alcatel Pop 4+ (4 Plus, 5056A): Android 6, Mem. Int. 16 GB, RAM 1.5 GB, Max. Micro SD 32 GB, Cam. Front. 5 MP, Cam. Post. 8 MP, Micro USB 2.0.', 2016, 3000, 1),
(30, 'Celular Samsung Galaxy S7 Edge (SM-G935F): Android 6, Lector de Huellas, Carga RÃ¡pida, Carga InalÃ¡mbrica, , Mem. Int. 32/64 GB, RAM 4 GB, Max. Micro SD 128 GB, Cam. Front. 5 MP, Cam. Post. 12 MP, Micro USB 2.0.', 2016, 15300, 1),
(31, 'Tablet Lenovo Tab2 (A710): Android 5, Mem. Int. 8 GB, RAM 1 GB, Max. Micro SD 32 GB, Cam. Front. 0.3 MP, No Cam. Post., Micro USB 2.0.', 2015, 1750, 1),
(32, 'Celular LG Q6 (X220G): Android 5, Mem. Int. 8 GB, RAM 1 GB, Max. Micro SD 32 GB, Cam. Front. 2 MP, Cam. Post. 5 MP, Micro USB.', 2016, 2700, 1),
(33, 'Celular Lenovo Motorola Moto G5 (XT1671): Android 7, Lector de Huellas, ProtecciÃ³n Contra Salpicaduras, Carga RÃ¡pida, Mem. Int. 16 GB, RAM 3 GB, Max. Micro SD 128 GB, Cam. Front. Cam. Front. 5 MP MP, Cam. Post. Cam. Post. 13 MP MP, Micro USB.', 2017, 5000, 1),
(34, 'Celular ZTE Blade V7 Lite: Android 6, Mem. Int. 16 GB, RAM 2 GB, Max. Micro SD 128 GB, Cam. Front. 8 MP, Cam. Post. 8 MP, Micro USB 2.0.', 2016, 2700, 1),
(35, 'Celular ZTE Axon (A2015): Android 5, Mem. Int. 32 GB, RAM 2 GB, No Mem. Ext., Cam. Front. 8 MP, Cam. Post. 13 MP, Micro USB 2.0.', 2015, 4000, 1),
(36, 'Celular ZTE Axon 7: Android 6, Carga RÃ¡pida, Sonido HiFi, Mem. Int. 64/128 GB, RAM 6 GB, Max. Micro SD 256 GB, Cam. Front. Cam. Front. 8 MP MP, Cam. Post. Cam. Post. 20 MP MP, USB-C 3.0.', 2016, 7500, 1),
(37, 'Celular ZTE Axon 7 Lite: Android 6, Carga RÃ¡pida, Mem. Int. 32 GB, RAM 3 GB, Max. Micro SD 128 GB, Cam. Front. Cam. Front. 8 MP MP, Cam. Post. Cam. Post. 13 MP MP, USB-C 2.0.', 2016, 5000, 1),
(38, 'Celular Lanix Ilium X500B: Android 5, Mem. Int. 8 GB, RAM 1 GB, Max. Micro SD 32 GB, Cam. Front. 2 MP, Cam. Post. 8 MP, Micro USB 2.0.', 2016, 1700, 1),
(39, 'Celular Lanix Ilium LT510: Android 6, Mem. Int. 8 GB, RAM 1 GB, Max. Micro SD 32 GB, Cam. Front. 5 MP, Cam. Post. 8 MP, Micro USB 2.0.', 2017, 2000, 1),
(40, 'Celular HTC Desire 10 Lifestyle (2PUK220): Android 6, Carga RÃ¡pida, Sonido HiFi, Mem. Int. 16/32 GB, RAM 3 GB, Max. Micro SD 1 TB, Cam. Front. Cam. Front. 5 MP MP, Cam. Post. Cam. Post. 13 MP MP, Micro USB 2.0.', 2016, 5500, 1),
(41, 'Celular Samsung Galaxy Grand Prime (SM-G531H): Android 5, Mem. Int. 8 GB, RAM 1.5 GB, Max. Micro SD 64 GB, Cam. Front. 5 MP, Cam. Post. 8 MP, Micro USB 2.0.', 2014, 3000, 1),
(42, 'Celular M4Tel Inspiration (SS4453): Android 6, Lector de Huellas, Mem. Int. 8 GB, RAM 1 GB, Max. Micro SD 128 GB, Cam. Front. Cam. Front. 8 MP MP, Cam. Post. Cam. Post. 13 MP MP, Micro USB 2.0.', 2017, 3400, 1),
(43, 'Celular HTC Desire 650: Android 6, Mem. Int. 16 GB, RAM 2 GB, Max. Micro SD 256 GB, Cam. Front. 5 MP, Cam. Post. 13 MP, Micro USB 2.0.', 2016, 3800, 1),
(44, 'Celular Samsung Galaxy A3 2017 (SM-A320Y): Android 6, Lector de Huellas, Resistencia a Salpicaduras, Mem. Int. 16 GB, RAM 2 GB, Max. Micro SD 512 GB, Cam. Front. Cam. Front. 8 MP MP, Cam. Post. Cam. Post. 13 MP MP, USB-C.', 2016, 7000, 1),
(45, 'Celular Alcatel Shine Elite (5080A): Android 6, Mem. Int. 16 GB, RAM 2 GB, Max. Micro SD 256 GB, Cam. Front. 5 MP, Cam. Post. 13 MP, Micro USB 2.0.', 2016, 3750, 1),
(46, 'Celular Samsung Galaxy J7 Prime (SM-G610M): Android 6, Mem. Int. 16/32 GB, RAM 3 GB, Max. Micro SD 128 GB, Cam. Front. 8 MP, Cam. Post. 13 MP, Micro USB 2.0.', 2016, 6600, 1),
(47, 'Celular Samsung Galaxy J5 Prime (SM-G570M): Android 6, Mem. Int. 16 GB, RAM 2 GB, Max. Micro SD 256 GB, Cam. Front. 5 MP, Cam. Post. 13 MP, Micro USB 2.0.', 2016, 5800, 1),
(48, 'Celular Senwa Odin (S905TL): Android 5, Mem. Int. 4 GB, RAM 2 GB, Max. Micro SD 32 GB, Cam. Front. 5 MP, Cam. Post. 8 MP, Micro USB 2.0.', 2013, 1700, 1),
(49, 'Celular Polaroid L5S (P5025A): Android 5, Mem. Int. 8 GB, RAM 1 GB, Max. Micro SD 32 GB, Cam. Front. 5 MP, Cam. Post. 13 MP, Micro USB 2.0.', 2017, 2200, 1),
(50, 'Celular HTC One A9S: Android 6, Lector de Huellas, Mem. Int. 32 GB, RAM 3 GB, Max. Micro SD 256 GB, Cam. Front. Cam. Front. 5 MP MP, Cam. Post. Cam. Post. 13 MP MP, Micro USB 2.0.', 2016, 7500, 1),
(51, 'Celular ZTE Blade V580: Android 6, Mem. Int. 16 GB, RAM 1 GB, Max. Micro SD 32 GB, Cam. Front. 5 MP, Cam. Post. 13 MP, Micro USB 2.0.', 2016, 3000, 1),
(52, 'Celular Azumi A50LT: Android 5, Mem. Int. 8 GB, RAM 1 GB, Max. Micro SD 32 GB, Cam. Front. 2 MP, Cam. Post. 5 MP, Micro USB 2.0.', 2015, 2200, 1),
(53, 'Celular LG K4 (X230H): Android 5, Mem. Int. 8 GB, RAM 1 GB, Max. Micro SD 32 GB, Cam. Front. 2 MP, Cam. Post. 5 MP, Micro USB 2.0.', 2016, 3500, 1),
(54, 'Celular Polaroid Cosmo P5S (P5046A): Android 6, Mem. Int. 16 GB, RAM 2 GB, Max. Micro SD 32 GB, Cam. Front. 5 MP, Cam. Post. 13 MP, Micro USB 2.0.', 2017, 4150, 1),
(55, 'Celular LG Stylus 3 (M400MT): Android 7, Mem. Int. 16 GB, RAM 3 GB, Max. Micro SD 128 GB, Cam. Front. 5 MP, Cam. Post. 13 MP, Micro USB 2.0.', 2017, 7950, 1),
(56, 'Celular Samsung Galaxy A7 2017 (SM-A720F): Android 6, Mem. Int. 32 GB, RAM 3 GB, Max. Micro SD 256 GB, Cam. Front. 16 MP, Cam. Post. 16 MP, USB-C.', 2017, 11000, 1),
(57, 'Celular Polaroid Cosmo 550 (PSPC550): Android 5, Mem. Int. 8 GB, RAM 1 GB, Max. Micro SD 32 GB, Cam. Front. 5 MP, Cam. Post. 13 MP, Micro USB 2.0.', 2016, 2800, 1),
(58, 'Celular Lanix Ilium L610: Android 6, Mem. Int. 16 GB, RAM 1 GB, Max. Micro SD 64 GB, Cam. Front. 8 MP, Cam. Post. 8 MP, Micro USB 2.0.', 2016, 2400, 1),
(59, 'Celular M4Tel M4 Share (SS4450): Android 5, Mem. Int. 8 GB, RAM 1 GB, Max. Micro SD 128 GB, Cam. Front. 5 MP, Cam. Post. 8 MP, Micro USB 2.0.', 2016, 2250, 1),
(60, 'Celular Lanix Ilium X710: Android 6, Mem. Int. 16 GB, RAM 1 GB, Max. Micro SD 32 GB, Cam. Front. 8 MP, Cam. Post. 8 MP, Micro USB 2.0.', 2016, 2150, 1),
(61, 'Celular Alcatel Pixi4 7 (9003A): Android 6, Mem. Int. 8 GB, RAM 1 GB, Max. Micro SD 32 GB, Cam. Front. 0.5 MP, Cam. Post. 2 MP, Micro USB 2.0.', 2016, 2100, 1),
(62, 'Celular Polaroid Turbo C4 Plus (P4525A): Android 5, Mem. Int. 4 GB, RAM 512 MB, Max. Micro SD 32 GB, Cam. Front. 2 MP, Cam. Post. 5 MP, Micro USB 2.0.', 2017, 1550, 1),
(63, 'Celular Azumi Iro A4Q: Android 6, Mem. Int. 8 GB, RAM 512 MB, Max. Micro SD 32 GB, Cam. Front. 2 MP, Cam. Post. 8 MP, Micro USB 2.0.', 2017, 1139, 1),
(64, 'Celular Alcatel Pixi4 5 (5045A): Android 6, Mem. Int. 8 GB, RAM 1 GB, Max. Micro SD 32 GB, Cam. Front. 5 MP, Cam. Post. 8 MP, Micro USB 2.0.', 2016, 2250, 1),
(65, 'Celular Alcatel Pixi4 5.5 (5012G): Android 6, Mem. Int. 8 GB, RAM 1 GB, Max. Micro SD 32 GB, Cam. Front. 8 MP, Cam. Post. 13 MP, Micro USB 2.0.', 2016, 2400, 1),
(66, 'Celular Samsung Galaxy J7 Metal (SM-J710MN): Android 6, Mem. Int. 16 GB, RAM 2 GB, Max. Micro SD 256 GB, Cam. Front. 5 MP, Cam. Post. 12.8 MP, Micro USB 2.0.', 2016, 5500, 1),
(67, 'Celular M4 Evolution (SS4456): Android 5, Mem. Int. 8 GB, RAM 1 GB, Max. Micro SD 128 GB, Cam. Front. 8 MP, Cam. Post. 13 MP, Micro USB 2.0.', 2017, 2700, 1),
(68, 'Celular PCD Monkey (E501): Android 4, Mem. Int. 8 GB, RAM 1 GB, Max. Micro SD 32 GB, Cam. Front. 2 MP, Cam. Post. 8 MP, Micro USB 2.0.', 2016, 1850, 1),
(69, 'Celular M4Tel Soul (SS4350): Android 4, Mem. Int. 8 GB, RAM 1 GB, Max. Micro SD 32 GB, Cam. Front. 5 MP, Cam. Post. 8 MP, Micro USB 2.0.', 2015, 2200, 1),
(70, 'Celular M4Tel Style Access (SS4445): Android 5, Mem. Int. 8 GB, RAM 1 GB, Max. Micro SD 32 GB, Cam. Front. 8 MP, Cam. Post. 13 MP, Micro USB 2.0.', 2015, 2800, 1),
(71, 'Celular Doppio (SL512): Android 5, Mem. Int. 8 GB, RAM 1 GB, Max. Micro SD 32 GB, Cam. Front. 5 MP, Cam. Post. 8 MP, Micro USB 2.0.', 2017, 2250, 1),
(72, 'Celular Doppio BÃ¡sico (F1810): S.O. Propietario, Bluetooth, Musica MP3, Mem. Int. 32 MB, RAM Desconocido, Max. Micro SD 8 GB, Cam. Front. No Cam. Front. MP, Cam. Post. Cam. Post. 0.3 MP MP, Micro USB 1.0.', 2015, 350, 1),
(73, 'Celular M4Tel Style (SS4045): Android 4, Mem. Int. 4 GB, RAM 1 GB, Max. Micro SD 32 GB, Cam. Front. 2 MP, Cam. Post. 8 MP, Micro USB 2.0.', 2015, 2350, 1),
(74, 'Celular Senwa City (S605): Android 4, Mem. Int. 4 GB, RAM 512 MB, Max. Micro SD 16 GB, Cam. Front. 0.5 MP, Cam. Post. 2 MP, Micro USB 2.0.', 2015, 850, 1),
(75, 'Celular Alcatel Go Play (7048A): Android 5, Mem. Int. 8 GB, RAM 1 GB, Max. Micro SD 32 GB, Cam. Front. 5 MP, Cam. Post. 8 MP, Micro USB 2.0.', 2015, 3400, 1),
(76, 'Celular Alcatel Pop3 5.5 (OT-5025G): Android 5, Mem. Int. 8 GB, RAM 1 GB, Max. Micro SD 32 GB, Cam. Front. 5 MP, Cam. Post. 13 MP, Micro USB 2.0.', 2015, 2000, 1),
(77, 'Celular Alcatel Pixi3 4.5 (OT-4027A): Android 4, Mem. Int. 4/8 GB, RAM 512 MB/1 GB, Max. Micro SD 32 GB, Cam. Front. 0.5 MP, Cam. Post. 5 MP, Micro USB 2.0.', 2015, 1500, 1),
(78, 'Celular Alcatel Pop3 (OT-5015A): Android 5, Mem. Int. 4 GB, RAM 512 MB, Max. Micro SD 32 GB, Cam. Front. 2 MP, Cam. Post. 8 MP, Micro USB 2.0.', 2015, 2000, 1),
(79, 'Celular Samsung Galaxy A7 2016 (SM-A710M): Android 5, Mem. Int. 16 GB, RAM 2 GB, Max. Micro SD 64 GB, Cam. Front. 5 MP, Cam. Post. 13 MP, Micro USB 2.0.', 2016, 10000, 1),
(80, 'Celular Samsung Galaxy A5 2016 (SM-A510M): Android 5, Mem. Int. 16 GB, RAM 2 GB, Max. Micro SD 128 GB, Cam. Front. 5 MP, Cam. Post. 13 MP, Micro USB 2.0.', 2016, 8000, 1),
(81, 'Celular Alcatel Pixi3 3.3 (4009F): Android 4, Mem. Int. 4 GB, RAM 512 MB, Max. Micro SD 32 GB, Cam. Front. 0.5 MP, Cam. Post. 2 MP, Micro USB 2.0.', 2015, 1100, 1),
(82, 'Celular LG Zone (X180G): Android 5, Mem. Int. 16 GB, RAM 1 GB, Max. Micro SD 32 GB, Cam. Front. 8 MP, Cam. Post. 13 MP, Micro USB 2.0.', 2016, 4350, 1),
(83, 'Celular LG Q7 (X210G): Android 5, Mem. Int. 16 GB, RAM 1 GB, Max. Micro SD 32 GB, Cam. Front. 5 MP, Cam. Post. 8 MP, Micro USB 2.0.', 2016, 3500, 1),
(84, 'Celular LG Q10 (K410G): Android 5, Mem. Int. 16 GB, RAM 1 GB, Max. Micro SD 32 GB, Cam. Front. 8 MP, Cam. Post. 8 MP, Micro USB 2.0.', 2016, 3600, 1),
(85, 'Celular Sony Xperia M5 (E5606): Android 5, NFC, Mem. Int. 16 GB, RAM 3 GB, Max. Micro SD 256 GB, Cam. Front. Cam. Front. 13 MP MP, Cam. Post. Cam. Post. 21.5 MP MP, Micro USB 2.0.', 2015, 9800, 1),
(86, 'Celular HTC One A9: Android 6, Mem. Int. 16 GB, RAM 2 GB, Max. Micro SD 2 TB, Cam. Front. 5 MP, Cam. Post. 13 MP, Micro USB 2.0.', 2015, 16650, 1),
(87, 'Celular LG X Style (K200MT): Android 6, Mem. Int. 16 GB, RAM 1.5 GB, Max. Micro SD 256 GB, Cam. Front. 5 MP, Cam. Post. 8 MP, Micro USB 2.0.', 2016, 3600, 1),
(88, 'Celular ZTE Blade A510: Android 6, Mem. Int. 8 GB, RAM 1 GB, Max. Micro SD 32 GB, Cam. Front. 8 MP, Cam. Post. 13 MP, Micro USB 2.0.', 2016, 2250, 1),
(89, 'Celular Polaroid Turbo C5 Aqua (P5005A): Android 5, Mem. Int. 8 GB, RAM 1 GB, Max. Micro SD 32 GB, Cam. Front. 5 MP, Cam. Post. 8 MP, Micro USB 2.0.', 2016, 1800, 1),
(90, 'Celular Samsung Galaxy J5 Metal (SM-J510MN): Android 5, Mem. Int. 16 GB, RAM 2 GB, Max. Micro SD 128 GB, Cam. Front. 5 MP, Cam. Post. 13 MP, Micro USB 2.0.', 2016, 5500, 1),
(91, 'Celular ZTE Blade V6 Plus: Android 6, Lector de Huella, Mem. Int. 16 GB, RAM 2 GB, Max. Micro SD 32 GB, Cam. Front. Cam. Front. 8 MP MP, Cam. Post. Cam. Post. 13 MP MP, Micro USB 2.0.', 2016, 3100, 1),
(92, 'Celular LG X Power (K220H): Android 6, Mem. Int. 16 GB, RAM 2 GB, Max. Micro SD 256 GB, Cam. Front. 5 MP, Cam. Post. 13 MP, Micro USB 2.0.', 2016, 4600, 1),
(93, 'Celular LG X Max (K240H): Android 6, Mem. Int. 16 GB, RAM 1.5 GB, Max. Micro SD 32 GB, Cam. Front. 5 MP, Cam. Post. 13 MP, Micro USB 2.0.', 2016, 4900, 1),
(94, 'iPhone 7 32 GB: iOS 10, Siri, Mem. Int. 32/128/256 GB, RAM 2 GB, No Mem. Ext., Cam. Front. Cam. Front. 7 MP MP, Cam. Post. Cam. Post. 12 MP MP, USB Lightning.', 2016, 16000, 1),
(95, 'Celular NYX Mobile Rex: Android 5, Mem. Int. 8 GB, RAM 1 GB, Max. Micro SD 32 GB, Cam. Front. 2 MP, Cam. Post. 8 MP, Micro USB 2.0.', 2016, 2000, 1),
(96, 'Celular Huawei Y6 II (CAM-L03): Android 6, Mem. Int. 16 GB, RAM 2 GB, Max. Micro SD 128 GB, Cam. Front. 8 MP, Cam. Post. 13 MP, Micro USB 2.0.', 2016, 4650, 1),
(97, 'Celular Sony Xperia XA Ultra (F3213): Android 6, Mem. Int. 16 GB, RAM 2 GB, Max. Micro SD 256 GB, Cam. Front. 16 MP, Cam. Post. 21.5 MP, Micro USB 2.0.', 2016, 8000, 1),
(98, 'Celular Sony Xperia E5 (F3313): Android 6, Mem. Int. 16 GB, RAM 1.5 GB, Max. Micro SD 256 GB, Cam. Front. 5 MP, Cam. Post. 13 MP, Micro USB 2.0.', 2016, 4000, 1),
(99, 'Celular Huawei P9+ (P9 Plus, VIE-L09): Android 6, Carga RÃ¡pida, Mem. Int. 64 GB, RAM 4 GB, Max. Micro SD 128 GB, Cam. Front. Cam. Front. 8 MP MP, Cam. Post. Cam. Post. 12 MP MP, USB-C.', 2016, 16750, 1),
(100, 'Celular ZTE Blade L5: Android 5, Mem. Int. 8 GB, RAM 1 GB, Max. Micro SD 32 GB, Cam. Front. 2 MP, Cam. Post. 8 MP, Micro USB 2.0.', 2016, 1800, 1),
(101, 'Celular NYX Mobile Alter: Android 5, Mem. Int. 8 GB, RAM 1 GB, Max. Micro SD 32 GB, Cam. Front. 2 MP, Cam. Post. 8 MP, Micro USB 2.0.', 2017, 2800, 1),
(102, 'Celular Rinno BÃ¡sico Orbitz (R355): Android 4, Mem. Int. 4 GB, RAM 512 GB, Max. Micro SD 32 GB, Cam. Front. 2 MP, Cam. Post. 2 MP, Micro USB 2.0.', 2012, 800, 1),
(103, 'Celular LG X Cam (K580H): Android 6, Mem. Int. 16 GB, RAM 2 GB, Max. Micro SD 128 GB, Cam. Front. 5 MP, Cam. Post. 13 MP, Micro USB 2.0.', 2016, 5900, 1),
(104, 'Celular Sony Xperia X (F5121): Android 6, Mem. Int. 32 GB, RAM 3 GB, Max. Micro SD 2 TB, Cam. Front. 12.8 MP, Cam. Post. 23 MP, Micro USB 2.0.', 2016, 13200, 1),
(105, 'Celular Huawei Mate 8 (NXT-L09): Android 6, Carga RÃ¡pida 37% en 30 minutos, Mem. Int. 32 GB, RAM 3 GB, Max. Micro SD 128 GB, Cam. Front. Cam. Front. 8 MP MP, Cam. Post. Cam. Post. 16 MP MP, Micro USB 2.0.', 2015, 13200, 1),
(106, 'Celular Huawei Ascend Y635: Android 4, Mem. Int. 8 GB, RAM 1 GB, Max. Micro SD 32 GB, Cam. Front. 2 MP, Cam. Post. 5 MP, Micro USB 2.0.', 2015, 2500, 1),
(107, 'Celular Lanix Ilium L1100: Android 5, Mem. Int. 32 GB, RAM 2 GB, Max. Micro SD 32 GB, Cam. Front. 5 MP, Cam. Post. 13 MP, Micro USB 2.0.', 2015, 5650, 1),
(108, 'Celular Lanix X200: Android 4, Mem. Int. 4 GB, RAM 512 MB, Max. Micro SD 32 GB, Cam. Front. 1.3 MP, Cam. Post. 5 MP, Micro USB 2.0.', 2015, 1300, 1),
(109, 'Celular Lanix Ilium 1000: Android 5, Mem. Int. 16 GB, RAM 2 GB, Max. Micro SD 32 GB, Cam. Front. 5 MP, Cam. Post. 13 MP, Micro USB 2.0.', 2015, 2000, 1),
(110, 'Celular Lanix Ilium L950: Android 4, Mem. Int. 16 GB, RAM 2 GB, Max. Micro SD 32 GB, Cam. Front. 5 MP, Cam. Post. 8 MP, Micro USB 2.0.', 2015, 4200, 1),
(111, 'Tablet Alcatel One Touch Pixi3 10 (8080): Android 5, Mem. Int. 16 GB, RAM 1 GB, Max. Micro SD 64 GB, Cam. Front. 2 MP, Cam. Post. 5 MP, Micro USB 2.0.', 2015, 3000, 1),
(112, 'Celular Lanix Ilium LT500: Android 5, Mem. Int. 8 GB, RAM 1 GB, Max. Micro SD 32 GB, Cam. Front. 8 MP, Cam. Post. 8 MP, Micro USB 2.0.', 2016, 2150, 1),
(113, 'Celular Azumi BÃ¡sico Lite (A35S): Android 4.2, Mem. Int. 4 GB, RAM 512 MB, Max. Micro SD 32 GB, Cam. Front. 1.3 MP, Cam. Post. 5 MP, Micro USB 2.0.', 2014, 1050, 1),
(114, 'Celular LG Zero (H650): Android 5, Mem. Int. 16 GB, RAM 1.5 GB, Max. Micro SD 32 GB, Cam. Front. 8 MP, Cam. Post. 13 MP, Micro USB 2.0.', 2015, 7050, 1),
(115, 'Celular Polaroid Distroller Turbo 450 (PSPT450): Android 4, Mem. Int. 8 GB, RAM 1 GB, Max. Micro SD 32 GB, Cam. Front. 2 MP, Cam. Post. 8 MP, Micro USB 2.0.', 2016, 1800, 1),
(116, 'Celular Huawei GX8 (RIO-L03): Android 5, Mem. Int. 16 GB, RAM 2 GB, Max. Micro SD 32 GB, Cam. Front. 5 MP, Cam. Post. 13 MP, Micro USB 2.0.', 2016, 7000, 1),
(117, 'Celular M4Tel Believe (SS4451): Android 5, Mem. Int. 8 GB, RAM 1 GB, Max. Micro SD 64 GB, Cam. Front. 8 MP, Cam. Post. 13 MP, Micro USB 2.0.', 2016, 2600, 1),
(118, 'Celular Samsung Galaxy S7 (SM-G930F): Android 6, Carga InalÃ¡mbrica, Lector de Huellas, Mem. Int. 32 GB, RAM 4 GB, Max. Micro SD 256 GB, Cam. Front. Cam. Front. 5 MP MP, Cam. Post. Cam. Post. 12 MP MP, Micro USB 2.0.', 2016, 13400, 1),
(119, 'iPhone SE 16 GB: iOS 9, Lector de Huellas, Mem. Int. 16/64 GB, RAM 2 GB, No Mem. Ext., Cam. Front. Cam. Front. 1.2 MP MP, Cam. Post. Cam. Post. 12 MP MP, USB Lightning.', 2016, 10150, 1),
(120, 'iPhone SE 64 GB: iOS 9, Lector de Huellas, Mem. Int. 16/64 GB, RAM 2 GB, No Mem. Ext., Cam. Front. Cam. Front. 1.2 MP MP, Cam. Post. Cam. Post. 12 MP MP, USB Lightning.', 2016, 12289, 1),
(121, 'Celular Alcatel Pixi4 6 (OT-8050G): Android 6, Mem. Int. 8 GB, RAM 1 GB, Max. Micro SD 32 GB, Cam. Front. 5 MP, Cam. Post. 8 MP, Micro USB 2.0.', 2016, 3000, 1),
(122, 'Celular LG G5 SE (H840): Android 6, Carga RÃ¡pida, Lector de Huellas e Iris, Mem. Int. 32 GB, RAM 3 GB, Max. Micro SD 256 GB, Cam. Front. Cam. Front. 8 MP MP, Cam. Post. Cam. Post. Dual 16 + 8 MP MP, USB-C.', 2016, 11450, 1),
(123, 'Celular M4Tel Excite (SS4455): Android 5, Mem. Int. 16 GB, RAM 2 GB, Max. Micro SD 64 GB, Cam. Front. 8 MP, Cam. Post. 18 MP, Micro USB 2.0.', 2016, 3100, 1),
(124, 'Celular HTC 10: Android 6, Carga RÃ¡pida, Lector de Huellas, Mem. Int. 32/64 GB, RAM 4 GB, Max. Micro SD 2 TB, Cam. Front. Cam. Front. 5 MP MP, Cam. Post. Cam. Post. 12 MP MP, USB-C.', 2016, 15700, 1),
(125, 'Celular Samsung Galaxy A6 2016 (SM-A310M): Android 5, Mem. Int. 16 GB, RAM 1.5 GB, Max. Micro SD 128 GB, Cam. Front. 5 MP, Cam. Post. 13 MP, Micro USB 2.0.', 2015, 5200, 1),
(126, 'Celular Samsung Galaxy J3 2016 (SM-J329M): Android 5, Mem. Int. 8 GB, RAM 1.5 GB, Max. Micro SD 128 GB, Cam. Front. 5 MP, Cam. Post. 8 MP, Micro USB 2.0.', 2015, 3750, 1),
(127, 'Celular LG X Screen (K500H): Android 6, Mem. Int. 16 GB, RAM 2 GB, Max. Micro SD 128 GB, Cam. Front. 8 MP, Cam. Post. 13 MP, Micro USB 2.0.', 2016, 4700, 1),
(128, 'Celular Huawei GR3 (TAG-L13): Android 5, Mem. Int. 16 GB, RAM 2 GB, Max. Micro SD 32 GB, Cam. Front. 5 MP, Cam. Post. 13 MP, Micro USB 2.0.', 2016, 3600, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `accesorios_incluidos`
--
ALTER TABLE `accesorios_incluidos`
  ADD PRIMARY KEY (`id_accesorios`);

--
-- Indices de la tabla `devaluacion_antiguedad`
--
ALTER TABLE `devaluacion_antiguedad`
  ADD PRIMARY KEY (`id_devaluacion_antiguedad`);

--
-- Indices de la tabla `devaluacion_estado`
--
ALTER TABLE `devaluacion_estado`
  ADD PRIMARY KEY (`id_devaluacion_estado`);

--
-- Indices de la tabla `estados_fisicos`
--
ALTER TABLE `estados_fisicos`
  ADD PRIMARY KEY (`id_estado_fisico`);

--
-- Indices de la tabla `moviles`
--
ALTER TABLE `moviles`
  ADD PRIMARY KEY (`id_movil`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `accesorios_incluidos`
--
ALTER TABLE `accesorios_incluidos`
  MODIFY `id_accesorios` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `devaluacion_antiguedad`
--
ALTER TABLE `devaluacion_antiguedad`
  MODIFY `id_devaluacion_antiguedad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `devaluacion_estado`
--
ALTER TABLE `devaluacion_estado`
  MODIFY `id_devaluacion_estado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `estados_fisicos`
--
ALTER TABLE `estados_fisicos`
  MODIFY `id_estado_fisico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `moviles`
--
ALTER TABLE `moviles`
  MODIFY `id_movil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
