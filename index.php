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
$timestart = microtime(true);
$memstart = memory_get_usage();

// versión
define('IBLOGVERSION', '1.0');

// cargamos funciones básicas
require('extras/ext.functions.php');

// Iniciamos el proceso de carga automatica de clases para el nucleo.
spl_autoload_register('autoLoadClass');

// iniciamos la clase core y le mandamos la configuración
$Core = new Core ( include ( 'extras/ext.settings.php' ), IBLOGVERSION );

// finalizamos el core
unset($Core);

// mostramos el consumo.
echo('<div class="clear" />Memoria usada: <b>'.roundsize((memory_get_usage() - $memstart), true).'</b> - Tiempo de ejecucion: <b>'.round(microtime(true)-$timestart, 2).' segundos</b></div>');
