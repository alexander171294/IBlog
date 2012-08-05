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
 * cls.core.php
 *
 * Ésta clase establece los métodos necesarios para hacer funcionar
 * el sistema de blogs, es el núcleo del mismo y clase principal.
 * Ésta clase contiene la carga de distintas secciones, y otras clases.
 *
 * A tener en cuenta, todas las funciones con prefijo calleable son funciones
 * llamadas por la función __construct según la sección del blog en que el
 * usuario se encuentre.
 *
 * @author  Alexander1712 <alexander171294@live.com>
 * @license http://www.gnu.org/copyleft/gpl.html
 * @link    https://github.com/alexander171294/IBlog
 */

Class Core
 {

   // variables locales de la clase //

   // @Settings: variable que guarda la configuración.
   Public $Settings = array();
   // @db: variable que guarda la instancia del controlador de bases de datos littledb.
   Public $db = null;
   // @rain: variable que guarda la instancia del gestor de plantillas RainTPL.
   Protected $rain = null;
   // @version: variable que guarda la versión del sistema.
   Protected $version = '';
   // @user: variable que guarda la instancia de la clase user.
   Protected $user = null;
   // @mesettings: configuración extra sacada de la db
   Protected $mesettings = array();

   /**
     * construye la clase, generando instancias necesarias y luego carga la
     * función correspondiente a la sección del blog abierta.
     *
     * @param array $Settings la configuración del sitio (archivo ext.settings.php)
     * @param string $version la versión del sitio
     *
     * @link WIKI NO DISPONIBLE POR EL MOMENTO
     *
     * @return void
     */
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
     // por defecto hacemos el draw a rain
     $rain_draw = true;

     // configuramos rainTPL
     raintpl::configure('base_url', $this->Settings['site_path']);
     // hay que cambiar esto por la variable contenedora del theme
     raintpl::configure('tpl_dir', 'themes/'.$this->Settings['tema'].'/');
     raintpl::configure('cache_dir', $this->Settings['cache'].'/'.$this->Settings['tema'].'/');

     // conectamos a la db
     $this->db->connect();

     // guardamos la acción en una variable, y si no existe ponemos home.
     $action = isset( $_GET['action'] ) ? $_GET['action'] : 'home' ;

     // seteamos configuración básica
     $this->Set_Settings();
     // seteamos menues
     $this->Set_Menu();

     // aciones validas definidas en un array
     $valid = array ( // nombre => html
                     'home' => 'index',
                     'view_list' => 'index',
                     'view_pub' => 'view',
                     'admin' => '1',
                     'login' => 'login',
                     'registro' => 'registro',
                     'search' => 'index',
                     'comment' => ''
                    );

     // llamamos a la función correspondiente a la acción si es válida
     call_user_func(array('core',isset( $valid[$action] ) ? 'calleable_'.$action : 'calleable_error'));

     // dibujamos el archivo correspondiente a la sección siempre que no sea comentario
     if($action != 'comment')
      {
       $this->rain->draw(isset( $valid[$action] ) ? $valid[$action] : 'notfound');
      }
    }

    /**
     * obtiene toda la tabla settings en un array
     * para luego ponerlo en la variable interna settings.
     *
     *
     * @link WIKI NO DISPONIBLE POR EL MOMENTO
     *
     * @return array(clave=>valor);
     */
   Private Function Set_Settings()
    {
     // ejecutamos la consulta de la tabla settings y guardamos una instancia de objeto de littleDB.
     $retorno = $this->db->query('SELECT clave, valor FROM settings',false,false);
     // recorremos todos los valores obtenidos
     while ( $valores = $retorno->fetchrow() )
      {
       // los vamos metiendo en un array
       $settings[$valores['clave']] = $valores['valor'];
      }

     // asignamos la variable con la configuración básica
     $this->rain->assign('presets',$settings);
     // guardamos la configuración en la variable interna, por si luego lo necesitamos
     $this->mesettings = $settings;
     // asignamos la versión ya que estamos
     $this->rain->assign('version',$this->version);
    }

    /**
     * obtiene los 4 tipos de menu de la báse de datos
     * los asigna para luego tenerlos en la plantilla.
     *
     * @see cls.menu.php
     *
     * @link WIKI NO DISPONIBLE POR EL MOMENTO
     *
     * @return void
     */
   Private Function Set_Menu()
    {
     // crear una instancia de la clase (recordar que tenemos autocarga de clases activado)
     $menu = new Menu($this->db);
     // asignamos el menu lateral
     $this->rain->assign('menu_lateral',$menu->get_menu(1));
     // asignamos el menu principal
     $this->rain->assign('menu_principal',$menu->get_menu(2));
     // asignamos el menu de afiliados
     $this->rain->assign('menu_afiliados',$menu->get_menu(3));
     // asignamos el menu inferior
     $this->rain->assign('menu_inferior',$menu->get_menu(4));
    }

   /**
     * Ésta función se ejecuta cuando no hay acción o la variable @action
     * que ingresa por get, tiene el valor de home.
     *
     * @see cls.pubs.php
     *
     * @link WIKI NO DISPONIBLE POR EL MOMENTO
     *
     * @return void
     */
   Private Function calleable_home()
    {
     // creamos una clase para las publicaciones
     $pub = new pubs($this->db);
     // listamos y mandamos a rain, las ultimas publicaciones
     $this->rain->assign('list',$pub->get_last_pubs($this->mesettings['pubsforpage']));
    }

    /**
     * Ésta función se ejecuta cuando uno se encuentra en ver una categoría
     * o ver las publicaciones de un usuario.
     * Se ejecuta cuando la acción es view_list
     *
     * @see cls.pubs.php
     *
     * @link WIKI NO DISPONIBLE POR EL MOMENTO
     *
     * @return void
     */
   Private Function calleable_view_list()
    {
     // creamos la instancia de la clase pasandole la db
     $pub = new pubs($this->db);
     // asignamos la lista de publicaciones de la categoría o usuario que se pidió
     $this->rain->assign('list',$pub->get_last_pubs_for($this->mesettings['pubsforpage']));
    }

    /**
     * Ésta función se ejecuta cuando se requiere ver una publicación en específico
     *
     * @see cls.pubs.php
     * @see cls.captcha.php
     *
     * @link WIKI NO DISPONIBLE POR EL MOMENTO
     *
     * @return void
     */
   Private Function calleable_view_pub()
    {
     // creamos la instancia de la clase pasandole la db
     $pub = new pubs($this->db);
     // creamos una instancia para el captcha para los comentarios
     $captcha = new Captcha('files/');
     // asignamos los datos de la publicación
     $this->rain->assign('pubdata',$pub->get_pub($_GET['id']));
     // asignamos la lista de comentarios
     $this->rain->assign('coments',$pub->get_comments($_GET['id']));
     // seteamos un nuevo captcha
     $captcha->set_value();
     // lo creamos
     $captcha->create();
     // destruimos la instancia de la clase captcha
     unset($captcha);
    }

    /**
     * Ésta función se ejecuta cuando se decea ingresar a la cuenta
     * Se ejecuta cuando la variable @action que ingresa por get es login
     *
     * @link WIKI NO DISPONIBLE POR EL MOMENTO
     *
     * @return void
     */
   Private Function calleable_login()
    {
     // si se hizo el submit del formulario
     if(isset($_POST['posteado']))
        {
         // intentamos ingresar con los datos recividos
         $this->user->login($_POST['user'],$_POST['pass']);
        }
    }

   /**
     * Ésta función se ejecuta cuando un usuario se decea registrar.
     * La variable @action debe ser igual a "registro".
     *
     * @see cls.captcha.php
     *
     * @link WIKI NO DISPONIBLE POR EL MOMENTO
     *
     * @return void
     */
   Private Function calleable_registro()
    {
     // creamos la instancia de la clase captcha
     $captcha = new Captcha('files/');
      // si se hiso el submit del formulario de registro
       if(isset($_POST['posteado']))
        {
         // intentamos registrarnos
         $this->user->registro($_POST['user'],$_POST['pass'],$_POST['pass2'],$_POST['captcha'],$captcha);
        }
       // seteamos un nuevo captcha
       $captcha->set_value();
       // creamos la imagen final
       $captcha->create();
       // destruimos la instancia de la clase
       unset($captcha);
    }

   /**
     * Ésta función se ejecuta cuando se realiza el submit de un comentario.
     * no tiene dibujo de diseño, hace una redirección.
     * El valor de la variable @action debe ser comment
     *
     * @see cls.captcha.php
     *
     * @link WIKI NO DISPONIBLE POR EL MOMENTO
     *
     * @return void
     */
   Private Function calleable_comment()
    {
     // creamos una instancia de la clase captcha
     $captcha = new Captcha('files/');
     // filtramos el id que ingresa
     $id = (int) $_POST['id'];
     // si los datos son correctos
     if(!empty($_POST['name']) && $id !== 0 && !empty($_POST['email']) && !empty($_POST['message']) && strlen($_POST['name'])>3 && strlen($_POST['email'])>15 && $captcha->check($_POST['captcha'])===true)
      {
       // ejecutamos la consulta para registrar un nuevo usuario
       $this->db->insert('comentarios',array('Name' => $_POST['name'], 'email' => $_POST['email'], 'web' => empty($_POST['web']) ? '/' : $_POST['web'], 'coment' => nl2br($_POST['message']), 'pub' => $id, 'fecha' => time()));
      }
     // destruimos la clase captcha
     unset($captcha);
     //redireccionamos:
     header('Location: index.php?action=view_pub&id='.$id);
    }

    /**
     * Ésta función se ejecuta cuando se realiza una búsqueda.
     * y asigna un listado de publicaciones que cumplan los requisitos de la
     * busqueda.
     *
     * @see cls.pubs.php
     *
     * @link WIKI NO DISPONIBLE POR EL MOMENTO
     *
     * @return void
     */
   Private Function calleable_search()
    {
     // creamos una instancia de la clase pubs
     $pubs = new Pubs($this->db);
     // asignamos el listado de publicaciones encontradas
     $this->rain->assign('list',$pubs->search($_POST['texto'],$this->mesettings['pubsforpage']));
    }

    /**
     * Ésta función se ejecuta cuando la sección del blog que se requiere
     * no existe o no es válida, es para guardar un log de errores.
     *
     * @see ...
     *
     * @link WIKI NO DISPONIBLE POR EL MOMENTO
     *
     * @return void
     */
   Private Function calleable_error()
    {
     // aquí irá log de error
    }

 }