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
 * cls.shoutbox.php
 *
 * Ésta clase únicamente es utilizada por administración. obtiene y edita los
 * shoutbox del home.
 *
 * @author  Alexander1712 <alexander171294@live.com>
 * @license http://www.gnu.org/copyleft/gpl.html
 * @link    https://github.com/alexander171294/IBlog
 *
 *  TODO: mover aquí todo lo referente a shoutbox
 *
 */

Class ShoutBox
 {

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
     * Obtiene un array con los tres tipos de shoutbox y con contenido
     * titulo, para assignar a rain directamente.
     *
     * @link WIKI NO DISPONIBLE POR EL MOMENTO
     *
     * @return array[int][key]
     */
  Public Function get()
   {
    // obtenemos el about
    $array = $this->db->query('SELECT clave, valor FROM Settings Where id = 7',false,true);
    // lo metemos para retorno
    $retorno[3]['content']=$array['valor'];
    // Obtenemos el titulo del shout 1
    $array = $this->db->query('SELECT valor FROM settings WHERE clave = ?',array('titlefooter1'),true);
    // guardamos el valor ordenado para retornarlo
    $retorno[1]['titulo']=$array['valor'];
    // Obtenemos el titulo del shout 2
    $array = $this->db->query('SELECT valor FROM settings WHERE clave = ?',array('titlefooter2'),true);
    // guardamos el valor ordenado para retornarlo
    $retorno[2]['titulo']=$array['valor'];
    // Obtenemos el contenido del shout 1
    $array = $this->db->query('SELECT valor FROM settings WHERE clave = ?',array('boxfooter1'),true);
    // guardamos el valor ordenado para retornarlo
    $retorno[1]['content']=$array['valor'];
    // Obtenemos el contenido del shout 2
    $array = $this->db->query('SELECT valor FROM settings WHERE clave = ?',array('boxfooter2'),true);
    // guardamos el valor ordenado para retornarlo
    $retorno[2]['content']=$array['valor'];
    // retornamos los valores de los shoutbox
    return $retorno;
   }

  Public Function update($t_sh1, $t_sh2, $c_sh1, $c_sh2, $c_ab)
   {
    // actualizamos el titulo del shoutbox 1
    $this->db->update('settings',array('valor'=>$t_sh1),array('clave'=>'titlefooter1'));
    echo '<center>'.mysql_error().'</center>';
    // actualizamos el titulo del shoutbox 2
    $this->db->update('settings',array('valor'=>$t_sh2),array('clave'=>'titlefooter2'));
    // actualizamos el contenido del shoutbox 1
    $this->db->update('settings',array('valor'=>$c_sh1),array('clave'=>'boxfooter1'));
    // actualizamos el contenido del shoutbox 2
    $this->db->update('settings',array('valor'=>$c_sh2),array('clave'=>'boxfooter2'));
    // actualizamos el contenido de about
    $this->db->update('settings',array('valor'=>$c_ab),array('clave'=>'about'));
   }

 }