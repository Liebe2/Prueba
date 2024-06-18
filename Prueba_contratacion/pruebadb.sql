-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 18-06-2024 a las 13:33:06
-- Versión del servidor: 8.0.31
-- Versión de PHP: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `pruebadb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

DROP TABLE IF EXISTS `personas`;
CREATE TABLE IF NOT EXISTS `personas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(80) NOT NULL,
  `apellido` varchar(80) NOT NULL,
  `dui` varchar(10) NOT NULL,
  `estado` char(1) NOT NULL DEFAULT 'A',
  `profesion_id` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `dui` (`dui`),
  KEY `fk_profesiones` (`profesion_id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`id`, `nombre`, `apellido`, `dui`, `estado`, `profesion_id`) VALUES
(14, 'Willian Stevens', 'Lopez Lopez', '12345678-6', 'I', 14),
(16, 'Carmen Julissa', 'Lopez Landaverde', '000000000-', 'I', 14),
(17, 'Edwin Rommel', 'Alberto Hernandez', '12345678-9', 'I', 14),
(18, 'Irma del Carmen', 'Lopez Landaverde', '12345678-0', 'I', 14),
(19, 'Manuel Jose', 'Alberto Pineda', '12345678-8', 'I', 14),
(20, 'Irma del Carmen', 'Alberto Hernandez', '00000000-0', 'A', 14),
(21, 'Carmen Julissa', 'Lopez Landaverde', '10000000-9', 'A', 14),
(22, 'Carmen Julissa', 'Alberto Pineda', '10000000-8', 'A', 14),
(23, 'Carmen Julissa', 'Lopez Landaverde', '10000000-7', 'A', 14),
(24, 'Carmen Julissa', 'Lopez Landaverde', '10000000-6', 'A', 14),
(25, 'willian Leonardo ', 'Lopez Landaverde', '10000000-5', 'A', 14),
(26, 'Carmen Julissa', 'Lopez Landaverde', '10000000-4', 'A', 14),
(27, 'willian Leonardo ', 'Lopez Landaverde', '10000000-3', 'A', 15),
(28, 'Carmen Julissa', 'Lopez Landaverde', '10000000-2', 'A', 15),
(30, 'Carmen Julissa', 'Lopez Landaverde', '10000000-1', 'A', 14),
(31, 'Irma del Carmen', 'Lopez Lopez', '20000000-3', 'A', 15),
(32, 'Irma del Carmen', 'Lopez Landaverde', '00000000-3', 'A', 15),
(33, 'Edwin Rommel', 'Lopez Lopez', '00000000-1', 'A', 14),
(34, 'Edwin Rommel', 'Lopez Landaverde', '0000000-1', 'I', 14),
(35, 'Carmen Julissa', 'Alberto Pineda', '12000000-3', 'A', 14),
(36, 'Carmen Julissa', 'Lopez Landaverde', '90000000-8', 'A', 15);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesiones`
--

DROP TABLE IF EXISTS `profesiones`;
CREATE TABLE IF NOT EXISTS `profesiones` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(80) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `profesiones`
--

INSERT INTO `profesiones` (`id`, `nombre`) VALUES
(14, 'Soporte Tecnico'),
(15, 'Analista de Datos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_cambios`
--

DROP TABLE IF EXISTS `registro_cambios`;
CREATE TABLE IF NOT EXISTS `registro_cambios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `persona_id` int NOT NULL,
  `campo_modificado` varchar(80) NOT NULL,
  `valor_anterior` varchar(80) NOT NULL,
  `nuevo_valor` varchar(80) NOT NULL,
  `fecha_modificacion` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_personas` (`persona_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `registro_cambios`
--

INSERT INTO `registro_cambios` (`id`, `persona_id`, `campo_modificado`, `valor_anterior`, `nuevo_valor`, `fecha_modificacion`) VALUES
(14, 14, 'nombre', 'Willian Steven', 'Willian Steven1', '2024-06-15 00:00:00'),
(15, 14, 'nombre', 'Willian Steven1', 'Willian Stevens', '2024-06-15 00:00:00'),
(16, 14, 'apellido', 'Lopez Landaverde', 'Lopez Lopez', '2024-06-15 00:00:00'),
(17, 14, 'dui', '12345678-5', '12345678-6', '2024-06-15 00:00:00'),
(18, 33, 'apellido', 'Lopez Landaverde', 'Lopez Lopez', '2024-06-18 00:00:00'),
(19, 33, 'dui', '00000000-1', '02000000-1', '2024-06-18 00:00:00'),
(20, 33, 'dui', '02000000-1', '00000000-1', '2024-06-18 00:00:00'),
(21, 28, 'profesion_id', '14', '15', '2024-06-18 00:00:00'),
(22, 35, 'profesion_id', '14', '15', '2024-06-18 00:00:00'),
(23, 35, 'profesion_id', '15', '14', '2024-06-18 13:00:21');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
