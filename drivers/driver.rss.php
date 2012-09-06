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
 * driver.home.php
 *
 * Éste controlador se encarga de iniciar lo necesario para cargar el home del
 * sistema
 *
 * @author  Alexander1712 <alexander171294@live.com>
 * @license http://www.gnu.org/copyleft/gpl.html
 * @link    https://github.com/alexander171294/IBlog
 */

// configuramos el bbcode
$Core->setbbc();

// creamos una clase para las publicaciones
$pub = new pubs($db);

// asignamos la url base
$rain->assign('urlbase', URLBASE);

// listamos y mandamos a rain, las ultimas publicaciones
$rain->assign('list',$pub->get_last_pubs($Core->pag_limit($Core->mesettings['pubsforpage'])));

// borramos la variable con la instancia de la clase pub.
unset($pub);