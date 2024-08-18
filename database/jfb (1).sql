-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-08-2024 a las 20:08:07
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
-- Base de datos: `jfb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parent`
--

CREATE TABLE `parent` (
  `id` int(20) NOT NULL,
  `person_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `parent`
--

INSERT INTO `parent` (`id`, `person_id`) VALUES
(1, 2),
(2, 27),
(3, 30),
(4, 32),
(5, 34);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `period`
--

CREATE TABLE `period` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `isOpen` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `period`
--

INSERT INTO `period` (`id`, `name`, `start_date`, `end_date`, `isOpen`) VALUES
(6, '2023-2024', '2023-09-01', '2024-08-25', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `person`
--

CREATE TABLE `person` (
  `id` int(10) NOT NULL,
  `nationality` varchar(10) NOT NULL,
  `cedula` varchar(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `second_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `second_last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `birthday` date DEFAULT NULL,
  `gender` varchar(10) NOT NULL,
  `address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `person`
--

INSERT INTO `person` (`id`, `nationality`, `cedula`, `name`, `second_name`, `last_name`, `second_last_name`, `email`, `phone`, `birthday`, `gender`, `address`) VALUES
(1, '', '', 'Admin', 'Admin', 'SuperUser', 'SuperUser', 'admin', '', '0000-00-00', '', ''),
(2, 'V-', '13293916', 'morel', 'antonio', 'acosta', 'palacios', 'palacios.acosta@gmail.com', '04264804745', '1977-12-23', 'masculino', 'calle 9, casa #4545 Muco'),
(27, 'V-', '4949895', 'mercedes', '', 'figuera', '', 'mechemeche@hotmail.com', '04145468884', '1968-04-10', 'femenino', 'calle carabobo #175'),
(28, 'V-', '32456478', 'jeanpierre', 'alejandro', 'sucre', 'moya', 'jeanpi@gmail.com', '04124648754', '2010-12-12', 'masculino', 'calle calvario #45 '),
(29, 'V-', '33456878', 'sebastian', 'andreino', 'sucre', 'moya', 'jeanpi@gmail.com', '04124648754', '2011-07-21', 'masculino', 'calle calvario #45 '),
(30, 'V-', '28129366', 'daniel', 'eduardo', 'alfonsi', '', 'danielitoxyniko@gmail.com', '04128581138', '2000-10-12', 'masculino', 'puerto la cruz'),
(31, 'V-', '32456844', 'queso', 'andreina', 'alfonsi', '', 'queso@gmail.com', '04128581138', '2010-03-10', 'femenino', 'puerto la cruz'),
(32, 'V-', '24646846', 'yrma', '', 'moya', '', 'moyam@gmail.com', '04146464785', '1991-06-20', 'femenino', 'av. indenpendencia'),
(33, 'V-', '26479521', 'juan', 'margarito', 'perez', 'andrade', 'juango@gmail.com', '04124845655', '2012-09-17', 'masculino', 'calle #74 guayacan de las flores'),
(34, 'V-', '10882990', 'martha', 'alexandra', 'avila', 'algorai', 'marthas@gmail.com', '04124846544', '1973-02-20', 'otro', 'calle calvario #454'),
(35, 'V-', '30454684', 'diego', 'andres', 'junei', 'avila', 'dieguitox@gmail.com', '04246465448', '2008-10-16', 'masculino', 'calle calvario #474'),
(36, 'E-', '12345678', 'prueba', 'pruebinha', 'prueba', 'pruebinha', 'prueba@prueba.com', '04264804745', '1977-12-23', 'otro', 'no tiene');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registration`
--

CREATE TABLE `registration` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `parent_id` int(11) NOT NULL,
  `student_rel` varchar(100) NOT NULL,
  `section_id` int(11) DEFAULT NULL,
  `period` varchar(100) NOT NULL,
  `year` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `registration`
--

INSERT INTO `registration` (`id`, `student_id`, `parent_id`, `student_rel`, `section_id`, `period`, `year`) VALUES
(11, 28, 27, 'abuela', 2, '2023-2024', 'primero'),
(12, 29, 27, 'tutor legal', 1, '2023-2024', 'segundo'),
(13, 31, 30, 'padre', 1, '2023-2024', 'segundo'),
(14, 33, 32, 'tia', 9, '2023-2024', 'quinto'),
(15, 35, 34, 'madre', 9, '2023-2024', 'quinto');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `section`
--

CREATE TABLE `section` (
  `id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `year` varchar(100) NOT NULL,
  `section_name` varchar(100) NOT NULL,
  `quota` int(11) NOT NULL DEFAULT 35,
  `period` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `section`
--

INSERT INTO `section` (`id`, `teacher_id`, `year`, `section_name`, `quota`, `period`) VALUES
(1, 2, 'segundo', 'a', 38, '2023-2024'),
(2, 2, 'primero', 'b', 35, '2023-2024'),
(5, 2, 'primero', 'c', 35, '2023-2024'),
(6, 2, 'tercero', 'a', 35, '2023-2024'),
(7, 2, 'cuarto', 'a', 35, '2023-2024'),
(8, 2, 'segundo', 'b', 35, '2023-2024'),
(9, 2, 'quinto', 'a', 15, '2023-2024'),
(10, 2, 'segundo', 'c', 36, '2023-2024');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `student`
--

CREATE TABLE `student` (
  `id` int(20) NOT NULL,
  `person_id` int(10) NOT NULL,
  `parent_id` int(10) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `student`
--

INSERT INTO `student` (`id`, `person_id`, `parent_id`, `date`) VALUES
(2, 3, 0, '2024-06-20 00:14:21'),
(3, 5, 2, '2024-06-20 00:14:21'),
(13, 12, 2, '2024-06-29 00:12:11'),
(15, 18, 2, '2024-07-07 23:43:35'),
(17, 20, 2, '2024-07-10 16:57:25'),
(18, 21, 2, '2024-07-10 17:01:22'),
(19, 22, 2, '2024-07-10 18:02:31'),
(20, 23, 2, '2024-07-10 18:32:02'),
(21, 24, 2, '2024-07-10 18:41:54'),
(22, 28, 27, '2024-07-10 23:21:38'),
(23, 29, 27, '2024-07-10 23:23:05'),
(24, 31, 30, '2024-07-10 23:27:32'),
(25, 33, 32, '2024-07-10 23:44:58'),
(26, 35, 34, '2024-07-10 23:54:56');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subject`
--

CREATE TABLE `subject` (
  `id` int(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `grupo_estable` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `teacher`
--

CREATE TABLE `teacher` (
  `id` int(10) NOT NULL,
  `person_id` int(11) NOT NULL,
  `total_work_charge` bigint(20) NOT NULL,
  `degree` varchar(100) NOT NULL,
  `qualification` varchar(100) NOT NULL,
  `hiring` date NOT NULL,
  `dismissal` date NOT NULL,
  `second_degree` varchar(100) NOT NULL,
  `second_qualification` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `teacher`
--

INSERT INTO `teacher` (`id`, `person_id`, `total_work_charge`, `degree`, `qualification`, `hiring`, `dismissal`, `second_degree`, `second_qualification`) VALUES
(1, 2, 40, 'biologia', 'mayister', '2024-06-01', '2024-06-26', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `user_id` int(10) NOT NULL,
  `person_id` int(10) NOT NULL,
  `password` varchar(200) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `isAdmin` int(10) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `isBlocked` int(11) NOT NULL DEFAULT 0,
  `isDeleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`user_id`, `person_id`, `password`, `isAdmin`, `user_name`, `isBlocked`, `isDeleted`) VALUES
(1, 1, '$2y$10$wmNGsiV8n5BrNXdYqPsGJ.jgWNfUkuQ0.DR0CJKJsR.Gm4Sbv1nby', 1, 'admin', 0, 0),
(11, 2, '$2y$10$Lt3IHUbfxkitmiVzWullPOBuoZKxca1d2Guy7Ij5qV0lumkYCK1OW', 0, 'pepe', 0, 0),
(12, 36, '$2y$10$.LPFecjgt462vP7i/FVCR.V7PPxG6WPaGPXaPtPfqazStvyFLCwMK', 0, 'pruebinña', 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `work_charge`
--

CREATE TABLE `work_charge` (
  `id` int(10) NOT NULL,
  `teacher_id` int(10) NOT NULL,
  `subject_id` int(10) NOT NULL,
  `section_id` int(10) NOT NULL,
  `day` varchar(100) NOT NULL,
  `start_hour` int(100) NOT NULL,
  `end_hour` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `parent`
--
ALTER TABLE `parent`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`person_id`);

--
-- Indices de la tabla `period`
--
ALTER TABLE `period`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `person_id` (`person_id`);

--
-- Indices de la tabla `work_charge`
--
ALTER TABLE `work_charge`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `parent`
--
ALTER TABLE `parent`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `period`
--
ALTER TABLE `period`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `person`
--
ALTER TABLE `person`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `registration`
--
ALTER TABLE `registration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `section`
--
ALTER TABLE `section`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `student`
--
ALTER TABLE `student`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `subject`
--
ALTER TABLE `subject`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `teacher`
--
ALTER TABLE `teacher`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `work_charge`
--
ALTER TABLE `work_charge`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
