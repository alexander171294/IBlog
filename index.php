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
 * index.php
 *
 * �ste archivo es el cargador, se encarga de cargar la clase core, incluir la
 * configuraci�n, las funciones extras, la versi�n, y cuenta el tiempo de
 * ejecuci�n. adem�s activa la autocarga de clases.
 *
 * @author  Alexander1712 <alexander171294@live.com>
 * @license http://www.gnu.org/copyleft/gpl.html
 * @link    https://github.com/alexander171294/IBlog
 */

// contador de recursos
$timestart = microtime( true );
$memstart = memory_get_usage();

// cargamos funciones b�sicas
require( 'extras/ext.functions.php' );

// Iniciamos el proceso de carga automatica de clases para el nucleo.
spl_autoload_register( 'autoLoadClass' );

// inclu�mos la configuraci�n
$Settings = include ( 'extras/ext.settings.php' );

// mostrar errores o no mostrarlos
ini_set('display_errors', $Settings['dev-mode']);

// creamos una instancia de la db
$db = new LittleDB ( $Settings['db_host'] , $Settings['db_user'] , $Settings['db_pass'] , $Settings['db_name'] );

// creamos la instancia para manejar las cuentas de usuario
$cuenta = new Cuenta ( $db );

// creamos la instancia de rainTPL
$rain = new RainTPL ();

// iniciamos la clase core y le mandamos la configuraci�n
$Core = new Core ( $rain, $Settings , $db , IBLOGVERSION );

// conectamos a la db
$db->connect();

// declaramos el error de NOT FOUND (no encontrado) en falso
$ERROR_NF = FALSE;

// $core->install devuelve true si est� instalado y false si no.
if($Core->install())
 {
  // islogged
  $rain->assign('islogged',$cuenta->IsLogged());
  // si est� loggeado
  if($cuenta->IsLogged())
   {
    // asignamos el nombre
    $rain->assign('UName',$cuenta->Get_Name());
    // rango
    $rain->assign('rango',$cuenta->Rango());
   }
  else
   {
    // rango
    $rain->assign('rango',0);
   }

  // seteamos configuraci�n b�sica
  $Core->Set_Settings();

  // configuramos rainTPL //
  // la url base
  raintpl::configure( 'base_url', $Core->Settings['site_path'] );
  // la direcci�n del theme
  raintpl::configure( 'tpl_dir', 'themes/'.$Core->mesettings['design'].'/' );
  // la direcci�n del cach� del theme
  raintpl::configure( 'cache_dir', $Core->Settings['cache'].'/'.$Core->mesettings['design'].'/' );

  // guardamos la acci�n en una variable, y si no existe ponemos home.
  $action = isset( $_GET['action'] ) ? $_GET['action'] : 'home' ;

  // aciones validas definidas en un array
  $valid = array ( // nombre => php
                     'home' => 'index',
                     'view_list' => 'index',
                     'view_pub' => 'view',
                     'admin' => '1',
                     'login' => 'login',
                     'registro' => 'registro',
                     'search' => 'index',
                     'comment' => '',
                     'page' => 'page',
                     'logout' => ''
                 );

  // lista de p�ginas a ignorar draw
  $draw_ignore = array (
                           'comment' => 'not_draw',
                           'logout' => 'not_draw'
                       );

  // seleccionamos un driver v�lido
  $driver = isset( $valid[$action] ) ? 'driver.'.$action.'.php' : 'driver.error.php';
  // lo cargamos
  require( 'drivers/'.$driver );

  // dibujamos el archivo correspondiente a la secci�n siempre que no sea comentario
  if(!isset($draw_ignore[$action]))
   {
    $rain->draw(isset( $valid[$action] ) && $ERROR_NF == FALSE ? $valid[$action] : 'notfound');
   }
 }
else
 {
  // inicia la instalaci�n
  require ( 'drivers/driver.install.php' );
 }

// requerimos el driver.destruct.php para borrar lo que est� de mas
require( 'drivers/driver.destruct.php' );

// mostramos el consumo si estamos en modo developer.
if($Settings['dev-mode'] == TRUE) { echo('<div class="clear" />Memoria usada: <b>'.roundsize((memory_get_usage() - $memstart), true).'</b> - Tiempo de ejecucion: <b>'.round(microtime(true)-$timestart, 2).' segundos</b></div>'); }

