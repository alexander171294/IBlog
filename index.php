<?php

// contador de recursos
$timestart = microtime(true);
$memstart = memory_get_usage();

// versi�n
$version = '1.0';

/** @I-blog 1.0
 *  desarrollado por Alexander1712
 *  archivo principal index.php
 */

// cargamos funciones b�sicas
require('extras/ext.functions.php');

// iniciamos autoload
InitAutoLoad();

// iniciamos la clase core y le mandamos la configuraci�n
$Core = new Core ( include ( 'extras/ext.settings.php' ), $version );

// configuramos rain
RainConfig($Core);

// cargamos y ejecutamos el nucleo del sistema
$Core->boot();

// finalizamos el core
unset($Core);

echo('Memoria usada: <b>'.roundsize((memory_get_usage() - $memstart), true).'</b> - Tiempo de ejecucion: <b>'.round(microtime(true)-$timestart, 2).' segundos</b>');
