<?php

// contador de recursos
$timestart = microtime(true);
$memstart = memory_get_usage();

// versión
$version = '1.0';

/** @I-blog 1.0
 *  desarrollado por Alexander1712
 *  archivo principal index.php
 */

// cargamos funciones básicas
require('extras/ext.functions.php');

// iniciamos autoload
InitAutoLoad();

// iniciamos la clase core y le mandamos la configuración
$Core = new Core ( include ( 'extras/ext.settings.php' ) );

//establecemos la versión
$Core->version = $version;

// iniciamos el controlador de bases de datos.
$Core->db = new LittleDB ( $Core->Settings['db_host'] , $Core->Settings['db_user'] , $Core->Settings['db_pass'] , $Core->Settings['db_name'] );

// iniciamos el control de usuarios
$Core->user = new Cuenta ( $Core->db );

// iniciamos el RAIN TPL
$Core->rain = new RainTPL ();

// configuramos rain
RainConfig($Core);

// incluimos el controlador necesario
require ( $Core->loader() );

echo('Memoria usada: <b>'.roundsize((memory_get_usage() - $memstart), true).'</b> - Tiempo de ejecucion: <b>'.round(microtime(true)-$timestart, 2).' segundos</b> - Consultas a la db: <b>'.$Core->db->count.'</b>');
