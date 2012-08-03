-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 03-08-2012 a las 05:05:49
-- Versión del servidor: 5.5.8
-- Versión de PHP: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `iblog`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE IF NOT EXISTS `categorias` (
  `cat_id` int(10) NOT NULL AUTO_INCREMENT,
  `cat_nombre` varchar(200) NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcar la base de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`cat_id`, `cat_nombre`) VALUES
(1, 'categoria de prueba');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE IF NOT EXISTS `comentarios` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `Name` varchar(250) NOT NULL,
  `email` varchar(200) NOT NULL,
  `web` text NOT NULL,
  `coment` text NOT NULL,
  `pub` int(10) NOT NULL,
  `fecha` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcar la base de datos para la tabla `comentarios`
--

INSERT INTO `comentarios` (`id`, `Name`, `email`, `web`, `coment`, `pub`, `fecha`) VALUES
(1, 'alex', 'alexander171294@live.com', 'http://alebcorp.com.ar', 'asdasdasdasd', 1, 1343930635),
(2, 'Alexander', 'alexander171294@live.com', '/', 'sadasdasdsad', 1, 1343932967);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) NOT NULL,
  `link` text NOT NULL,
  `menu` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Volcar la base de datos para la tabla `menu`
--

INSERT INTO `menu` (`id`, `nombre`, `link`, `menu`) VALUES
(1, 'prueba', 'http://google.com', 1),
(2, 'prueba principal', 'sadasd', 2),
(3, 'lololo', 'sadasd', 2),
(5, 'afiliado', 'sadasd', 3),
(6, 'hlasd', 'asdasd', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publicaciones`
--

CREATE TABLE IF NOT EXISTS `publicaciones` (
  `pub_id` int(10) NOT NULL AUTO_INCREMENT,
  `pub_keys` varchar(250) NOT NULL,
  `pub_nombre` varchar(200) NOT NULL,
  `pub_preview` text NOT NULL,
  `pub_contenido` text NOT NULL,
  `pub_autor` int(10) NOT NULL,
  `pub_comentario` int(10) NOT NULL,
  `pub_categoria` int(10) NOT NULL,
  `pub_fecha` int(10) NOT NULL,
  PRIMARY KEY (`pub_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcar la base de datos para la tabla `publicaciones`
--

INSERT INTO `publicaciones` (`pub_id`, `pub_keys`, `pub_nombre`, `pub_preview`, `pub_contenido`, `pub_autor`, `pub_comentario`, `pub_categoria`, `pub_fecha`) VALUES
(1, '', 'Prueba', 'prueba preview', 'prueba completa', 1, 0, 1, 1343889618);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `clave` varchar(250) NOT NULL,
  `valor` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Volcar la base de datos para la tabla `settings`
--

INSERT INTO `settings` (`id`, `clave`, `valor`) VALUES
(1, 'titulo', 'I-Blog Script'),
(2, 'subtitulo', 'Esto es un blog de pruebas'),
(3, 'footer', 'mi blog'),
(4, 'author', 'Alexander Eberle'),
(5, 'description', 'esladlasde'),
(6, 'keyword', 'lala, lalala, feos'),
(7, 'about', 'asdas'),
(8, 'pubsforpage', '3'),
(9, 'boxfooter1', 'asdasdasd'),
(10, 'titlefooter1', 'titulito'),
(11, 'titlefooter2', 'epepepe'),
(12, 'boxfooter2', 'asdasdasd');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `u_id` int(10) NOT NULL AUTO_INCREMENT,
  `u_nombre` varchar(250) NOT NULL,
  `u_pass` varchar(200) NOT NULL,
  `u_rango` int(1) NOT NULL,
  PRIMARY KEY (`u_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcar la base de datos para la tabla `users`
--

INSERT INTO `users` (`u_id`, `u_nombre`, `u_pass`, `u_rango`) VALUES
(1, 'alex', '', 0);
