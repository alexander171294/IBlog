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
 * driver.view_list.php
 *
 * �ste controlador se encarga de listar las publicaci�nes seg�n lo seleccionado
 * por el usuario
 *
 * @author  Alexander1712 <alexander171294@live.com>
 * @license http://www.gnu.org/copyleft/gpl.html
 * @link    https://github.com/alexander171294/IBlog
 */

/* ////////////////////////////////////////////////////////
               Configuraci�n del men�
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
// asignamos la lista de publicaciones de la categor�a o usuario que se pidi�
$rain->assign('list',$pub->get_last_pubs_for($Core->pag_limit($Core->mesettings['pubsforpage'])));
// obtenemos la cantidad de p�ginas:
$cont = $pub->paginate_last_pubs_for();
// guardamos la url segun el tipo de listado
$forq = isset($_GET['foruser']) ? '&foruser='.$_GET['foruser'] : '&forcat='.$_GET['forcat'];
// asignamos la paginaci�n
$rain->assign('paginate',$Core->paginate($Core->mesettings['pubsforpage'],$cont,'/index.php?action=view_list'.$forq));
// borramos la variable que contiene la instancia de la clase pubs
unset($pub);