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

  Public Function get_last_pubs()
   {
    $result = $this->db->query('SELECT pub_id, c.cat_id, c.cat_nombre, u.u_nombre, u.u_id, p.pub_nombre, p.pub_preview, p.pub_comentario, p.pub_fecha FROM publicaciones AS p LEFT JOIN users AS u ON u.u_id = p.pub_autor LEFT JOIN categorias AS c ON c.cat_id = p.pub_categoria',false,false);
    while ($values = $result->fetchrow())
      {//armamos un array para armar el menu en el html
       $resort[] = $values;
      }
    return $resort;
   }

 }