<?php

 /** @I-Blog 1.0
  *  archivo de funciones
  */

function InitAutoLoad()
 {
  // Iniciamos el proceso de carga automatica de librerias.
  spl_autoload_register('autoLoadClass');
 }

// autor: @Cody Roodaka.
function autoLoadClass($class)
 {
  $target = 'core/cls.'.strtolower($class).'.php';
  if(file_exists($target)) { require($target); }
  else { echo 'Error #1: No existe la clase :'.$target; }
 } // function autoLoadClass();

 // configurar rainTPL
/*function RainConfig($Core)
 {
    raintpl::configure('base_url', $Core->Settings['site_path']);
    // cambiar por la clase theme
    raintpl::configure('tpl_dir', 'themes/'.$Core->Settings['tema'].'/');
    raintpl::configure('cache_dir', $Core->Settings['cache'].'/'.$Core->Settings['tema'].'/');
 }*/

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