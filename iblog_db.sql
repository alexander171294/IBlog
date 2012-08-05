-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 05-08-2012 a las 23:32:46
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
  `cat_seo` varchar(250) NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcar la base de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`cat_id`, `cat_nombre`, `cat_seo`) VALUES
(1, 'categoria de prueba', 'categoria-de-prueba');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `censura`
--

CREATE TABLE IF NOT EXISTS `censura` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bad` varchar(250) NOT NULL,
  `good` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcar la base de datos para la tabla `censura`
--

INSERT INTO `censura` (`id`, `bad`, `good`) VALUES
(1, 'puto', '[CENSURADO]');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Volcar la base de datos para la tabla `comentarios`
--

INSERT INTO `comentarios` (`id`, `Name`, `email`, `web`, `coment`, `pub`, `fecha`) VALUES
(1, 'alexander1712', 'axelander_xd@live.com.ar', '/', 'probando todo el parser<br />\r\n<br />\r\n<b>censura:</b><br />\r\n<br />\r\n[CENSURADO]<br />\r\n<br />\r\n<b>emoticonos:</b><br />\r\n<br />\r\n<img src="http://i.imgur.com/cZDvF.jpg" width="50" height="50" /><br />\r\n<br />\r\n<b>bbc complejo: </b><br />\r\n<br />\r\n<a href="http://littleforum.com.ar">Little Forum</a>', 1, 1344202150);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `emoticonos`
--

CREATE TABLE IF NOT EXISTS `emoticonos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bbc` varchar(50) NOT NULL,
  `html` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcar la base de datos para la tabla `emoticonos`
--

INSERT INTO `emoticonos` (`id`, `bbc`, `html`) VALUES
(1, '-lol', '<img src="http://i.imgur.com/cZDvF.jpg" width="50" height="50" />');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Volcar la base de datos para la tabla `menu`
--

INSERT INTO `menu` (`id`, `nombre`, `link`, `menu`) VALUES
(1, 'prueba', 'http://localhost/pagina/1/pagina-de-prueba/', 1),
(2, 'Inicio', 'http://localhost/index.php', 2),
(3, 'I-Blog', 'https://github.com/alexander171294/IBlog', 3),
(4, 'Acceder', 'http://localhost/acceder/', 4),
(5, 'Registrarse', 'http://localhost/registro/', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paginas`
--

CREATE TABLE IF NOT EXISTS `paginas` (
  `pag_id` int(11) NOT NULL AUTO_INCREMENT,
  `seo_title` varchar(250) NOT NULL,
  `pag_keys` varchar(250) NOT NULL,
  `pag_nombre` varchar(250) NOT NULL,
  `pag_contenido` text NOT NULL,
  `pag_autor` int(11) NOT NULL,
  `pag_fecha` int(11) NOT NULL,
  PRIMARY KEY (`pag_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcar la base de datos para la tabla `paginas`
--

INSERT INTO `paginas` (`pag_id`, `seo_title`, `pag_keys`, `pag_nombre`, `pag_contenido`, `pag_autor`, `pag_fecha`) VALUES
(1, 'pagina-de-prueba', 'asdasd', 'P&aacute;gina de Prueba', 'lallalalal<br>\r\nsradasd<br>\r\nesto es una prueba jjeje', 1, 0);

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
  `seo_title` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`pub_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcar la base de datos para la tabla `publicaciones`
--

INSERT INTO `publicaciones` (`pub_id`, `pub_keys`, `pub_nombre`, `pub_preview`, `pub_contenido`, `pub_autor`, `pub_comentario`, `pub_categoria`, `pub_fecha`, `seo_title`) VALUES
(1, '', 'Prueba', 'prueba preview', 'prueba completa', 1, 14, 1, 1343889618, 'prueba');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Volcar la base de datos para la tabla `users`
--

INSERT INTO `users` (`u_id`, `u_nombre`, `u_pass`, `u_rango`) VALUES
(1, 'alexander1712', '$2a$08$RnFaOFSMdIa/mjMtkdCQU.Cy8sa7GI9o0khb9E2iXZrpzRWGQrtRy', 0);
