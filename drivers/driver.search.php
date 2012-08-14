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
 * Éste controlador se encarga de iniciar lo necesario para cargar el home del
 * sistema
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

// creamos una instancia de la clase pubs
$pubs = new Pubs($db);
// asignamos el listado de publicaciones encontradas
$rain->assign('list',$pubs->search($_POST['texto'],$this->mesettings['pubsforpage']));
// asignamos el paginado para que no de errores
$rain->assign('paginate','');
// borramos la variable que contiene la instancia de la clase pub
unset($pub);