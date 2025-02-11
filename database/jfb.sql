-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-02-2025 a las 03:30:16
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
(8, 69),
(9, 71),
(10, 74);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `period`
--

CREATE TABLE `period` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `isOpen` int(11) NOT NULL DEFAULT 1,
  `max_date` date DEFAULT NULL,
  `isClosed` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `period`
--

INSERT INTO `period` (`id`, `name`, `start_date`, `end_date`, `isOpen`, `max_date`, `isClosed`) VALUES
(1, '2023-2024', '2023-09-01', '2024-08-25', 0, NULL, 1),
(2, '2024-2025', '2024-08-01', '2025-02-07', 1, '2025-06-04', 0);

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
(1, 'V-', '0000000', 'Admin', 'Admin', 'SuperUser', 'SuperUser', 'admin@gmail.com', '0000000000', '0000-00-00', 'masculino', '0'),
(64, 'V-', '4949895', 'mercedes', 'andreina', 'figuera', 'moya', 'mechemeche@gmail.com', '04148597772', '1968-06-11', 'femenino', 'calle calvario #24'),
(65, 'V-', '20465785', 'morel', 'jesùs', 'acosta', 'alfonsi', 'morel@gmail.com', '04145558652', '1986-02-12', 'masculino', 'el muco'),
(66, 'V-', '28219344', 'josé', 'andres', 'andrade', 'bonette', 'josecho@hotmail.com', '04243134975', '1998-02-08', 'masculino', 'charallave, calle #5'),
(67, 'V-', '10464979', 'luis', 'alfonso', 'quijada', 'guerra', 'lualqui@gmail.com', '04128465214', '2000-10-10', 'masculino', 'calle quijada, #4231'),
(68, 'V-', '13293944', 'daniela', 'andreina', 'salazar', 'ramirez', 'daniela@gmail.com', '04128462344', '1992-07-15', 'femenino', 'calle calvario #24'),
(69, 'V-', '28129555', 'daniel', '', 'alfonsi', '', 'daniel.alfonsi2011@gmail.com', '04128581138', '2000-10-12', 'masculino', 'calle carabobo #174'),
(70, 'V-', '35446554', 'jeanpierre', '', 'sucre', '', 'jeanpi@gmail.com', '04146463524', '2025-02-03', 'masculino', 'calle carabobo #174'),
(71, 'V-', '28165854', 'jesus ', '', 'natera', '', 'nati@gmail.com', '04134846544', '1967-07-11', 'masculino', 'calle carabobo #176'),
(72, 'V-', '28126454', 'sebastian', '', 'natera', '', 'sebas@gmail.com', '04146463512', '2025-02-11', 'masculino', 'calle carabobo #176'),
(73, 'V-', '3445674', 'jose', '', 'jose', '', 'jojose@gmail.com', '04146496544', '2005-07-20', 'masculino', 'calle jojose'),
(74, 'V-', '10597565', 'martha', '', 'figuera', '', 'martha@gmail.com', '04124654874', '1974-07-17', 'femenino', 'calle junin #564'),
(75, 'V-', '3556411', 'michael', '', 'jackson', '', 'michael@gmail.com', '04128464515', '2014-06-17', 'femenino', 'daneil'),
(76, 'V-', '28129366', 'daniel', '', 'alfonsi', '', 'daniel.alfonsi2011@gmail.cmo', '04128544213', '2006-11-28', 'masculino', 'calle carabobo#174'),
(77, 'V-', '28126451', 'sebastianes', 'assad', 'natera', '', 'sebas@gmail.com', '04146463512', '2025-02-11', 'masculino', 'calle carabobo #176'),
(78, 'V-', '13294235', 'diego', '', 'alfonsi', '', 'diego@gmail.com', '04128546452', '2025-02-11', 'masculino', 'fun');

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
(45, 70, 69, 'padre', 25, '2024-2025', 'primero'),
(46, 72, 71, 'tio', 25, '2024-2025', 'primero'),
(47, 73, 69, 'tio', 27, '2024-2025', 'quinto'),
(48, 75, 74, 'madre', 27, '2024-2025', 'quinto'),
(49, 77, 71, 'madre', 25, '2024-2025', 'primero');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `section`
--

CREATE TABLE `section` (
  `id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `year` varchar(100) NOT NULL,
  `section_name` varchar(100) NOT NULL,
  `classroom` varchar(30) NOT NULL,
  `quota` int(11) NOT NULL DEFAULT 35,
  `period` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `section`
--

INSERT INTO `section` (`id`, `teacher_id`, `year`, `section_name`, `classroom`, `quota`, `period`) VALUES
(25, 65, 'primero', 'a', 'A-4', 36, '2024-2025'),
(26, 65, 'primero', 'b', 'A-4', 35, '2024-2025'),
(27, 64, 'quinto', 'a', 'A-35', 35, '2024-2025'),
(28, 67, 'cuarto', 'a', 'A-2', 35, '2024-2025');

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
(31, 62, 61, '2025-01-30 04:41:10'),
(32, 70, 69, '2025-02-11 01:44:15'),
(33, 72, 71, '2025-02-11 01:48:02'),
(34, 73, 69, '2025-02-11 01:50:13'),
(35, 75, 74, '2025-02-11 01:51:50'),
(36, 77, 71, '2025-02-11 02:01:31');

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
(10, 'matematica', 0, 0),
(11, 'quimica', 0, 0),
(12, 'fisica', 0, 0),
(13, 'biologia', 0, 0),
(14, 'ciencias naturales', 0, 0),
(15, 'castellano', 0, 0),
(16, 'ingles', 0, 0),
(17, 'geologia', 0, 0),
(18, 'ciencias de la salud', 0, 0),
(19, 'peluqueria', 1, 0),
(20, 'baile', 1, 0),
(21, 'teatro', 1, 0),
(22, 'educacion fisica', 0, 0);

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
(16, 64, 34, 'administración de empresas\r', 'licenciatura', '2025-02-11', '0000-00-00', 'publicidad\r', 'maestría'),
(17, 65, 40, 'Biología\r', 'licenciatura', '2025-02-11', '0000-00-00', 'Biología\r', 'técnico superior universitario'),
(18, 66, 40, 'Economía\r', 'técnico superior universitario', '2025-02-11', '0000-00-00', 'Administración de Negocios Digitales\r', 'licenciatura'),
(19, 67, 20, 'Antropología\r', 'técnico superior universitario', '2025-02-11', '0000-00-00', 'Software\r', 'diploma'),
(20, 68, 30, 'Bioquímica\r', 'ingeniería', '2025-02-11', '0000-00-00', 'Química\r', 'doctorado'),
(21, 78, 20, 'Ciencias Sociales y Jurídicas\r', 'técnico superior universitario', '2025-02-11', '0000-00-00', 'Administración de Empresas y Gestión de la Innovación\r', 'maestría');

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
(22, 60, '$2y$10$5jOnnVoUD/GVySfgE0ne0.EMyuLXnGjEqzXLItGu1lSyLZl90dEW6', 0, 'operator', 0, 1),
(23, 76, '$2y$10$9sMPHV/yy0VauoDabsLjoOsZleTSMKiLbmwzrL.Iwlg7N5xcvbT5a', 0, 'generic_user', 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_history`
--

CREATE TABLE `user_history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `user_history`
--

INSERT INTO `user_history` (`id`, `user_id`, `action`, `date`) VALUES
(171, 1, 'Admin ha editado una sección', '2025-02-10 19:57:59'),
(172, 1, 'Admin ha registrado a un profesor', '2025-02-10 23:27:04'),
(173, 1, 'Admin ha editado un profesor', '2025-02-10 23:27:20'),
(174, 1, 'Admin ha registrado a un profesor', '2025-02-10 23:29:44'),
(175, 1, 'Admin ha registrado a un profesor', '2025-02-10 23:31:13'),
(176, 1, 'Admin ha registrado a un profesor', '2025-02-10 23:32:45'),
(177, 1, 'Admin ha registrado a un profesor', '2025-02-10 23:41:20'),
(178, 1, 'Admin ha añadido una materia', '2025-02-10 23:41:39'),
(179, 1, 'Admin ha añadido una materia', '2025-02-10 23:41:43'),
(180, 1, 'Admin ha añadido una materia', '2025-02-10 23:41:48'),
(181, 1, 'Admin ha añadido una materia', '2025-02-10 23:41:53'),
(182, 1, 'Admin ha añadido una materia', '2025-02-10 23:42:00'),
(183, 1, 'Admin ha añadido una materia', '2025-02-10 23:42:11'),
(184, 1, 'Admin ha añadido una materia', '2025-02-10 23:42:15'),
(185, 1, 'Admin ha añadido una materia', '2025-02-10 23:42:28'),
(186, 1, 'Admin ha añadido una materia', '2025-02-10 23:42:37'),
(187, 1, 'Admin ha añadido una materia', '2025-02-10 23:43:06'),
(188, 1, 'Admin ha añadido una materia', '2025-02-10 23:43:10'),
(189, 1, 'Admin ha añadido una materia', '2025-02-10 23:43:16'),
(190, 1, 'Admin ha creado una sección', '2025-02-10 23:44:23'),
(191, 1, 'Admin ha creado una sección', '2025-02-10 23:44:37'),
(192, 1, 'Admin ha creado una sección', '2025-02-10 23:44:52'),
(193, 1, 'Admin ha creado una sección', '2025-02-10 23:45:04'),
(194, 1, 'Admin ha añadido una materia', '2025-02-11 01:39:17'),
(195, 1, 'Admin ha editado una materia', '2025-02-11 01:39:48'),
(196, 1, 'Admin ha inscrito un estudiante', '2025-02-11 01:44:15'),
(197, 1, 'Admin ha inscrito un estudiante', '2025-02-11 01:44:15'),
(198, 1, 'Admin ha inscrito un estudiante', '2025-02-11 01:44:15'),
(199, 1, 'Admin ha inscrito un estudiante', '2025-02-11 01:47:35'),
(200, 1, 'Admin ha inscrito un estudiante', '2025-02-11 01:48:02'),
(201, 1, 'Admin ha inscrito un estudiante', '2025-02-11 01:48:02'),
(202, 1, 'Admin ha deshabilitado a un usuario', '2025-02-11 01:49:04'),
(203, 1, 'Admin ha inscrito un estudiante', '2025-02-11 01:50:13'),
(204, 1, 'Admin ha inscrito un estudiante', '2025-02-11 01:50:13'),
(205, 1, 'Admin ha inscrito un estudiante', '2025-02-11 01:51:50'),
(206, 1, 'Admin ha inscrito un estudiante', '2025-02-11 01:51:50'),
(207, 1, 'Admin ha inscrito un estudiante', '2025-02-11 01:51:50'),
(208, 1, 'Admin ha añadido a un usuario', '2025-02-11 01:53:19'),
(209, 1, 'Admin ha inscrito un estudiante', '2025-02-11 02:01:31'),
(210, 1, 'Admin ha inscrito un estudiante', '2025-02-11 02:01:31'),
(211, 1, 'Admin ha registrado a un profesor', '2025-02-11 02:06:36');

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
  `end_hour` varchar(100) NOT NULL,
  `period` varchar(100) NOT NULL,
  `classroom` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `work_charge`
--

INSERT INTO `work_charge` (`id`, `teacher_id`, `subject_id`, `section_id`, `day`, `start_hour`, `end_hour`, `period`, `classroom`) VALUES
(94, 68, 10, 25, 1, '07:00 am', '07:40 am', '2024-2025', 'a-4'),
(95, 68, 10, 25, 1, '07:40 am', '08:20 am', '2024-2025', 'a-4'),
(96, 64, 15, 25, 1, '08:20 am', '09:10 am', '2024-2025', 'a-4'),
(97, 64, 15, 25, 1, '09:10 am', '09:50 am', '2024-2025', 'a-4'),
(98, 66, 16, 25, 1, '09:50 am', '10:30 am', '2024-2025', 'a-4'),
(99, 66, 16, 25, 1, '10:30 am', '11:10 am', '2024-2025', 'a-4'),
(100, 64, 13, 25, 2, '07:00 am', '07:40 am', '2024-2025', 'a-4'),
(101, 64, 13, 25, 2, '07:40 am', '08:20 am', '2024-2025', 'a-4'),
(102, 68, 12, 25, 2, '08:20 am', '09:10 am', '2024-2025', 'a-4'),
(103, 68, 12, 25, 2, '09:10 am', '09:50 am', '2024-2025', 'a-4'),
(104, 65, 14, 25, 2, '09:50 am', '10:30 am', '2024-2025', 'a-4'),
(105, 65, 14, 25, 2, '10:30 am', '11:10 am', '2024-2025', 'a-4'),
(106, 68, 10, 25, 2, '11:10 am', '11:50 pm', '2024-2025', 'a-4'),
(107, 68, 10, 25, 2, '11:50 pm', '12:30 pm', '2024-2025', 'a-4'),
(108, 64, 15, 25, 3, '07:00 am', '07:40 am', '2024-2025', 'a-4'),
(109, 64, 15, 25, 3, '07:40 am', '08:20 am', '2024-2025', 'a-4'),
(110, 67, 11, 25, 3, '08:20 am', '09:10 am', '2024-2025', 'a-4'),
(111, 67, 11, 25, 3, '09:10 am', '09:50 am', '2024-2025', 'a-4'),
(112, 66, 18, 25, 4, '07:00 am', '07:40 am', '2024-2025', 'a-4'),
(113, 66, 18, 25, 4, '07:40 am', '08:20 am', '2024-2025', 'a-4'),
(114, 65, 13, 25, 4, '08:20 am', '09:10 am', '2024-2025', 'a-4'),
(115, 65, 13, 25, 4, '09:10 am', '09:50 am', '2024-2025', 'a-4'),
(116, 65, 14, 25, 4, '09:50 am', '10:30 am', '2024-2025', 'a-4'),
(117, 65, 14, 25, 4, '10:30 am', '11:10 am', '2024-2025', 'a-4'),
(118, 67, 17, 25, 5, '07:00 am', '07:40 am', '2024-2025', 'a-4'),
(119, 67, 17, 25, 5, '07:40 am', '08:20 am', '2024-2025', 'a-4'),
(120, 66, 22, 25, 5, '12:30 pm', '01:10 pm', '2024-2025', 'a-4'),
(121, 0, 10, 26, 1, '07:00 am', '07:40 am', '2024-2025', 'a-4');

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
-- Indices de la tabla `user_history`
--
ALTER TABLE `user_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

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
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `period`
--
ALTER TABLE `period`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `person`
--
ALTER TABLE `person`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT de la tabla `registration`
--
ALTER TABLE `registration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de la tabla `section`
--
ALTER TABLE `section`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `student`
--
ALTER TABLE `student`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `subject`
--
ALTER TABLE `subject`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `teacher`
--
ALTER TABLE `teacher`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `user_history`
--
ALTER TABLE `user_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=212;

--
-- AUTO_INCREMENT de la tabla `work_charge`
--
ALTER TABLE `work_charge`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
