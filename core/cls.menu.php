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
 * cls.menu.php
 *
 * Ésta clase se encarga de gestionar los menu.
 *
 * @author  Alexander1712 <alexander171294@live.com>
 * @license http://www.gnu.org/copyleft/gpl.html
 * @link    https://github.com/alexander171294/IBlog
 */

class Menu
 {

  // variables internas de la clase //

  // @db: variable que contiene la instancia del controlador de db littledb.
  Private $db = null;

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
     * Retorna la lista de menu, del tipo requerido.
     *
     * @param (int) $tipo tipo de menu a devolver
     *
     * @link WIKI NO DISPONIBLE POR EL MOMENTO
     *
     * @return array( (int) => array('nombre'=>$nombre,'link'=>$link) );
     */
  Public Function get_menu($tipo)
   {
    /** ACLARACIÓN:
     *
     * menues:
     * 1 lateral
     * 2 superior
     * 3 afiliado
     * 4 inferior
     *
     */
    // creamos una variable array para luego devolver
    $resort = array();
    // ejecutamos la consulta requerida para obtener los menues
    $retorno = $this->db->query('Select nombre, link FROM menu WHERE menu = '.$tipo,false,false);
    // recorremos el arreglo para agregarle un índice y poder manejarlo con RainTPL
    while ($values = $retorno->fetchrow())
      {
       $resort[] = $values;
      }
    // retornamos el array con los menues
    return $resort;
   }

  /**
     * Retorna la lista de menu, del tipo requerido.
     *
     * @param string $titulo titulo del menu
     * @param string $url link del menu
     * @param int $tipo tipo de menu
     *
     * @link WIKI NO DISPONIBLE POR EL MOMENTO
     *
     * @return void
     */
  Public function add( $titulo, $url, $tipo)
   {
    // pasamos a numero el tipo
    $tipo = (int) $tipo;
    // insertamos el nuevo menú
    $this->db->insert('menu',array('nombre' => $titulo, 'link' => $url, 'menu' => $tipo),false);
   }
 }