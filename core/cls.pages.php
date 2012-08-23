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
 * cls.pages.php
 *
 * �sta clase se encarga de gestionar las p�ginas fijas del blog.
 *
 * @author  Alexander1712 <alexander171294@live.com>
 * @license http://www.gnu.org/copyleft/gpl.html
 * @link    https://github.com/alexander171294/IBlog
 */

Class Pages
 {

  // variables locales de la clase //

  // @db: contiene la instancia de la clase controladora de db, littledb
  Private $db = null;

  /**
     * construye la clase, generando instancias necesarias y luego carga la
     * funci�n correspondiente a la secci�n del blog abierta.
     *
     * @param instance $db instancia de la clase gestionadora de b�se de datos.
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
     * obtiene una p�gina espec�fica.
     *
     * @param (int) $id id de la publicaci�n.
     *
     * @link WIKI NO DISPONIBLE POR EL MOMENTO
     *
     * @return array( valores de la db )
     */
  Public Function get_pag($id, $return_parsers)
   {
    // retornamos los valores de la p�gina con id = $id
    $retorno = $this->db->query('SELECT p.pag_id, p.seo_title, p.pag_nombre, u.u_nombre, u.u_id, p.pag_contenido, p.pag_keys, p.pag_fecha FROM paginas AS p LEFT JOIN users AS u ON u.u_id = p.pag_autor WHERE p.pag_id = ?',array($id),true);
    // si hay que parsearlo o no
    if ( $return_parsers == TRUE )
     {
      // filtramos y parseamos bbcode
      $retorno['pag_contenido'] = nl2br(Parser::Parsear_bbcc(Parser::Parsear_bbcn($retorno['pag_contenido'])));
      // pasamos la censura de palabras desde la db
      $retorno['pag_contenido'] = Parser::DB_BBCN_Parser ($retorno['pag_contenido'], array(
                                   'table'=>'censura',
                                   'column_search'=>'bad',
                                   'column_replace'=>'good'
                                   ));
      // pasamos emoticonos desde la db
      $retorno['pag_contenido'] = Parser::DB_BBCN_Parser ($retorno['pag_contenido'], array(
                                   'table'=>'emoticonos',
                                   'column_search'=>'bbc',
                                   'column_replace'=>'html'
                                   ));
     }
    // retornar valor
    return $retorno;
   }
   
  /**
     * crea una nueva p�gina.
     *
     * @param string $tags, string $title, string $seotitle, string $contenido
     *
     * @link WIKI NO DISPONIBLE POR EL MOMENTO
     *
     * @return int
     */
  Public Function insert($tags, $title, $seotitle, $contenido, $categoria)
   {
    // insertamos el nuevo art�culo y devolvemos su id
    return $this->db->insert('paginas',array
     (
      'pag_keys' => htmlentities($tags),
      'pag_nombre' => htmlentities($title),
      'pag_contenido' => htmlentities($contenido),
      'pag_autor' => $_SESSION['id'],
      'pag_fecha' => time(),
      'seo_title' => $seotitle
     ),true);
   }

  /**
     * borra una p�gina.
     *
     * @param int $id id de la p�gina a eliminar
     *
     * @link WIKI NO DISPONIBLE POR EL MOMENTO
     *
     * @return void
     */
  Public Function delete($id)
   {
    // borramos la p�gina
    $this->db->delete('paginas', array('pag_id' => $id), false);
   }
 }