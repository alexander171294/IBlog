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
   Protected $rain = null;
   Protected $version = '';
   Protected $user = null;

   // configuración extra sacada de la db
   Protected $mesettings = array();

   // funcion de construcción de la clase
   Public Function __construct($Settings,$version)
    {
     //pasamos la configuración a la clase
     $this->Settings = $Settings;
     // iniciamos el controlador de bases de datos.
     $this->db = new LittleDB ( $this->Settings['db_host'] , $this->Settings['db_user'] , $this->Settings['db_pass'] , $this->Settings['db_name'] );
     // iniciamos el control de usuarios
     $this->user = new Cuenta ( $this->db );
     // iniciamos el RAIN TPL
     $this->rain = new RainTPL ();
     // guardamos la versión
     $this->version = $version;
     //por defecto hacemos el draw a rain
     $rain_draw = true;

     //configuramos rainTPL
     raintpl::configure('base_url', $this->Settings['site_path']);
     // cambiar por la clase theme
     raintpl::configure('tpl_dir', 'themes/'.$this->Settings['tema'].'/');
     raintpl::configure('cache_dir', $this->Settings['cache'].'/'.$this->Settings['tema'].'/');

     //conectamos a la db
     $this->db->connect();

     $action = isset( $_GET['action'] ) ? $_GET['action'] : 'home' ;

     // seteamos configuración básica
     $this->Set_Settings();
     // seteamos menues
     $this->Set_Menu();

     //aciones validas
     $valid = array (// nombre => html
                     'home' => 'index',
                     'view_list' => 'index',
                     'view_pub' => 'view',
                     'admin' => '1',
                     'login' => 'login',
                     'registro' => 'registro',
                     'search' => 'index'
                    );

     //llamamos a la función correspondiente a la acción
     call_user_func(array('core',isset( $valid[$action] ) ? 'calleable_'.$action : 'calleable_error'));

     // levantamos el archivo de template correspondiente //
     if($action != 'comment')
     {
     $this->rain->draw(isset( $valid[$action] ) ? $valid[$action] : 'notfound');
     }
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

   Private Function calleable_home()
    {
     $pub = new pubs($this->db);
     $this->rain->assign('list',$pub->get_last_pubs($this->mesettings['pubsforpage']));
    }

   Private Function calleable_view_list()
    {
     $pub = new pubs($this->db);
     $this->rain->assign('list',$pub->get_last_pubs_for($this->mesettings['pubsforpage']));
    }

   Private Function calleable_view_pub()
    {
     $pub = new pubs($this->db);
     $this->rain->assign('pubdata',$pub->get_pub($_GET['id']));
     $this->rain->assign('coments',$pub->get_comments($_GET['id']));
    }

   Private Function calleable_login()
    {
     if(isset($_POST['posteado']))
        {
         $this->user->login($_POST['user'],$_POST['pass']);
        }
    }

   // registro
   Private Function calleable_registro()
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

   Private Function calleable_comment()
    {
     $id = (int) $_POST['id'];
     // ejecutamos el post
     if(!empty($_POST['name']) && $id !== 0 && !empty($_POST['email']) && !empty($_POST['message']) && strlen($_POST['name'])>3 && strlen($_POST['email'])>15)
      {
       $this->db->insert('comentarios',array('Name' => $_POST['name'], 'email' => $_POST['email'], 'web' => empty($_POST['web']) ? '/' : $_POST['web'], 'coment' => $_POST['message'], 'pub' => $id, 'fecha' => time()));
      }
     //redireccionamos:
     header('Location: index.php?action=view_pub&id='.$id);
    }

   Private Function calleable_search()
    {
     $pubs = new Pubs($this->db);
     $this->rain->assign('list',$pubs->search($_POST['texto'],$this->mesettings['pubsforpage']));
    }

   Private Function calleable_error()
    {
     //aquí irá log de error
    }

 }