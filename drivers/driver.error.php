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
 * driver.error.php
 *
 * �ste controlador se encarga de gestionar los errores
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