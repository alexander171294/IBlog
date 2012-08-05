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
  Public Function get_pag($id)
   {
    // retornamos los valores de la p�gina con id = $id
    return $this->db->query('SELECT p.pag_id, p.seo_title, p.pag_nombre, u.u_nombre, u.u_id, p.pag_contenido, p.pag_keys, p.pag_fecha FROM paginas AS p LEFT JOIN users AS u ON u.u_id = p.pag_autor WHERE p.pag_id = ?',array($id),true);
   }

 }