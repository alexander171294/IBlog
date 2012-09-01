<?php

/**
 * I-Blog
 *
 * PHP Version 5.3
 *
 * I-Blog es un proyecto Open Source desarrollado para ser rápido, y sencillo.
 *
 * El repositorio oficial del proyecto lo puedes encontrar un poco más abajo,
 * iblog fué diseñado para blogs alojados en servidores pequeños
 * que no cuenten con tantos recursos para tener un blog pesado como son otros
 * sistemas de blog.
 *
 * @author    Alexander Eberle Renzulli <alexander171294@live.com>
 * @copyright 2012 AlEb Corporation / (http://www.alebcorp.com.ar)
 * @license   http://www.gnu.org/copyleft/gpl.html
 * @link      https://github.com/alexander171294/IBlog
 */

/**
 * driver.install.php
 *
 * Este controlador se encarga de inicializar el instalador del sistema.
 *
 * @author  Alexander1712 <alexander171294@live.com>
 * @license http://www.gnu.org/copyleft/gpl.html
 * @link    https://github.com/alexander171294/IBlog
 */

// si se hizo el post iniciamos la instalación
if(isset($_POST['tit']))
 {
  # pasos de la instalación aquí
  // creamos la tabla categorías
  $db->query('CREATE TABLE `categorias` (
             `cat_id` int(10) NOT NULL AUTO_INCREMENT,
             `cat_nombre` varchar(200) NOT NULL,
             `cat_seo` varchar(250) NOT NULL,
             PRIMARY KEY (`cat_id`)
             )',false,false);
  // insertamos una categoría de prueba
  $db->query('INSERT INTO `categorias` (`cat_id`, `cat_nombre`, `cat_seo`)
              VALUES (1, \'categoria de ejemplo\', \'categoria-de-ejemplo\')',false,false);
  // creamos la tabla de palabras censuradas
  $db->query('CREATE TABLE `censura` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `bad` varchar(250) NOT NULL,
              `good` varchar(250) DEFAULT NULL,
              PRIMARY KEY (`id`)
              )',false,false);
  // creamos la tabla para los comentarios
  $db->query('CREATE TABLE `comentarios` (
              `id` int(10) NOT NULL AUTO_INCREMENT,
              `Name` varchar(250) NOT NULL,
              `email` varchar(200) NOT NULL,
              `web` text NOT NULL,
              `coment` text NOT NULL,
              `pub` int(10) NOT NULL,
              `fecha` int(11) NOT NULL,
              PRIMARY KEY (`id`)
              )',false,false);
  // creamos la tabla para los emoticonos
  $db->query('CREATE TABLE `emoticonos` (
             `id` int(11) NOT NULL AUTO_INCREMENT,
             `bbc` varchar(50) NOT NULL,
             `html` text NOT NULL,
             PRIMARY KEY (`id`)
             )',false,false);
  // insertamos emoticonos
  ##############################################################emoticonos
  // creamos la tabla para el menu
  $db->query('CREATE TABLE `menu` (
             `id` int(11) NOT NULL AUTO_INCREMENT,
             `nombre` varchar(200) NOT NULL,
             `link` text NOT NULL,
             `menu` int(1) NOT NULL,
             PRIMARY KEY (`id`)
             )',false,false);
  // insertamos los ejemplos:
  $db->query('INSERT INTO `menu` (`id`, `nombre`, `link`, `menu`) VALUES
             (1, \'prueba\', \'/pagina/1/pagina-de-prueba/\', 1),
             (2, \'I-Blog\', \'https://github.com/alexander171294/IBlog\', 3),
             (3, \'Iblog Proyect\', \'https://github.com/alexander171294/IBlog\', 4),
             (4, \'AlEb Corporation\', \'/http://alebcorp.com.ar/\', 4);',false,false);
  // creamos la tabla para las páginas
  $db->query('CREATE TABLE `paginas` (
             `pag_id` int(11) NOT NULL AUTO_INCREMENT,
             `seo_title` varchar(250) NOT NULL,
             `pag_keys` varchar(250) NOT NULL,
             `pag_nombre` varchar(250) NOT NULL,
             `pag_contenido` text NOT NULL,
             `pag_autor` int(11) NOT NULL,
             `pag_fecha` int(11) NOT NULL,
             PRIMARY KEY (`pag_id`)
             )',false,false);
  // insertamos una página de ejemplo
  $db->query('INSERT INTO `paginas` (`pag_id`, `seo_title`, `pag_keys`, `pag_nombre`, `pag_contenido`, `pag_autor`, `pag_fecha`) VALUES
             (1, \'pagina-de-prueba\', \'pagina, prueba, iblog\', \'P&aacute;gina de Prueba\', \'Esto es una p&aacute;gina de ejemplo<br>\r\puedes editarla desde el panel de administraci&oacute;n<br>\r\nesto es una prueba jjeje\', 1, 0);
            ',false,false);
  // creamos la tabla pulicaciones
  $db->query('CREATE TABLE `publicaciones` (
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
             )',false,false);
  // insertamos publicacion de bienvenida
  $db->insert('publicaciones',array(
                                    'pub_keys' => 'publicacion, prueba, ejemplo, iblog',
                                    'pub_nombre' => 'Publicaci&oacute;n de ejemplo',
                                    'pub_preview' => 'Bienvenido a [b]I-blog[/b]
                                     Esta es una publicaci&oacute;n de ejemplo... puede leer m&aacute;s haciendo click donde dice leer m&aacute;s',
                                    'pub_contenido' => '<p>como dec&iacute;a, &eacute;sta es una publicaci&oacute;n de ejemplo, tu puedes editarla accediendo al panel de administraci&oacute;n.</p>
[p][strong]I-blog 1.0[/strong][/p]
[p]Gracias por elegirnos....[/p]
[p]Recuerda revisar [url="https://github.com/alexander171294/IBlog"]nuestro repositorio Git[/url] para encontrar actualizaci&oacute;nes y dem&aacute;s... (tambi&eacute;n encontrar&aacute;s una wiki para satisfacer tus dudas).[/p]
[p]I-Blog es otro producto de [url="http://alebcorp.com.ar"]AlEb Corporation - 2012[/url]
Desarrollado por alexander1712[/p]',
                                    'pub_autor' => '1',
                                    'pub_comentario' => '0',
                                    'pub_categoria' => '1',
                                    'pub_fecha' => time(),
                                    'seo_title' => 'publicacion-de-ejemplo'
                                   ));
  // creamos la tabla settings
  $db->query('CREATE TABLE `settings` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `clave` varchar(250) NOT NULL,
              `valor` text NOT NULL,
              PRIMARY KEY (`id`)
              )',false,false);
  // insertamos la configuración
  $db->query('INSERT INTO `settings` (`id`, `clave`, `valor`) VALUES
             (1, \'titulo\', \''.$_POST['tit'].'\'),
             (2, \'subtitulo\', \''.$_POST['subtit'].'\'),
             (3, \'footer\', \''.$_POST['footer'].'\'),
             (4, \'author\', \'Iblog system\'),
             (5, \'description\', \'Blog desarrollado con i-blog\'),
             (6, \'keyword\', \'blog, script, iblog, ejemplo\'),
             (7, \'about\', \'&Eacute;ste blog fue desarrollado con la tecnolog&iacute;a de I-Blog\'),
             (8, \'pubsforpage\', \'5\'),
             (9, \'boxfooter1\', \'ejemplo de caja, usted puede poner cualquier c&oacute;digo aqu&iacute;<br>hasta publicidad\'),
             (10, \'titlefooter1\', \'Caja de ejemplo\'),
             (11, \'titlefooter2\', \'Caja 2\'),
             (12, \'boxfooter2\', \'en estas cajas puedes poner cualquier cosa, hasta publicidad...\'),
             (13, \'fb\', \'#\'),
             (14, \'twt\', \'#\'),
             (15, \'rss\', \'#\')',false,false);
  // creamos la tabla usuarios
  $db->query('CREATE TABLE `users` (
             `u_id` int(10) NOT NULL AUTO_INCREMENT,
             `u_nombre` varchar(250) NOT NULL,
             `u_pass` varchar(200) NOT NULL,
             `u_rango` int(1) NOT NULL,
             PRIMARY KEY (`u_id`)
             )');
  // insertamos el usuario
  $cuenta->registro_light($_POST['nombre'],$_POST['pwd']);
  // redirección al inicio, blog ya instalado.
  header('Location: index.php');
 }

// configuramos la ruta del diseño para instalación
raintpl::configure('tpl_dir', 'themes/install/');

// configuramos la ruta de caché para la instalación
raintpl::configure('cache_dir', $Core->Settings['cache'].'/install/');

// dibujamos la plantilla index del instalador
$rain->draw('index');