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
 * cls.admincore.php
 *
 * Ésta es una versión del core, pero limitada solo a funciones
 * que requiere el panel de administración
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
     * función correspondiente a la sección del blog abierta.
     *
     * @param array $Settings la configuración del sitio (archivo ext.settings.php)
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
     * devuelve la versión SEO del texto entregado.
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
     * devuelve la configuración exigida por config
     *
     * @param string $config clave a devolver configuración
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
     * actualiza la configuración exigida por config
     *
     * @param string $clave clave a actualizar configuración
     * @param string $valor valor a actualizar la configuración     
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
     * actualiza la configuración utilizando las variables recividas
     *
     * @param string $title titulo del blog
     * @param string $subtitulo subtitulo del blog
     * @param string $footer pié de página del blog
     * @param string $pubsforpage publicaciónes por página
     *
     * @link WIKI NO DISPONIBLE POR EL MOMENTO
     *
     * @return string
     */
  Public Function update_settings($title, $subtitulo, $footer, $pubsforpage, $fb, $twt, $rss)
   {
    // actualizamos el título
    $this->db->update('settings',array('valor' => $title),array('clave' => 'titulo'));
    // actualizamos el subtitulo
    $this->db->update('settings',array('valor' => $subtitulo),array('clave' => 'subtitulo'));
    // actualizamos el footer
    $this->db->update('settings',array('valor' => $footer),array('clave' => 'footer'));
    // actualizamos las publicaciones por página
    $this->db->update('settings',array('valor' => $pubsforpage),array('clave' => 'pubsforpage'));
    // actualizamos el facebook
    $this->db->update('settings',array('valor' => $fb),array('clave' => 'fb'));
    // actualizamos el twitter
    $this->db->update('settings',array('valor' => $twt),array('clave' => 'twt'));
    // actualizamos el rss
    $this->db->update('settings',array('valor' => $rss),array('clave' => 'rss'));
   }
 }