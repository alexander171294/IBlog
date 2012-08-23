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
 * driver.adm.page-edit.php
 *
 * Controlador para editar una p�gina.-
 *
 * @author  Alexander1712 <alexander171294@live.com>
 * @license http://www.gnu.org/copyleft/gpl.html
 * @link    https://github.com/alexander171294/IBlog
 */

// creamos la instancia de la clase pages
$pages = new Pages($db);

// obtenemos los datos de la p�gina
$dats = $pages->get_pag($_GET['target'], FALSE);

// asignamos variables base
$rain->assign('error','');
// titulo de la p�gina
$rain->assign('titulo',$dats['pag_nombre']);
// contenido de la p�gina
$rain->assign('contenido',$dats['pag_contenido']);
// tags de la p�gina
$rain->assign('tags',$dats['pag_keys']);
// id de la p�gina
$rain->assign('idpag',$_GET['target']);

// si se realiz� el post del art�culo editado
if($_SERVER['REQUEST_METHOD']=='POST')
 {
  if($_POST['titulo'] != NULL && strlen($_POST['titulo']) > 3)
   {
    // si se ingres� un contenido
    if($_POST['contenido'] != NULL)
     {
      // si se ingres� el tag correctamente
      if($_POST['tags'] != NULL && strlen($_POST['tags']) > 2)
       {
        // creamos el seotitle
        $seo = $Core->set_seo($_POST['titulo']);
        // actualizamos la p�gina
        $pages->edit($_POST['tags'], $_POST['titulo'], $seo, $_POST['contenido'], $_GET['target']);
        // redirigimos a la p�gina
        header('Location: /pagina/'.$_GET['target'].'/'.$seo.'/');
       }
      else
       {
        // mostramos error correspondiente
        $rain->assign('error','Debe ingresar al menos una palabra como tag');
        // avisamos que hay un error creando la variable
        $error = NULL;
       }
     }
    else
     {
      // mostramos error correspondiente
      $rain->assign('error','Debe ingresar un contenido para el articulo');
      // avisamos que hay un error creando la variable
      $error = NULL;
     }
   }
  else
   {
    // mostramos error correspondiente
    $rain->assign('error','Debe ingresar un t&iacute;tulo y debe ser mayor a 3 caracteres');
    // avisamos que hay un error creando la variable
    $error = NULL;
   }
 }