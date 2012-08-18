<?php

// asignamos variables base
$rain->assign('error','');
$rain->assign('titulo','');
$rain->assign('contenido','');
$rain->assign('tags','');

// obtenemos las categorias
$rain->assign('categorias',$Core->get_cats_select());

// si se realiz� el post del nuevo art�culo
if(isset($_POST))
 {
  // si se ingres� un titulo y es mayor a 3
  if($_POST['titulo']!='' && strlen($_POST['titulo'])>3)
   {
    // si se ingres� un contenido
    if($_POST['contenido']!='')
     {
      // si se ingres� el tag correctamente
      if($_POST['tag']!='' && strlen($_POST['tag'])>2)
       {

       }
      else
       {
        // mostramos error correspondiente
        $rain->assign('error','Debe ingresar al menos una palabra como tag');
        // avisamos que hay un error creando la variable
        $error = '';
       }
     }
    else
     {
      // mostramos error correspondiente
      $rain->assign('error','Debe ingresar un contenido para el articulo');
      // avisamos que hay un error creando la variable
      $error = '';
     }
   }
  else
   {
    // mostramos error correspondiente
    $rain->assign('error','Debe ingresar un t&iacute;tulo y debe ser mayor a 3 caracteres');
    // avisamos que hay un error creando la variable
    $error = '';
   }
  // si ocurri� un error
  if(isset($error))
   {
    // asignamos los valores que ingres� el usuario para que corrija el error
    $rain->assign('titulo',$_POST['titulo']);
    $rain->assign('contenido',$_POST['contenido']);
    $rain->assign('tags',$_POST['tags']);
   }
 }

