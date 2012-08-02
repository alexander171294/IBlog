<?php

 /** @I-Blog 1.0
  *  archivo controlador de menu
  */

class Menu
 {

  Private $db = null;

  Public Function __construct($db)
   {
    $this->db = $db;
   }

  /** menues:
   *
   * 1 lateral
   * 2 superior
   * 3 afiliado
   * 4 inferior
   *
   */

  Public Function get_menu($tipo)
   {
    $resort = array();
    $retorno = $this->db->query('Select nombre, link FROM menu WHERE menu = '.$tipo,false,false);
    while ($values = $retorno->fetchrow())
      {//armamos un array para armar el menu en el html
       $resort[] = $values;
      }
    return $resort;
   }

 }