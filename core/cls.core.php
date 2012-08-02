<?php

 /** @I-Blog 1.0
  * class core
  * Clase núcleo donde se encuentran funciones básicas para el sistema
  */

Class Core
 {

   // variables locales de la clase
   Public $Settings = array();

   // funcion de construcción de la clase
   Public Function __construct($Settings)
    {
     //pasamos la configuración a la clase
     $this->Settings = $Settings;
    }

 }