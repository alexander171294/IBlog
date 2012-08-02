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
   Public Function boot()
    {
     //conectamos a la db
     $this->db->connect();

     $action = isset( $_GET['action'] ) ? $_GET['action'] : 'home' ;

     // seteamos configuración básica
     $this->Set_Settings();
     // seteamos menues
     $this->Set_Menu();

     //llamamos a la función correspondiente a la acción
     if ($action == 'home')
      {
       $this->Set_Publicaciones();
      }
     // login
     elseif ($action == 'login')
      {
       if(isset($_POST['posteado']))
        {
         $this->login();
        }
      }
     //registro
     elseif ($action == 'registro')
      {
       $this->registro();
      }
     // ver lista de ultimas publicaciones en orden.
     elseif ($action == 'view_list')
      {
       $this->Set_Pub_for();
      }
     // ver una publicación
     elseif ($action == 'view_pub')
      {
       $this->get_pub_fid();
      }

     //aciones validas
     $valid = array (// nombre => html
                     'home' => 'index',
                     'view_list' => 'index',
                     'view_pub' => 'view',
                     'admin' => '1',
                     'login' => 'login',
                     'registro' => 'registro'
                    );

     // levantamos el archivo de template correspondiente //
     $this->rain->draw(isset( $valid[$action] ) ? $valid[$action] : 'notfound');
    }

   Private Function Set_Settings()
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

   Private Function Set_Menu()
    {
     $menu = new Menu($this->db);
     $this->rain->assign('menu_lateral',$menu->get_menu(1));
     $this->rain->assign('menu_principal',$menu->get_menu(2));
     $this->rain->assign('menu_afiliados',$menu->get_menu(3));
     $this->rain->assign('menu_inferior',$menu->get_menu(4));
    }

   Private Function Set_Publicaciones()
    {
     $pub = new pubs($this->db);
     $this->rain->assign('list',$pub->get_last_pubs($this->mesettings['pubsforpage']));
    }

   Private Function Set_Pub_for()
    {
     $pub = new pubs($this->db);
     $this->rain->assign('list',$pub->get_last_pubs_for($this->mesettings['pubsforpage']));
    }

   Private Function get_pub_fid()
    {
     $pub = new pubs($this->db);
     $this->rain->assign('pubdata',$pub->get_pub($_GET['id']));
    }

   Private Function login()
    {
     $this->user->login($_POST['user'],$_POST['pass']);
    }

   // registro
   Private Function registro()
    {
     $captcha = new Captcha('files/');
       if(isset($_POST['posteado']))
        {
         $this->user->registro($_POST['user'],$_POST['pass'],$_POST['pass2'],$_POST['captcha'],$captcha);
        }
       $captcha->set_value();
       $captcha->create();
       unset($captcha);
    }
 }