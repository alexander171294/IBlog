<?php

// asignamos variables base
$rain->assign('error','');
$rain->assign('titulo','');
$rain->assign('contenido','');
$rain->assign('tags','');

// obtenemos las categorias
$rain->assign('categorias',$Core->get_cats_select());

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
        $pubs = new pubs($db);
        // creamos el seotitle
        $seo = $Core->set_seo($_POST['titulo']);
        // insertamos un nuevo articulo
        $id = $pubs->insert($_POST['tags'], $_POST['titulo'], $seo, $_POST['contenido'], $_POST['categoria']);
        // redirigimos al artículo
        header('Location: /publicacion/'.$id.'/'.$seo.'/');
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

