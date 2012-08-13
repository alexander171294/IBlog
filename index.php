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
 * index.php
 *
 * Éste archivo es el cargador, se encarga de cargar la clase core, incluir la
 * configuración, las funciones extras, la versión, y cuenta el tiempo de
 * ejecución. además activa la autocarga de clases.
 *
 * @author  Alexander1712 <alexander171294@live.com>
 * @license http://www.gnu.org/copyleft/gpl.html
 * @link    https://github.com/alexander171294/IBlog
 */

// contador de recursos
$timestart = microtime( true );
$memstart = memory_get_usage();

// versión
define( 'IBLOGVERSION', '1.0' );

// cargamos funciones básicas
require( 'extras/ext.functions.php' );

// Iniciamos el proceso de carga automatica de clases para el nucleo.
spl_autoload_register( 'autoLoadClass' );

$settings = include ( 'extras/ext.settings.php' );

// creamos una instancia de la db
$db = new LittleDB ( $settingsings['db_host'] , $Settings['db_user'] , $Settings['db_pass'] , $Settings['db_name'] );

// creamos la instancia para manejar las cuentas de usuario
$cuenta = new Cuenta ( $db );

// creamos la instancia de rainTPL
$rain = new RainTPL ();

// iniciamos la clase core y le mandamos la configuración
$Core = new Core ( $rain, $cuenta, $settings , $db , IBLOGVERSION );

// conectamos a la db
$db->connect();

// devuelve true si está instalado y false si no, ademá si devuelve false ejecuta el instalador
if($core->install())
 {
  // guardamos la acción en una variable, y si no existe ponemos home.
       $action = isset( $_GET['action'] ) ? $_GET['action'] : 'home' ;

       // seteamos configuración básica
       $this->Set_Settings();
       // seteamos menues
       $this->Set_Menu();

       // aciones validas definidas en un array
       $valid = array ( // nombre => html
                     'home' => 'index',
                     'view_list' => 'index',
                     'view_pub' => 'view',
                     'admin' => '1',
                     'login' => 'login',
                     'registro' => 'registro',
                     'search' => 'index',
                     'comment' => '',
                     'page' => 'page'
                      );

       // lista de páginas a ignorar draw
       $draw_ignore = array (
                           'comment' => 'not_draw'
                          );

       // llamamos a la función correspondiente a la acción si es válida
       call_user_func(array('core',isset( $valid[$action] ) ? 'calleable_'.$action : 'calleable_error'));
       // dibujamos el archivo correspondiente a la sección siempre que no sea comentario
       if(!isset($draw_ignore[$action]))
        {
         $this->rain->draw(isset( $valid[$action] ) ? $valid[$action] : 'notfound');
        }

// configuramos rainTPL //
// la url base
raintpl::configure( 'base_url', $Core->Settings['site_path'] );
// la dirección del theme
raintpl::configure( 'tpl_dir', 'themes/'.$Core->Settings['tema'].'/' );
// la dirección del caché del theme
raintpl::configure( 'cache_dir', $Core->Settings['cache'].'/'.$Core->Settings['tema'].'/' );

// finalizamos el core
unset($Core);
unset($db);
unset($cuenta);


// mostramos el consumo.
echo('<div class="clear" />Memoria usada: <b>'.roundsize((memory_get_usage() - $memstart), true).'</b> - Tiempo de ejecucion: <b>'.round(microtime(true)-$timestart, 2).' segundos</b></div>');
