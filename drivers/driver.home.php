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

// creamos una clase para las publicaciones
$pub = new pubs($db);
// listamos y mandamos a rain, las ultimas publicaciones
$rain->assign('list',$pub->get_last_pubs($Core->pag_limit($Core->mesettings['pubsforpage'])));

// asignamos el paginado:
// demo del paginado: (está comentado a propósito porque si se descomenta asume que hay 17 páginas, es para mostrar su funcionamiento)
# $this->rain->assign('paginate',$Core->paginate(3,50,'http://localhost/index.php?action=home'));
// recuerda que para activar este demo tienes que deshabilitar el paginado de las siguientes lineas */

// obtenemos la cantidad de páginas
$cont = $pub->paginate_last_pubs();
// asignamos la paginación
$rain->assign('paginate',$Core->paginate($Core->mesettings['pubsforpage'],$cont,'/index.php?action=home'));
// borramos la variable que contiene la instancia de pub
unset($pub);