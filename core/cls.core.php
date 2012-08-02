<?php

 /** @I-Blog 1.0
  * class core
  * Clase núcleo donde se encuentran funciones básicas para el sistema
  */

Class Core
 {

   // variables locales de la clase
   Public $Settings = array();
   Public $db = null;
   Public $rain = null;

   // funcion de construcción de la clase
   Public Function __construct($Settings)
    {
     //pasamos la configuración a la clase
     $this->Settings = $Settings;
    }

    //función de carga
   Public Function loader()
    {
     //conectamos a la db
     $this->db->connect();

     $action = isset( $_GET['action'] ) ? $_GET['action'] : 'home' ;

     //aciones validas
     $valid = array (// nombre => nivel de acceso
                     'home' => '0'
                    );

     // que vamos a retornar?
     return isset( $valid[$action] ) ? 'drivers/bas.'.$action.'.php' : 'drivers/bas.critical.php';
    }

   Public Function Set_Settings()
    {

     $retorno = $this->db->query('SELECT clave, valor FROM settings',false,false);
     while ( $valores = $retorno->fetchrow() )
      {
       $settings[$valores['clave']] = $valores['valor'];
      }

     $this->rain->assign('presets',$settings);
    }

 }