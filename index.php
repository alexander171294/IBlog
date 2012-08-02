<?php

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

// iniciamos el controlador de bases de datos.
$db = new LittleDB ( $Core->Settings['db_host'] , $Core->Settings['db_user'] , $Core->Settings['db_pass'] , $Core->Settings['db_name'] );

// iniciamos el RAIN TPL
$rain = new RainTPL ();

// configuramos rain
RainConfig();

// incluimos el controlador necesario
require ( $Core->loader() );

// borramos lo que está de más.
UnsetVars();