-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-05-2024 a las 20:39:11
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
-- Base de datos: `sensor_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `temperaturas`
--

CREATE TABLE `temperaturas` (
  `id` int(11) NOT NULL,
  `temperatura` decimal(5,2) NOT NULL,
  `fecha_temperatura` timestamp NOT NULL DEFAULT current_timestamp(),
  `distancia` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `temperaturas`
--

INSERT INTO `temperaturas` (`id`, `temperatura`, `fecha_temperatura`, `distancia`) VALUES
(1, 2.42, '2024-05-16 18:27:58', 7.50),
(2, 3.37, '2024-05-16 18:28:04', 7.92),
(3, 1.83, '2024-05-16 18:28:09', 13.55),
(4, 1.25, '2024-05-16 18:28:14', 13.87),
(5, 4.69, '2024-05-16 18:28:19', 876.32),
(6, 4.69, '2024-05-16 18:28:25', 142.34),
(7, 3.96, '2024-05-16 18:28:30', 70.64),
(8, 0.00, '2024-05-16 18:28:36', 467.53),
(9, 4.40, '2024-05-16 18:28:41', 105.18);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `temperaturas`
--
ALTER TABLE `temperaturas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `temperaturas`
--
ALTER TABLE `temperaturas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
