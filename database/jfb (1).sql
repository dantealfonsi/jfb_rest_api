-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-11-2024 a las 23:58:36
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
(3, '2022-2023', '2022-09-01', '2023-08-01', 0),
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
(2, 'V-', '13293916', 'morels', 'antonio', 'acosta', 'palacios', 'palacios.acosta@gmail.com', '04264804745', '1977-12-23', 'masculino', 'calle 9, casa #4545 muco'),
(27, 'V-', '4949895', 'mercedes', '', 'figuera', '', 'mechemeche@hotmail.com', '04145468884', '1968-04-10', 'femenino', 'calle carabobo #175'),
(28, 'V-', '32456478', 'jeanpierre', 'alejandro', 'sucre', 'moya', 'jeanpi@gmail.com', '04124648754', '2010-12-12', 'masculino', 'calle calvario #45 '),
(29, 'V-', '33456878', 'sebastian', 'andreino', 'sucre', 'moya', 'jeanpi@gmail.com', '04124648754', '2011-07-21', 'masculino', 'calle calvario #45 '),
(30, 'V-', '28129366', 'daniel', 'eduardo', 'alfonsi', '', 'danielitoxyniko@gmail.com', '04128581138', '2000-10-12', 'masculino', 'puerto la cruz'),
(31, 'V-', '32456844', 'queso', 'andreina', 'alfonsi', '', 'queso@gmail.com', '04128581138', '2010-03-10', 'femenino', 'puerto la cruz'),
(32, 'V-', '24646846', 'yrma', '', 'moya', '', 'moyam@gmail.com', '04146464785', '1991-06-20', 'femenino', 'av. indenpendencia'),
(33, 'V-', '26479521', 'juan', 'margarito', 'perez', 'andrade', 'juango@gmail.com', '04124845655', '2012-09-17', 'masculino', 'calle #74 guayacan de las flores'),
(34, 'V-', '10882990', 'martha', 'alexandra', 'avila', 'algorai', 'marthas@gmail.com', '04124846544', '1973-02-20', 'otro', 'calle calvario #454'),
(35, 'V-', '30454684', 'diego', 'andres', 'junei', 'avila', 'dieguitox@gmail.com', '04246465448', '2008-10-16', 'masculino', 'calle calvario #474'),
(36, 'E-', '12345678', 'prueba', 'pruebinha', 'prueba', 'pruebinha', 'prueba@prueba.com', '04264804745', '1977-12-23', 'otro', 'no tiene'),
(37, 'V-', '4949895', 'maria', 'lopez', 'obrador', 'aguero', 'ads@gmail.com', '04128581138', '2024-08-20', 'masculino', 'asdasd'),
(38, 'V-', '24845455', 'josé', 'josé', 'medina', 'ordaz', 'asd@asd.com', '04128581138', '2024-08-16', 'femenino', 'dasdas'),
(39, 'V-', '49498795', 'perry', 'el ornitorrinco', 'fernandez', '', 'asd@asd.com', '04128556555', '2024-08-23', 'masculino', 'asdasd'),
(40, 'V-', '46465555', 'asd', '', 'asd', '', 'asd@gmail.com', '04128581135', '2024-08-20', 'masculino', 'asdasd'),
(41, 'V-', '4949666', 'asd', '', 'asd', '', 'asd@gmail.com', '04128465555', '2024-08-14', 'masculino', 'asdasdasd'),
(42, 'V-', '4646555', 'prueba que tiene que ser muy larga', 'se logro', 'das', '', 'asd@gmail.com', '04128581138', '2024-08-20', 'masculino', 'aasd'),
(43, 'V-', '46555544', 'asdasd', '', 'asdasdasdasd', '', 'asd@gmail.com', '04128581138', '2024-08-21', 'masculino', 'asd'),
(44, 'V-', '12345678', 'asd', '', 'asd', '', 'asd@gmail.com', '04128581338', '2024-08-29', 'femenino', 'asdas'),
(45, 'V-', '4949891', 'asd', '', 'as', '', 'asd@asd.as', '04128555555', '2024-09-25', 'masculino', 'asd'),
(46, 'V-', '4949888', 'asd', '', 'asd', '', 'asd@asd.com', '0242222', '2024-09-25', 'masculino', 'asdasd'),
(47, 'V-', '33456875', 'sebastian', 'andreino', 'sucre', 'moya', 'jeanpi@gmail.com', '04124648754', '2011-07-21', 'masculino', 'calle calvario #45 '),
(48, 'V-', '32456475', 'jeanpierre', 'alejandro', 'sucre', 'moya', 'jeanpi@gmail.com', '04124648754', '2010-12-12', 'masculino', 'calle calvario #45 '),
(49, 'V-', '33456874', 'sebastian', 'andreino', 'sucre', 'moya', 'jeanpi@gmail.com', '04124648754', '2011-07-21', 'masculino', 'calle calvario #45 ');

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
(15, 35, 34, 'madre', 9, '2023-2024', 'quinto'),
(16, 2, 2, 'padre', 2, '2022-2023', '2024'),
(17, 48, 2, 'tutor legal', 2, '2023-2024', 'primero'),
(18, 49, 30, 'tio', 5, '2023-2024', 'primero');

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
(1, 37, 'segundo', 'a', 38, '2023-2024'),
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
(26, 35, 34, '2024-07-10 23:54:56'),
(27, 47, 30, '2024-11-03 04:50:27'),
(28, 48, 2, '2024-11-03 04:54:12'),
(29, 49, 30, '2024-11-03 04:58:51');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subject`
--

CREATE TABLE `subject` (
  `id` int(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `grupo_estable` int(11) NOT NULL,
  `isDeleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `subject`
--

INSERT INTO `subject` (`id`, `name`, `grupo_estable`, `isDeleted`) VALUES
(1, 'matematica', 1, 0),
(2, 'awanile', 0, 0),
(3, 'ciencias juridicas y ciudadanas', 0, 0),
(4, 'materia de prueba que debe ser muy larga porque si', 0, 0);

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
(1, 2, 40, 'industrial\r', 'maestría', '2024-06-01', '0000-00-00', 'medicina\r', 'licenciatura'),
(2, 37, 23, 'animación digital\r', 'licenciatura', '0000-00-00', '0000-00-00', 'comercio', 'maestría'),
(3, 38, 4, 'industrial\r', 'técnico superior universitario', '0000-00-00', '0000-00-00', 'biomedicina', 'maestría'),
(4, 39, 3, 'industrial\r', 'técnico superior universitario', '0000-00-00', '0000-00-00', 'marítima', 'doctorado'),
(5, 40, 1, 'Industrial\r', 'ingeniería', '0000-00-00', '2024-09-09', '', 'diploma'),
(6, 41, 1, 'asd', 'ingeniería', '0000-00-00', '2024-09-09', 'Antropología Social\r', 'maestría'),
(7, 42, 12, 'administración de empresas y gestión de la innovación\r', 'técnico superior universitario', '0000-00-00', '0000-00-00', 'animación\r', 'doctorado'),
(8, 43, 11, 'Administración de Empresas y Gestión de la Innovación\r', 'técnico superior universitario', '0000-00-00', '0000-00-00', 'Industrial\r', 'doctorado'),
(9, 44, 5, 'Ciencias Sociales y Jurídicas\r', 'técnico superior universitario', '2024-08-29', '0000-00-00', 'Administración de Empresas\r', 'maestría'),
(10, 45, 4, 'aasd', 'licenciatura', '2024-09-09', '2024-09-09', '', 'licenciatura'),
(11, 46, 1, 'Ciencias Sociales y Jurídicas\r', 'licenciatura', '2024-09-09', '0000-00-00', 'w', 'ingeniería');

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
(12, 36, '$2y$10$.LPFecjgt462vP7i/FVCR.V7PPxG6WPaGPXaPtPfqazStvyFLCwMK', 0, 'pruebinña', 0, 0),
(13, 30, '$2y$10$hNW08gvF.r3Y8jrZRV3kheMG7qyJMZa6vuTUyKtgBLFwIFf3aabOi', 1, '', 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `work_charge`
--

CREATE TABLE `work_charge` (
  `id` int(10) NOT NULL,
  `teacher_id` int(10) NOT NULL,
  `subject_id` int(10) NOT NULL,
  `section_id` int(10) NOT NULL,
  `day` int(10) NOT NULL,
  `start_hour` varchar(100) NOT NULL,
  `end_hour` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `work_charge`
--

INSERT INTO `work_charge` (`id`, `teacher_id`, `subject_id`, `section_id`, `day`, `start_hour`, `end_hour`) VALUES
(2, 2, 1, 5, 1, '07:00 am', '07:45 am'),
(3, 2, 2, 5, 1, '07:45 am', '08:30 am'),
(4, 0, 1, 5, 4, '07:00 am', '07:45 am'),
(5, 37, 2, 1, 1, '07:00 am', '07:45 am'),
(6, 44, 4, 7, 1, '07:00 am', '07:45 am'),
(7, 39, 4, 7, 1, '07:45 am', '08:30 am'),
(8, 2, 4, 7, 1, '08:30 am', '09:15 am'),
(9, 2, 4, 7, 1, '09:15 am', '10:00 am'),
(10, 37, 1, 5, 1, '08:30 am', '09:15 am'),
(11, 0, 2, 5, 1, '09:15 am', '10:00 am'),
(12, 0, 1, 5, 1, '10:00 am', '10:45 am'),
(13, 0, 1, 5, 1, '01:00 pm', '01:45 pm'),
(14, 2, 1, 5, 1, '03:15 pm', '04:00 pm'),
(15, 0, 1, 5, 1, '01:45 pm', '02:30 pm'),
(16, 2, 1, 7, 1, '02:30 pm', '03:15 pm'),
(17, 0, 1, 1, 1, '01:45 pm', '02:30 pm'),
(18, 37, 1, 1, 1, '07:45 am', '08:30 am'),
(19, 38, 1, 1, 1, '08:30 am', '09:15 am'),
(20, 0, 2, 1, 1, '09:15 am', '10:00 am'),
(21, 0, 1, 1, 1, '10:00 am', '10:45 am'),
(22, 2, 2, 1, 1, '10:45 am', '11:30 am'),
(23, 0, 1, 1, 1, '11:30 am', '12:15 pm'),
(24, 2, 4, 7, 1, '10:00 am', '10:45 am'),
(25, 0, 4, 7, 1, '10:45 am', '11:30 am'),
(26, 0, 4, 7, 1, '11:30 am', '12:15 pm'),
(27, 42, 4, 7, 1, '12:15 pm', '01:00 pm'),
(28, 37, 1, 9, 1, '01:00 pm', '01:45 pm'),
(29, 2, 2, 1, 1, '01:00 pm', '01:45 pm'),
(30, 39, 1, 1, 3, '07:00 am', '07:45 am'),
(31, 38, 1, 1, 3, '07:45 am', '08:30 am'),
(32, 0, 1, 1, 3, '08:30 am', '09:15 am'),
(33, 0, 1, 1, 4, '07:00 am', '07:45 am'),
(34, 2, 1, 1, 5, '07:00 am', '07:45 am'),
(35, 37, 1, 1, 5, '07:45 am', '08:30 am'),
(36, 0, 1, 5, 5, '07:00 am', '07:45 am'),
(37, 2, 1, 5, 5, '07:45 am', '08:30 am'),
(38, 38, 1, 6, 5, '07:45 am', '08:30 am'),
(39, 37, 2, 6, 5, '08:30 am', '09:15 am');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `person`
--
ALTER TABLE `person`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de la tabla `registration`
--
ALTER TABLE `registration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `section`
--
ALTER TABLE `section`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `student`
--
ALTER TABLE `student`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `subject`
--
ALTER TABLE `subject`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `teacher`
--
ALTER TABLE `teacher`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `work_charge`
--
ALTER TABLE `work_charge`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
