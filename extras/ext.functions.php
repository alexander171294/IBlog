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
 * ext.functions.php
 *
 * archivo que guarda funciones escenciales para el funcionamiento del script
 *
 * @author  Alexander1712 <alexander171294@live.com>
 * @license http://www.gnu.org/copyleft/gpl.html
 * @link    https://github.com/alexander171294/IBlog
 */

// autor: @Cody Roodaka.
function autoLoadClass($class)
 {
  $target = 'core/cls.'.strtolower($class).'.php';
  if(file_exists($target)) { require($target); }
  else { echo 'Error #1: No existe la clase :'.$target; }
 } // function autoLoadClass();

 // Devuelve el valor redondeado para mejor lectura :P
function roundsize($size, $full = false)
 {
  if($full == true) { $ext = array('Bytes', 'Kilo Bytes', 'Mega Bytes', 'Giga Bytes', 'Tera Byte', 'Peta Byte'); }
  else { $ext = array('b', 'kb', 'mb', 'gb', 'tb', 'pb'); }
  $i = 0;
  while(($size/1024)>1)
   {
    $size=$size/1024;
    $i++;
   }
  return (round($size,2).' '.$ext[$i]);
 } // function roundsize();