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
 * admin.php
 *
 * Éste archivo es el cargador, de la sección de administración.
 *
 * @author  Alexander1712 <alexander171294@live.com>
 * @license http://www.gnu.org/copyleft/gpl.html
 * @link    https://github.com/alexander171294/IBlog
 */

// contador de recursos
$timestart = microtime( true );
$memstart = memory_get_usage();

// cargamos funciones básicas
require( 'extras/ext.functions.php' );

// Iniciamos el proceso de carga automatica de clases para el nucleo.
spl_autoload_register( 'autoLoadClass' );

$Settings = include ( 'extras/ext.settings.php' );

// creamos una instancia de la db
$db = new LittleDB ( $Settings['db_host'] , $Settings['db_user'] , $Settings['db_pass'] , $Settings['db_name'] );

// creamos la instancia para manejar las cuentas de usuario
$cuenta = new Cuenta ( $db );

// creamos la instancia de rainTPL
$rain = new RainTPL ();

// iniciamos la clase AdminCore y le mandamos la configuración
$Core = new AdminCore ( $Settings, $db );

// conectamos a la db
$db->connect();


  // si no se encuentra loggueado o el rango no coincide
  if($cuenta->IsLogged() === false || $cuenta->Rango() < 3 ) { header('Location: /index.php'); die(); }

  // asignamos el nombre
  $rain->assign('UName',$cuenta->Get_Name());

  // configuramos rainTPL //
  // la url base
  raintpl::configure( 'base_url', $Core->Settings['site_path'] );
  // la dirección del theme
  raintpl::configure( 'tpl_dir', 'themes/admin/' );
  // la dirección del caché del theme
  raintpl::configure( 'cache_dir', $Core->Settings['cache'].'/admin/' );

  // guardamos la acción en una variable, y si no existe ponemos home.
  $action = isset( $_GET['action'] ) ? $_GET['action'] : 'home' ;

  // aciones validas definidas en un array
  $valid = array ( // nombre => php
                     'home' => 'home',
                     'new' => 'new',
                     'art-delete' => '',
                     'art-edit' => 'edit-art'
                 );

  // lista de páginas a ignorar draw
  $draw_ignore = array (
                        'undefined'=>'undefined',
                       );

  // seleccionamos un driver válido
  $driver = isset( $valid[$action] ) ? 'driver.adm.'.$action.'.php' : 'driver.error.php';

  // asignamos la acción para saber la ubicación
  $rain->assign('action',$action);

  // lo cargamos
  require( 'drivers/'.$driver );

  // dibujamos el archivo correspondiente a la sección siempre que no sea comentario
  if(!isset($draw_ignore[$action]))
   {
    $rain->draw(isset( $valid[$action] ) ? $valid[$action] : 'notfound');
   }

// requerimos el driver.destruct.php para borrar lo que está de mas
require( 'drivers/driver.destruct.php' );

// mostramos el consumo.
#echo('<div class="clear" />Memoria usada: <b>'.roundsize((memory_get_usage() - $memstart), true).'</b> - Tiempo de ejecucion: <b>'.round(microtime(true)-$timestart, 2).' segundos</b></div>');