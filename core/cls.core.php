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
   Public $version = '';
   Public $user = null;
   // configuración extra sacada de la db
   Protected $mesettings = array();

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
     $valid = array (// nombre => zona privada = 1
                     'home' => '0',
                     'view_list' => '0',
                     'view_pub' => '0',
                     'admin' => '1',
                     'login' => '0',
                     'registro' => '0'
                    );

     // que vamos a retornar?  aquí está estructurado de forma que se puedan agregar nuevos rangos.
     return isset( $valid[$action] ) && Cuenta::Rango() >= $valid[$action] ? 'drivers/bas.'.$action.'.php' : 'drivers/bas.critical.php';
    }

   Public Function Set_Settings()
    {

     $retorno = $this->db->query('SELECT clave, valor FROM settings',false,false);
     while ( $valores = $retorno->fetchrow() )
      {
       $settings[$valores['clave']] = $valores['valor'];
      }

     $this->rain->assign('presets',$settings);
     $this->mesettings = $settings;
     $this->rain->assign('version',$this->version);
    }

   Public Function Set_Menu()
    {
     $menu = new Menu($this->db);
     $this->rain->assign('menu_lateral',$menu->get_menu(1));
     $this->rain->assign('menu_principal',$menu->get_menu(2));
     $this->rain->assign('menu_afiliados',$menu->get_menu(3));
     $this->rain->assign('menu_inferior',$menu->get_menu(4));
    }

   Public Function Set_Publicaciones()
    {
     $pub = new pubs($this->db);
     $this->rain->assign('list',$pub->get_last_pubs($this->mesettings['pubsforpage']));
    }

   Public Function Set_Pub_for()
    {
     $pub = new pubs($this->db);
     $this->rain->assign('list',$pub->get_last_pubs_for($this->mesettings['pubsforpage']));
    }

   Public Function get_pub_fid()
    {
     $pub = new pubs($this->db);
     $this->rain->assign('pubdata',$pub->get_pub($_GET['id']));
    }

   Public Function login()
    {
     $this->user->login($_POST['user'],$_POST['pass']);
    }

   Public Function registro($captcha)
    {
     $this->user->registro($_POST['user'],$_POST['pass'],$_POST['pass2'],$_POST['captcha'],$captcha);
    }

 }