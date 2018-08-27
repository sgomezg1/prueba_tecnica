-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-08-2018 a las 05:18:23
-- Versión del servidor: 10.1.34-MariaDB
-- Versión de PHP: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `procesos_prueba`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `login`
--

CREATE TABLE `login` (
  `nom_usuario` varchar(20) NOT NULL,
  `pass_usu` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `login`
--

INSERT INTO `login` (`nom_usuario`, `pass_usu`) VALUES
('admin', '4297f44b13955235245b2497399d7a93'),
('pruebas001', '4297f44b13955235245b2497399d7a93');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proceso`
--

CREATE TABLE `proceso` (
  `num_proc` varchar(8) NOT NULL,
  `desc_proc` varchar(200) NOT NULL,
  `fecha_creacion` date NOT NULL,
  `sede` varchar(20) DEFAULT NULL,
  `pres_proc` double DEFAULT NULL,
  `estado_proceso` varchar(20) DEFAULT NULL,
  `usuario_crea_proceso` varchar(20) DEFAULT NULL,
  `precio_dolares` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `proceso`
--

INSERT INTO `proceso` (`num_proc`, `desc_proc`, `fecha_creacion`, `sede`, `pres_proc`, `estado_proceso`, `usuario_crea_proceso`, `precio_dolares`) VALUES
('12312313', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In sed laoreet nibh, a egestas sapien. Nunc ante urna, feugiat ut risus feugiat, ullamcorper consequat magna. Aenean blandit purus convallis ni', '2018-08-26', 'Bogotá', 324500, 'Habilitado', 'admin', 109.03),
('12345678', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In sed laoreet nibh, a egestas sapien. Nunc ante urna, feugiat ut risus feugiat, ullamcorper consequat magna. Aenean blandit purus convallis ni', '2018-08-26', 'Bogotá', 440000, 'Habilitado', 'admin', 147.84),
('33333344', 'asfdasdfasdfasd', '2018-08-26', 'Bogotá', 213312, 'Habilitado', 'pruebas001', 71.89);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `doc_usu` varchar(20) NOT NULL DEFAULT '',
  `mail_usu` varchar(100) NOT NULL DEFAULT '',
  `usu_usuario` varchar(20) NOT NULL DEFAULT '',
  `nombre1_usu` varchar(20) DEFAULT NULL,
  `nombre2_usu` varchar(20) DEFAULT NULL,
  `ape1_usu` varchar(20) DEFAULT NULL,
  `ape2_usu` varchar(20) DEFAULT NULL,
  `telefono_usu` varchar(20) DEFAULT NULL,
  `direccion_usu` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`doc_usu`, `mail_usu`, `usu_usuario`, `nombre1_usu`, `nombre2_usu`, `ape1_usu`, `ape2_usu`, `telefono_usu`, `direccion_usu`) VALUES
('1015123456', 'correo@coreo.com', 'pruebas001', 'prueba', 'prueba', 'prueba', 'prueba', '3001234567', 'casdfasdfasdf'),
('1015145865', 'admin@admin.com', 'admin', 'admin', 'admin', 'admin', 'admin', '123123', '123123');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`nom_usuario`);

--
-- Indices de la tabla `proceso`
--
ALTER TABLE `proceso`
  ADD PRIMARY KEY (`num_proc`),
  ADD KEY `usuario_crea_proceso` (`usuario_crea_proceso`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`doc_usu`,`mail_usu`,`usu_usuario`),
  ADD KEY `usu_usuario` (`usu_usuario`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `proceso`
--
ALTER TABLE `proceso`
  ADD CONSTRAINT `proceso_ibfk_1` FOREIGN KEY (`usuario_crea_proceso`) REFERENCES `usuario` (`usu_usuario`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`usu_usuario`) REFERENCES `login` (`nom_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
