-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 02-04-2022 a las 19:43:58
-- Versión del servidor: 5.7.36
-- Versión de PHP: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `banconombre`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoriacuenta`
--

DROP TABLE IF EXISTS `categoriacuenta`;
CREATE TABLE IF NOT EXISTS `categoriacuenta` (
  `CodigoCategoria` char(3) NOT NULL,
  `NombreCategoria` varchar(60) NOT NULL,
  PRIMARY KEY (`CodigoCategoria`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `categoriacuenta`
--

INSERT INTO `categoriacuenta` (`CodigoCategoria`, `NombreCategoria`) VALUES
('AHR', 'Ahorro'),
('EMP', 'Empresarial'),
('PER', 'Personal');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoriatransaccion`
--

DROP TABLE IF EXISTS `categoriatransaccion`;
CREATE TABLE IF NOT EXISTS `categoriatransaccion` (
  `CodigoCategoria` char(3) NOT NULL,
  `NombreCategoria` varchar(60) NOT NULL,
  PRIMARY KEY (`CodigoCategoria`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `categoriatransaccion`
--

INSERT INTO `categoriatransaccion` (`CodigoCategoria`, `NombreCategoria`) VALUES
('DEP', 'Depositar'),
('RET', 'Retirar'),
('CON', 'Consultar'),
('REC', 'Recargo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoriausuario`
--

DROP TABLE IF EXISTS `categoriausuario`;
CREATE TABLE IF NOT EXISTS `categoriausuario` (
  `CodigoCategoria` char(3) NOT NULL,
  `NombreCategoria` varchar(60) NOT NULL,
  PRIMARY KEY (`CodigoCategoria`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `categoriausuario`
--

INSERT INTO `categoriausuario` (`CodigoCategoria`, `NombreCategoria`) VALUES
('REG', 'Regular'),
('ADM', 'Admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuenta`
--

DROP TABLE IF EXISTS `cuenta`;
CREATE TABLE IF NOT EXISTS `cuenta` (
  `NumeroCuenta` int(11) NOT NULL AUTO_INCREMENT,
  `CodigoUsuario` int(11) NOT NULL,
  `CodigoTipoCuenta` char(3) NOT NULL,
  `Saldo` decimal(10,2) DEFAULT NULL,
  `Estado` tinyint(1) NOT NULL,
  `NumeroOperaciones` int(11) DEFAULT NULL,
  `FechaCreacionCuenta` date NOT NULL,
  `FechaFinalizacionCuenta` date DEFAULT NULL,
  PRIMARY KEY (`NumeroCuenta`),
  KEY `FK_CategoriaCuenta_CodigoTipoCuenta` (`CodigoTipoCuenta`),
  KEY `FK_Usuario_CodigoUsuario` (`CodigoUsuario`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial`
--

DROP TABLE IF EXISTS `historial`;
CREATE TABLE IF NOT EXISTS `historial` (
  `NumeroTransaccion` int(11) NOT NULL AUTO_INCREMENT,
  `CodigoTipoTransaccion` char(3) NOT NULL,
  `NumeroCuenta` int(11) NOT NULL,
  `Monto` decimal(10,2) DEFAULT NULL,
  `FechaHora` datetime DEFAULT NULL,
  `Descripcion` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`NumeroTransaccion`),
  KEY `FK_CategoriaTransaccion_CodigoTipoTransaccion` (`CodigoTipoTransaccion`),
  KEY `FK_Cuenta_NumeroCuenta` (`NumeroCuenta`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recargos`
--

DROP TABLE IF EXISTS `recargos`;
CREATE TABLE IF NOT EXISTS `recargos` (
  `CodigoRecargo` int(11) NOT NULL AUTO_INCREMENT,
  `CodigoCategoriaCuenta` char(3) NOT NULL,
  `OperacionesDisponibles` int(11) DEFAULT NULL,
  `RecargoMensual` decimal(4,2) DEFAULT NULL,
  PRIMARY KEY (`CodigoRecargo`),
  KEY `FK_CategoriaCuenta_CodigoCategoriaCuenta` (`CodigoCategoriaCuenta`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `recargos`
--

INSERT INTO `recargos` (`CodigoRecargo`, `CodigoCategoriaCuenta`, `OperacionesDisponibles`, `RecargoMensual`) VALUES
(1, 'AHR', 75, '1.00'),
(2, 'EMP', 175, '0.00'),
(3, 'PER', 100, '0.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `CodigoUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `CodigoCategoria` char(3) NOT NULL,
  `NombreCompleto` varchar(200) DEFAULT NULL,
  `NombreUsuario` varchar(30) DEFAULT NULL,
  `PasswordUsuario` varchar(72) DEFAULT NULL,
  `Email` varchar(40) DEFAULT NULL,
  `FechaNacimiento` date NOT NULL,
  `Edad` int(11) NOT NULL,
  `FechaCreacionUsuario` date DEFAULT NULL,
  PRIMARY KEY (`CodigoUsuario`),
  KEY `FK_CategoriaUsuario_CodigoCategoria` (`CodigoCategoria`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`CodigoUsuario`, `CodigoCategoria`, `NombreCompleto`, `NombreUsuario`, `PasswordUsuario`, `Email`, `FechaNacimiento`, `Edad`, `FechaCreacionUsuario`) VALUES
(1, 'ADM', 'Kevin Alexander Martinez Rivas', 'Admin', '$2y$10$IDXLyIVOutgt1rz5f3MDsOMHst1xmV7OmqeYwQfeF7F1qSS3MQOou', 'kevin@gmail.com', '2001-01-01', 21, '2022-03-27');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
