-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-03-2024 a las 23:17:13
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
-- Estructura de tabla para la tabla `alumnos`
--

CREATE TABLE `alumnos` (
  `alumno_id` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `primer_apellido` varchar(50) DEFAULT NULL,
  `segundo_apellido` varchar(50) DEFAULT NULL,
  `matricula` varchar(20) DEFAULT NULL,
  `curp` varchar(20) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `sexo` char(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `alumnos`
--

INSERT INTO `alumnos` (`alumno_id`, `nombre`, `primer_apellido`, `segundo_apellido`, `matricula`, `curp`, `fecha_nacimiento`, `sexo`) VALUES
(1, 'Omar ', 'Rivas', 'Perez', '21009758', 'RIPO020203HVZVRMA0', '2002-02-03', 'M'),
(2, 'Carlos Alberto', 'Molina', 'Canseco', '121305866', 'MOCG010922HVEMLR00', '2001-09-22', 'X'),
(3, 'Miguel Angel', 'Garduza', 'Aburto', '21009759', 'GAAM001128HVERGB00', '2000-11-28', 'M'),
(4, 'Leonel', 'Leon', 'Flores', '21009760', 'LELL020123XOCOONN00', '2002-01-23', 'M'),
(5, 'Jesus Aaron', 'Ramirez', 'Villegas', '21009731', 'RAVJ020715HGRMLS00', '2002-07-15', 'M'),
(6, 'Gerson Jael ', 'Sahagun', 'Camacho', '21009761', 'CASA020825HVEMRH00', '2002-08-25', 'M');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD PRIMARY KEY (`alumno_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  MODIFY `alumno_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
