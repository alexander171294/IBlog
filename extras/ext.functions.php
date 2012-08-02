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
function RainConfig($Core)
 {
    raintpl::configure('base_url', $Core->Settings['site_path']);
                                           // cambiar por la clase theme
    raintpl::configure('tpl_dir', 'themes/'.$Core->Settings['tema'].'/');
    raintpl::configure('cache_dir', $Core->Settings['cache'].'/'.$Core->Settings['tema'].'/');
 }

 // función unset
function UnsetVars()
 {

  //Clases principales
  unset($Core);
  unset($db);
  unset($rain);

  //Clases secundarias
 }