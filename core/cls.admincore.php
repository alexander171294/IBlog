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
     *
     *   TODO: mover a una clase a parte cuando sean bastantes acciones con cats
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
     * devuelve un array con las categor�as para ordenarlas con un loop en
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
    // realizamos la consulta para obtener las categor�as
    $obj = $this->db->query('SELECT cat_id, cat_nombre, cat_seo FROM categorias',false,false);
    // seteamos la variable
    $retorno = array();
    // obtenemos cada uno de los registros (categor�as) y agregamos los tags html
    while($value = $obj->fetchrow())
     {
      $retorno[]=$value;
     }
    // retornamos el listado en html.
    return $retorno;
   }


   /**
     * borra de la b�se de datos una categor�a.     .
     *
     * @param: int $target: id de la categor�a a borrar.
     *
     * @link WIKI NO DISPONIBLE POR EL MOMENTO
     *
     * @return void
     *
     *   TODO: mover a una clase a parte cuando sean bastantes acciones con cats
     */
  Public Function cat_delete ($target)
   {
    // borramos la categor�a
    $this->db->delete('categorias', array('cat_id' => $target), false);
   }

   /**
    *
     * agrega una nueva categor�a.     .
     *
     * @param: string $nombre: nombre de la nueva categor�a.
     *
     * @link WIKI NO DISPONIBLE POR EL MOMENTO
     *
     * @return void
     *
     *   TODO: mover a una clase a parte cuando sean bastantes acciones con cats
     */
  Public Function cat_add ($nombre)
   {
    // insertamos la categor�a nueva
    $this->db->insert('categorias', array('cat_nombre' => $nombre, 'cat_seo' => $this->set_seo($nombre)), false);
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

   /**
     * devuelve la configuraci�n exigida por config
     *
     * @param string $config clave a devolver configuraci�n
     *
     * @link WIKI NO DISPONIBLE POR EL MOMENTO
     *
     * @return string
     */
  Public Function config_get($config)
   {
    // obtenemos la clave
    $obj = $this->db->query('SELECT valor FROM settings Where clave = ?',array($config),true);
    // la devolvemos
    return $obj['valor'];
   }
   
  /**
     * actualiza la configuraci�n exigida por config
     *
     * @param string $clave clave a actualizar configuraci�n
     * @param string $valor valor a actualizar la configuraci�n     
     *
     * @link WIKI NO DISPONIBLE POR EL MOMENTO
     *
     * @return void
     */
  Public Function config_upd($clave, $valor)
   {
    // obtenemos la clave
    $obj = $this->db->update('settings', array('valor' => $valor), array('clave' => $clave), false);
   }

   /**
     * actualiza la configuraci�n utilizando las variables recividas
     *
     * @param string $title titulo del blog
     * @param string $subtitulo subtitulo del blog
     * @param string $footer pi� de p�gina del blog
     * @param string $pubsforpage publicaci�nes por p�gina
     *
     * @link WIKI NO DISPONIBLE POR EL MOMENTO
     *
     * @return string
     */
  Public Function update_settings($title, $subtitulo, $footer, $pubsforpage)
   {
    // actualizamos el t�tulo
    $this->db->update('settings',array('valor' => $title),array('clave' => 'titulo'));
    // actualizamos el subtitulo
    $this->db->update('settings',array('valor' => $subtitulo),array('clave' => 'subtitulo'));
    // actualizamos el footer
    $this->db->update('settings',array('valor' => $footer),array('clave' => 'footer'));
    // actualizamos las publicaciones por p�gina
    $this->db->update('settings',array('valor' => $pubsforpage),array('clave' => 'pubsforpage'));
   }
 }