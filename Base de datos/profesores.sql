-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-03-2024 a las 23:18:30
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
-- Estructura de tabla para la tabla `profesores`
--

CREATE TABLE `profesores` (
  `profesor_id` int(11) NOT NULL,
  `facultad_id` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `primer_apellido` varchar(50) DEFAULT NULL,
  `segundo_apellido` varchar(50) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `sexo` char(4) DEFAULT NULL,
  `curp` varchar(20) DEFAULT NULL,
  `fecha_alta` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `usuario_alta` varchar(50) DEFAULT NULL,
  `usuario_actualizacion` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `profesores`
--

INSERT INTO `profesores` (`profesor_id`, `facultad_id`, `nombre`, `primer_apellido`, `segundo_apellido`, `fecha_nacimiento`, `sexo`, `curp`, `fecha_alta`, `fecha_actualizacion`, `usuario_alta`, `usuario_actualizacion`) VALUES
(1, 1, 'Emmanuel', 'Terán', 'Ríos', '1980-05-12', 'M', 'TEREMM801512HTCRN01', '2024-03-01 01:06:08', '2024-03-06 20:14:03', 'admin', 'admin'),
(2, 1, 'Gilberto', 'Huerta', 'Ramos', '1975-08-18', 'M', 'HUERAM750818HTCLL02', '2024-03-01 01:06:08', '2024-03-06 20:14:03', 'admin', 'admin'),
(3, 1, 'Oscar', 'Jara', 'Morales', '1982-10-25', 'M', 'JAMOOS821025HTCRSR03', '2024-03-01 01:06:08', '2024-03-06 20:14:03', 'admin', 'admin'),
(4, 1, 'Abel', 'Ramírez', 'Figueroa', '1978-03-30', 'M', 'RAFIAB780330HTCRBL04', '2024-03-01 01:06:08', '2024-03-06 20:14:03', 'admin', 'admin'),
(5, 1, 'José Ángel', 'Castillo', 'Torres', '1983-07-15', 'M', 'CASTJAT830715HTCRRR0', '2024-03-01 01:06:08', '2024-03-06 20:14:03', 'admin', 'admin'),
(6, 1, 'Bryan Argennis', 'Sahagun', 'Camacho', '1981-11-28', 'M', 'SAHCBR811128HTCRMH06', '2024-03-01 01:06:08', '2024-03-06 20:14:03', 'admin', 'admin'),
(7, 1, 'Marco Antonio', 'Valdivieso', 'Rodríguez', '1976-06-20', 'M', 'VALROM760620HTCRRC07', '2024-03-01 01:06:08', '2024-03-06 20:14:03', 'admin', 'admin');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `profesores`
--
ALTER TABLE `profesores`
  ADD PRIMARY KEY (`profesor_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `profesores`
--
ALTER TABLE `profesores`
  MODIFY `profesor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
