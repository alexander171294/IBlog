<?php

 /** @I-Blog 1.0
  * class core
  * Clase n�cleo donde se encuentran funciones b�sicas para el sistema
  */

Class Core
 {

   // variables locales de la clase
   Public $Settings = array();

   // funcion de construcci�n de la clase
   Public Function __construct($Settings)
    {
     //pasamos la configuraci�n a la clase
     $this->Settings = $Settings;
    }

   Public Function loader()
    {

     $action = isset( $_GET['action'] ) ? $_GET['action'] : 'home' ;

     //aciones validas
     $valid = array (// nombre => nivel de acceso
                     'home' => '0'
                    );

     // que vamos a retornar?
     $retorno = isset( $valid[$action] ) ? 'drivers/bas.'.$action.'.php' : 'drivers/bas.critical.php';
     return $retorno;
    }

 }