<?php

/**
 * I-Blog
 *
 * PHP Version 5.3
 *
 * I-Blog es un proyecto Open Source desarrollado para ser r�pido, y sencillo.
 *
 * El repositorio oficial del proyecto lo puedes encontrar un poco m�s abajo,
 * iblog fu� dise�ado para blogs alojados en servidores peque�os
 * que no cuenten con tantos recursos para tener un blog pesado como son otros
 * sistemas de blog. .
 *
 * @author    Alexander Eberle Renzulli <alexander171294@live.com>
 * @copyright 2012 AlEb Corporation / (http://www.alebcorp.com.ar)
 * @license   http://www.gnu.org/copyleft/gpl.html
 * @link      https://github.com/alexander171294/IBlog
 */

/**
 * driver.adm.comment-delete.php
 *
 * controlador para quitar un comentario que llega por $_GET['target']
 *
 * @author  Alexander1712 <alexander171294@live.com>
 * @license http://www.gnu.org/copyleft/gpl.html
 * @link    https://github.com/alexander171294/IBlog
 */

// creamos una instancia de la clase pubs
$pubs = new Pubs($db);

// eliminamos el comentario y retornamos la url de la publicaci�n
$puburl = $pubs->delete_comment($_GET['target']);

// redireccionamos a la url obtenida
header('Location:' . $puburl);

// fianlizamos aqu� el c�digo
die();

// borramos la variable que contiene la clase pubs
unset($pubs);