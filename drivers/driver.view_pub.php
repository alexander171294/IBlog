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
 * driver.view_pub.php
 *
 * Éste controlador se encarga de ver una publicación
 *
 * @author  Alexander1712 <alexander171294@live.com>
 * @license http://www.gnu.org/copyleft/gpl.html
 * @link    https://github.com/alexander171294/IBlog
 */

/* ////////////////////////////////////////////////////////
               Configuración del menú
*/
// crear una instancia de la clase (recordar que tenemos autocarga de clases activado)
$menu = new Menu($db);
// asignamos el menu lateral
$rain->assign('menu_lateral',$menu->get_menu(1));
// asignamos el menu principal
$rain->assign('menu_principal',$menu->get_menu(2));
// asignamos el menu de afiliados
$rain->assign('menu_afiliados',$menu->get_menu(3));
// asignamos el menu inferior
$rain->assign('menu_inferior',$menu->get_menu(4));
// borramos la variable que contiene la clase menu
unset($menu);
//////////////////////////////////////////////////////////

// configuramos el bbcode
$Core->setbbc();

// creamos la instancia de la clase pasandole la db
$pub = new pubs($db);
// creamos una instancia para el captcha para los comentarios
$captcha = new Captcha('files/');
// asignamos los datos de la publicación
$rain->assign('pubdata',$pub->get_pub($_GET['id'], TRUE));
// asignamos la lista de comentarios
$rain->assign('coments',$pub->get_comments($_GET['id']));
// seteamos un nuevo captcha
$captcha->set_value();
// lo creamos
$captcha->create();

// borramos la variable que contiene la instancia del captcha
unset($captcha);
// borramos la variable que contiene la instancia de pubs
unset($pubs);