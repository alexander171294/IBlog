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
 * cls.pubs.php
 *
 * Ésta clase se encarga de gestionar las publicaciones y comentarios de las
 * mismas.
 *
 * @author  Alexander1712 <alexander171294@live.com>
 * @license http://www.gnu.org/copyleft/gpl.html
 * @link    https://github.com/alexander171294/IBlog
 */

Class Pubs
 {

  // variables locales de la clase //

  // @db: contiene la instancia de la clase controladora de db, littledb
  Private $db = null;

  /**
     * construye la clase, generando instancias necesarias y luego carga la
     * función correspondiente a la sección del blog abierta.
     *
     * @param instance $db instancia de la clase gestionadora de báse de datos.
     *
     * @link WIKI NO DISPONIBLE POR EL MOMENTO
     *
     * @return void
     */
  Public Function __construct($db)
   {
    // guardamos la instancia en la variable interna
    $this->db = $db;
   }

  /**
     * obtiene las últimas publicaciones para armar el home.
     *
     * @param (int) $max valor máximo de publicaciones a listar.
     *
     * @link WIKI NO DISPONIBLE POR EL MOMENTO
     *
     * @return array( (int) => array( 'pub_id'=>string, 'cat_id'=>string, 'cat_nombre'=>string, 'u_nombre'=>string, 'u_id'=>(int), 'pub_nombre'=>string, 'pub_comentario'=>string, 'pub_fecha'=>(int) ) )
     */
  Public Function get_last_pubs($max)
   {
    // obtenemos las ultimas publicaciones limitando segun el contenido de $max
    $result = $this->db->query('SELECT pub_id, c.cat_id, c.cat_nombre, u.u_nombre, u.u_id, p.pub_nombre, p.pub_preview, p.pub_comentario, p.pub_fecha FROM publicaciones AS p LEFT JOIN users AS u ON u.u_id = p.pub_autor LEFT JOIN categorias AS c ON c.cat_id = p.pub_categoria LIMIT '.$max,false,false);
    // recorremos el arreglo para agregarle un índice y usarlo con RainTPL
    while ($values = $result->fetchrow())
      {
       $resort[] = $values;
      }
    // retornamos dicho array.
    return $resort;
   }

   /**
     * obtiene las últimas publicaciones de un usuario o categoría.
     *
     * @param (int) $max valor máximo de publicaciones a listar.
     *
     * @link WIKI NO DISPONIBLE POR EL MOMENTO
     *
     * @return array( (int) => array( 'pub_id'=>string, 'cat_id'=>string, 'cat_nombre'=>string, 'u_nombre'=>string, 'u_id'=>(int), 'pub_nombre'=>string, 'pub_comentario'=>string, 'pub_fecha'=>(int) ) )
     */
  Public Function get_last_pubs_for($max)
   {
    // si la variable foruser está definida
    if(isset($_GET['foruser']))
     {
      // guardamos las últimas publicaciones del usuario
      $result = $this->db->query('SELECT p.pub_id, c.cat_id, c.cat_nombre, u.u_nombre, u.u_id, p.pub_nombre, p.pub_preview, p.pub_comentario, p.pub_fecha FROM publicaciones AS p LEFT JOIN users AS u ON u.u_id = p.pub_autor LEFT JOIN categorias AS c ON c.cat_id = p.pub_categoria WHERE p.pub_autor = ? LIMIT '.$max,array($_GET['foruser']),false);
     }
    // sino, si la variable forcat está definida
    elseif (isset($_GET['forcat']))
     {
      // guardamos las últimas publicaciones de la categoría
      $result = $this->db->query('SELECT p.pub_id, c.cat_id, c.cat_nombre, u.u_nombre, u.u_id, p.pub_nombre, p.pub_preview, p.pub_comentario, p.pub_fecha FROM publicaciones AS p LEFT JOIN users AS u ON u.u_id = p.pub_autor LEFT JOIN categorias AS c ON c.cat_id = p.pub_categoria WHERE p.pub_categoria = ? LIMIT '.$max,array($_GET['forcat']),false);
     }
    // aquí iría otro tipo de filtro... con un elseif

    // recorremos la lista de publicaciones para agregarle un índice
    while ($values = $result->fetchrow())
      {
       $resort[] = $values;
      }
    // devolvemos el array resultante.
    return $resort;
   }

   /**
     * obtiene una publicación específica.
     *
     * @param (int) $id id de la publicación.
     *
     * @link WIKI NO DISPONIBLE POR EL MOMENTO
     *
     * @return array( valores de la db )
     */
  Public Function get_pub($id)
   {
    // retornamos los valores de la publicación con id = $id
    return $this->db->query('SELECT p.pub_id, p.pub_nombre, u.u_nombre, u.u_id, c.cat_nombre, c.cat_id, p.pub_contenido, p.pub_keys, p.pub_comentario, p.pub_fecha FROM publicaciones AS p LEFT JOIN users AS u ON u.u_id = p.pub_autor LEFT JOIN categorias AS c ON c.cat_id = p.pub_categoria WHERE p.pub_id = ?',array($id),true);
   }

   /**
     * obtiene comentarios de una publicación.
     *
     * @param (int) $id id de la publicación.
     *
     * @link WIKI NO DISPONIBLE POR EL MOMENTO
     *
     * @return array( (int) => array( valores de la db ) )
     */
  Public Function get_comments($id)
   {
    // obtenemos la lista de comentarios
    $objeto = $this->db->query('SELECT id, name, email, web, coment, fecha FROM comentarios where pub = ?',array($id),false);
    // recorremos el array resultante agregandole un índice
    while ($values = $objeto->fetchrow())
      {
       $resort[] = $values;
      }
    // devolvemos el array con la lista de comentarios
    return $resort;
   }

   /**
     * obtiene publicaciones que en su contenido tengan el texto a buscar.
     *
     * @param (int) $max cantidad máxima de publicaciones a mostrar.
     * @param string $buscar texto a buscar en la publicación
     *
     * @link WIKI NO DISPONIBLE POR EL MOMENTO
     *
     * @return array( (int) => array( valores de la db ) )
     */
  Public Function Search($buscar,$max)
    {
     // filtramos la variable y lo mandamos directo, porque little db al ? le agrega '' y no funciona en search
     $tword = mysql_real_escape_string($buscar);
     // obtener la lista de publicaciones que contienen el texto a buscar
     $result = $this->db->query('SELECT pub_id, c.cat_id, c.cat_nombre, u.u_nombre, u.u_id, p.pub_nombre, p.pub_preview, p.pub_comentario, p.pub_fecha FROM publicaciones AS p LEFT JOIN users AS u ON u.u_id = p.pub_autor LEFT JOIN categorias AS c ON c.cat_id = p.pub_categoria WHERE p.pub_contenido LIKE \'%'.$tword.'%\' LIMIT '.$max,false,false);
     // recorremos el listado y le agregamos un índice para el RainTPL
     while ($values = $result->fetchrow())
      {
       $resort[] = $values;
      }
     // devolvemos el arreglo final.
     return $resort;
    }

 }