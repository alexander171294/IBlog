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
 * cls.admincore.php
 *
 * �sta es una versi�n del core, pero limitada solo a funciones
 * que requiere el panel de administraci�n
 *
 * @author  Alexander1712 <alexander171294@live.com>
 * @license http://www.gnu.org/copyleft/gpl.html
 * @link    https://github.com/alexander171294/IBlog
 */

Class AdminCore
 {

  // definimos la variable de la clase
  Public $Settings = array();
  Private $db = null;

  /**
     * construye la clase, generando instancias necesarias y luego carga la
     * funci�n correspondiente a la secci�n del blog abierta.
     *
     * @param array $Settings la configuraci�n del sitio (archivo ext.settings.php)
     * @param instance $db la instancia de littledb
     *
     * @link WIKI NO DISPONIBLE POR EL MOMENTO
     *
     * @return void
     */
  Public Function __construct($settings, $db)
   {
    $this->Settings = $settings;
    $this->db = $db;
   }

    /**
     * devuelve una lista para meter dentro de un select, de las categor�as del
     * blog :D.
     *
     * @link WIKI NO DISPONIBLE POR EL MOMENTO
     *
     * @return string
     */
  Public Function get_cats_select()
   {
    // realizamos la consulta para obtener las categor�as
    $obj = $this->db->query('SELECT cat_id, cat_nombre FROM categorias',false,false);
    // seteamos la variable
    $retorno = '';
    // obtenemos cada uno de los registros (categor�as) y agregamos los tags html
    while($value = $obj->fetchrow())
     {
      $retorno .= '<option value="'.$value['cat_id'].'">'.$value['cat_nombre'].'</option>';
     }
    // retornamos el listado en html.
    return $retorno;
   }

   /**
     * devuelve la versi�n SEO del texto entregado.
     *
     * @param string $string texto a paresear
     *
     * @link WIKI NO DISPONIBLE POR EL MOMENTO
     *
     * @return string
     *
     * Agradecimientos a Ignacio Daniel Rostagno.
     */
  Public Function set_seo($string)
   {
    return preg_replace('/[^\-a-zA-Z0-9]/', '', preg_replace('/\s+/', '-',$string));
   }
 }