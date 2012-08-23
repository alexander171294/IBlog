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
 * cls.cats.php
 *
 * Ésta clase establece los métodos necesarios para trabajar con categorías.
 *
 * @author  Alexander1712 <alexander171294@live.com>
 * @license http://www.gnu.org/copyleft/gpl.html
 * @link    https://github.com/alexander171294/IBlog
 */
 
Class Cats
 {
 
  // variables locales de la clase //

  // @db: variable que contiene la instancia de la clase littledb
  Protected $db = null;

  /**
     * construye la clase, guardando la instancia del controlador de bases de
     * datos llamado littledb.
     *
     * @param instance $db instancia de la clase db
     *
     * @link WIKI NO DISPONIBLE POR EL MOMENTO
     *
     * @return void
     */
  Public Function __construct($db)
   {
    $this->db = $db;
   }
   
  /**
     * devuelve una lista para meter dentro de un select, de las categorías del
     * blog :D.
     *
     * @link WIKI NO DISPONIBLE POR EL MOMENTO
     *
     * @return string
     *
     *   TODO: mover a una clase a parte cuando sean bastantes acciones con cats
     */
  Public Function get_cats_select()
   {
    // realizamos la consulta para obtener las categorías
    $obj = $this->db->query('SELECT cat_id, cat_nombre FROM categorias',false,false);
    // seteamos la variable
    $retorno = '';
    // obtenemos cada uno de los registros (categorías) y agregamos los tags html
    while($value = $obj->fetchrow())
     {
      $retorno .= '<option value="'.$value['cat_id'].'">'.$value['cat_nombre'].'</option>';
     }
    // retornamos el listado en html.
    return $retorno;
   }

    /**
     * devuelve un array con las categorías para ordenarlas con un loop en
     * el html gestionado por rain.     .
     *
     * @link WIKI NO DISPONIBLE POR EL MOMENTO
     *
     * @return array
     *
     *   TODO: mover a una clase a parte cuando sean bastantes acciones con cats
     */
  Public Function get_cats_list()
   {
    // realizamos la consulta para obtener las categorías
    $obj = $this->db->query('SELECT cat_id, cat_nombre, cat_seo FROM categorias',false,false);
    // seteamos la variable
    $retorno = array();
    // obtenemos cada uno de los registros (categorías) y agregamos los tags html
    while($value = $obj->fetchrow())
     {
      $retorno[]=$value;
     }
    // retornamos el listado en html.
    return $retorno;
   }


   /**
     * borra de la báse de datos una categoría.     .
     *
     * @param: int $target: id de la categoría a borrar.
     *
     * @link WIKI NO DISPONIBLE POR EL MOMENTO
     *
     * @return void
     *
     *   TODO: mover a una clase a parte cuando sean bastantes acciones con cats
     */
  Public Function cat_delete ($target)
   {
    // borramos la categoría
    $this->db->delete('categorias', array('cat_id' => $target), false);
   }

   /**
    *
     * agrega una nueva categoría.     .
     *
     * @param: string $nombre: nombre de la nueva categoría.
     *
     * @link WIKI NO DISPONIBLE POR EL MOMENTO
     *
     * @return void
     *
     *   TODO: mover a una clase a parte cuando sean bastantes acciones con cats
     */
  Public Function cat_add ($nombre)
   {
    // insertamos la categoría nueva
    $this->db->insert('categorias', array('cat_nombre' => $nombre, 'cat_seo' => $nombre), false);
   }
 
 }