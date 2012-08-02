<?php

 /** @I-Blog 1.0
  * clase para el control de las publicaciones
  */

Class Pubs
 {

  Private $db = null;

  Public Function __construct($db)
   {
    $this->db = $db;
   }

  Public Function get_last_pubs($max)
   {
    $result = $this->db->query('SELECT pub_id, c.cat_id, c.cat_nombre, u.u_nombre, u.u_id, p.pub_nombre, p.pub_preview, p.pub_comentario, p.pub_fecha FROM publicaciones AS p LEFT JOIN users AS u ON u.u_id = p.pub_autor LEFT JOIN categorias AS c ON c.cat_id = p.pub_categoria LIMIT '.$max,false,false);
    while ($values = $result->fetchrow())
      {//armamos un array para armar el menu en el html
       $resort[] = $values;
      }
    return $resort;
   }

  Public Function get_last_pubs_for($max)
   {

    if(isset($_GET['foruser']))
     {
      $result = $this->db->query('SELECT p.pub_id, c.cat_id, c.cat_nombre, u.u_nombre, u.u_id, p.pub_nombre, p.pub_preview, p.pub_comentario, p.pub_fecha FROM publicaciones AS p LEFT JOIN users AS u ON u.u_id = p.pub_autor LEFT JOIN categorias AS c ON c.cat_id = p.pub_categoria WHERE p.pub_autor = ? LIMIT '.$max,array($_GET['foruser']),false);
     }
    elseif (isset($_GET['forcat']))
     {
      $result = $this->db->query('SELECT p.pub_id, c.cat_id, c.cat_nombre, u.u_nombre, u.u_id, p.pub_nombre, p.pub_preview, p.pub_comentario, p.pub_fecha FROM publicaciones AS p LEFT JOIN users AS u ON u.u_id = p.pub_autor LEFT JOIN categorias AS c ON c.cat_id = p.pub_categoria WHERE p.pub_categoria = ? LIMIT '.$max,array($_GET['forcat']),false);
     }

    while ($values = $result->fetchrow())
      {//armamos un array para armar el menu en el html
       $resort[] = $values;
      }
    return $resort;
   }

  Public Function get_pub($id)
   {
    return $this->db->query('SELECT p.pub_id, p.pub_nombre, u.u_nombre, u.u_id, c.cat_nombre, c.cat_id, p.pub_contenido, p.pub_keys, p.pub_comentario, p.pub_fecha FROM publicaciones AS p LEFT JOIN users AS u ON u.u_id = p.pub_autor LEFT JOIN categorias AS c ON c.cat_id = p.pub_categoria WHERE p.pub_id = ?',array($id),true);
   }

  Public Function get_comments($id)
   {
    $objeto = $this->db->query('SELECT id, name, email, web, coment, fecha FROM comentarios where pub = ?',array($id),false);
    echo mysql_error();
    while ($values = $objeto->fetchrow())
      {//armamos un array para armar el menu en el html
       $resort[] = $values;
      }
    return $resort;
   }

  Public Function Search($buscar,$max)
    {
     $buscar = mysql_real_escape_string($buscar);
     $result = $this->db->query('SELECT pub_id, c.cat_id, c.cat_nombre, u.u_nombre, u.u_id, p.pub_nombre, p.pub_preview, p.pub_comentario, p.pub_fecha FROM publicaciones AS p LEFT JOIN users AS u ON u.u_id = p.pub_autor LEFT JOIN categorias AS c ON c.cat_id = p.pub_categoria WHERE p.pub_contenido LIKE \'%'.$buscar.'%\' LIMIT '.$max,false,false);
     while ($values = $result->fetchrow())
      {//armamos un array para armar el menu en el html
       $resort[] = $values;
      }
    return $resort;
    }

 }