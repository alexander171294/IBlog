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
 * sistemas de blog. .
 *
 * @author    Alexander Eberle Renzulli <alexander171294@live.com>
 * @copyright 2012 AlEb Corporation / (http://www.alebcorp.com.ar)
 * @license   http://www.gnu.org/copyleft/gpl.html
 * @link      https://github.com/alexander171294/IBlog
 */

/**
 * driver.adm.cats-new.php
 *
 * controlador para agregar nueva categoría
 *
 * @author  Alexander1712 <alexander171294@live.com>
 * @license http://www.gnu.org/copyleft/gpl.html
 * @link    https://github.com/alexander171294/IBlog
 */
 
// crear una instancia de la clase controladora de categorías
$cats = new Cats($db);

// realizamos SEO al nombre
$name = $Core->set_seo($_POST['nombre']);

// eliminamos la publicación.-
$cats->cat_add($name);

// volvemos al inicio del script (home) puesto que no hay que mostrar plantilla
header('Location: /admin/cats/');

// finalizamos la ejecución aquí
die();