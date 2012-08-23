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
 * driver.adm.add-page.php
 *
 * Controlador para crear nuevas páginas.
 *
 * @author  Alexander1712 <alexander171294@live.com>
 * @license http://www.gnu.org/copyleft/gpl.html
 * @link    https://github.com/alexander171294/IBlog
 */

// asignamos variables base
$rain->assign('error','');
$rain->assign('titulo','');
$rain->assign('contenido','');
$rain->assign('tags','');

// si se realizó el post del nuevo artículo
if($_SERVER['REQUEST_METHOD']=='POST')
 {
  // si se ingresó un titulo y es mayor a 3
  if($_POST['titulo'] != NULL && strlen($_POST['titulo']) > 3)
   {
    // si se ingresó un contenido
    if($_POST['contenido'] != NULL)
     {
      // si se ingresó el tag correctamente
      if($_POST['tags'] != NULL && strlen($_POST['tags']) > 2)
       {
        // creamos una instancia para pubs
        $page = new pages($db);
        // creamos el seotitle
        $seo = $Core->set_seo($_POST['titulo']);
        // insertamos un nuevo articulo
        $id = $page->insert($_POST['tags'], $_POST['titulo'], $seo, $_POST['contenido']);
        // redirigimos al artículo
        header('Location: /pagina/'.$id.'/'.$seo.'/');
        // borramos la variable que contiene la instancia de la clase Pages
        unset($page);
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
  // si ocurrió un error
  if(isset($error))
   {
    // asignamos los valores que ingresó el usuario para que corrija el error
    $rain->assign('titulo', $_POST['titulo']);
    $rain->assign('contenido', $_POST['contenido']);
    $rain->assign('tags', $_POST['tags']);
   }
 }

