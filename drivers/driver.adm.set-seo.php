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
 * driver.adm.set-seo.php
 *
 * Controlador editar la configuraci�n del seo
 *
 * @author  Alexander1712 <alexander171294@live.com>
 * @license http://www.gnu.org/copyleft/gpl.html
 * @link    https://github.com/alexander171294/IBlog
 */
 
// seteamos los errores a nada
$rain->assign('error', null);

// si se realiz� el post del art�culo editado
if($_SERVER['REQUEST_METHOD']=='POST')
 {
  // actualizamos los datos
  $Core->config_upd('author',$_POST['author']);
  $Core->config_upd('description',$_POST['description']);
  $Core->config_upd('keyword',$_POST['keyword']);
 }
 
// seteamos la configuraci�n b�sica a nada
$rain->assign('config_author', $Core->config_get('author'));
$rain->assign('config_description', $Core->config_get('description'));
$rain->assign('config_keyword', $Core->config_get('keyword'));