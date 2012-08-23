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
 * driver.adm.new.php
 *
 * Controlador para crear nuevas publicaciónes.
 *
 * @author  Alexander1712 <alexander171294@live.com>
 * @license http://www.gnu.org/copyleft/gpl.html
 * @link    https://github.com/alexander171294/IBlog
 */

// asignamos variables base
$rain->assign('error','');
$rain->assign('titulo','');
$rain->assign('url','');

// si se realizó el post del nuevo artículo
if($_SERVER['REQUEST_METHOD']=='POST')
 {
  // seteamos variablaes para usarlas más comodamente
  $url = htmlentities($_POST['url']);
  $titulo = htmlentities($_POST['titulo']);
  if(strlen($titulo) > 3)
   {
    // si el campo url no está vacío
    if(!empty($url))
     {
      // creamos una instancia de la clase menu
      $menu = new Menu($db);
      // agregamos el nuevo menu
      $menu->add($titulo,$url,$_POST['tipo']);
      // borramos la variable que contiene la clase Menu
      unset($menu);
      // realizamos la redirección
      header('Location: /index.php');
     }
    else
     {
      // mostramos el error y asignamos los datos recividos
      $rain->assign('error','El campo url tiene que estar completo');
      $rain->assign('url',$url);
      $rain->assign('titulo',$titulo);
     }
   }
  else
   {
    // mostramos el error y asignamos los datos recividos
    $rain->assign('error','Tiene que haber un titulo mayor de 3 caracteres');
    $rain->assign('url',$url);
    $rain->assign('titulo',$titulo);
   }
 }

