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
function RainConfig()
 {
  RainTPL::tpl_dir = 'tpl/';
	RainTPL::cache_dir = 'tmp/';
	RainTPL::base_url = '';
	RainTPL::tpl_ext = '';
 }