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
$timestart = microtime(true);
$memstart = memory_get_usage();

// versi�n
define('IBLOGVERSION', '1.0');

// cargamos funciones b�sicas
require('extras/ext.functions.php');

// Iniciamos el proceso de carga automatica de clases para el nucleo.
spl_autoload_register('autoLoadClass');

// iniciamos la clase core y le mandamos la configuraci�n
$Core = new Core ( include ( 'extras/ext.settings.php' ), IBLOGVERSION );

// finalizamos el core
unset($Core);

// mostramos el consumo.
echo('<div class="clear" />Memoria usada: <b>'.roundsize((memory_get_usage() - $memstart), true).'</b> - Tiempo de ejecucion: <b>'.round(microtime(true)-$timestart, 2).' segundos</b></div>');
