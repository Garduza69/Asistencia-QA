-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-03-2024 a las 23:18:51
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sotavento`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materias`
--

CREATE TABLE `materias` (
  `materia_id` int(11) NOT NULL,
  `facultad_id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `fecha_alta` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `usuario_alta` varchar(50) DEFAULT NULL,
  `usuario_actualizacion` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `materias`
--

INSERT INTO `materias` (`materia_id`, `facultad_id`, `nombre`, `fecha_alta`, `fecha_actualizacion`, `usuario_alta`, `usuario_actualizacion`) VALUES
(1, 1, 'Arquitectura de Computadoras', '2024-03-01 01:04:39', '2024-03-01 01:04:39', 'admin', 'admin'),
(2, 1, 'Base de Datos Avanzadas', '2024-03-01 01:04:39', '2024-03-01 01:04:39', 'admin', 'admin'),
(3, 1, 'Desarrollo de Emprendedores', '2024-03-01 01:04:39', '2024-03-01 01:04:39', 'admin', 'admin'),
(4, 1, 'Ingeniería de Software', '2024-03-01 01:04:39', '2024-03-01 01:04:39', 'admin', 'admin'),
(5, 1, 'Inteligencia Artificial', '2024-03-01 01:04:39', '2024-03-01 01:04:39', 'admin', 'admin'),
(6, 1, 'Robótica', '2024-03-01 01:04:39', '2024-03-01 01:04:39', 'admin', 'admin'),
(7, 1, 'Técnicas de Calidad de Software', '2024-03-01 01:04:39', '2024-03-01 01:04:39', 'admin', 'admin'),
(8, 1, 'Administración de proyectos de informática', '2024-03-06 19:56:07', '2024-03-06 19:59:22', NULL, NULL),
(9, 1, 'Arquitectura de desarrollo de software', '2024-03-06 19:58:20', '2024-03-06 19:59:22', NULL, NULL),
(10, 1, 'Compiladores', '2024-03-06 19:58:20', '2024-03-06 19:59:22', NULL, NULL),
(11, 1, 'Control digital', '2024-03-06 19:58:20', '2024-03-06 19:59:22', NULL, NULL),
(12, 1, 'Digital común', '2024-03-06 19:58:20', '2024-03-06 19:59:22', NULL, NULL),
(13, 1, 'Lenguaje ensamblador', '2024-03-06 19:58:20', '2024-03-06 19:59:22', NULL, NULL),
(14, 1, 'Sociedad y desarrollo de mexico', '2024-03-06 19:58:20', '2024-03-06 19:59:30', NULL, NULL),
(15, 1, 'Costos y presupuestos', '2024-03-06 20:02:42', '2024-03-06 20:02:42', NULL, NULL),
(16, 1, 'ELectricidad y magnetismo', '2024-03-06 20:02:42', '2024-03-06 20:02:42', NULL, NULL),
(17, 1, 'Estructura de datos', '2024-03-06 20:02:42', '2024-03-06 20:02:42', NULL, NULL),
(18, 1, 'Fundamentos de base de datos', '2024-03-06 20:02:42', '2024-03-06 20:02:42', NULL, NULL),
(19, 1, 'Mercadeo de software', '2024-03-06 20:02:42', '2024-03-06 20:02:42', NULL, NULL),
(20, 1, 'Programación de interfacez', '2024-03-06 20:02:42', '2024-03-06 20:02:42', NULL, NULL),
(21, 1, 'Sociedad y desarrollo en el mundo', '2024-03-06 20:02:42', '2024-03-06 20:02:42', NULL, NULL),
(22, 1, 'Administración de centros de computo', '2024-03-06 20:05:48', '2024-03-06 20:05:48', NULL, NULL),
(23, 1, 'Comercialización de software', '2024-03-06 20:05:48', '2024-03-06 20:05:48', NULL, NULL),
(24, 1, 'Desarrollo de aplicaciones avanzadas en internet', '2024-03-06 20:05:48', '2024-03-06 20:05:48', NULL, NULL),
(25, 1, 'Redes de telecomunicaciones', '2024-03-06 20:05:48', '2024-03-06 20:05:48', NULL, NULL),
(26, 1, 'Seminario de investigación aplicada', '2024-03-06 20:05:48', '2024-03-06 20:05:48', NULL, NULL),
(27, 1, 'Sistemas digitales para comunicaciones', '2024-03-06 20:05:48', '2024-03-06 20:05:48', NULL, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `materias`
--
ALTER TABLE `materias`
  ADD PRIMARY KEY (`materia_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `materias`
--
ALTER TABLE `materias`
  MODIFY `materia_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
