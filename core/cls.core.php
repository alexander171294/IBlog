<?php

/**
 * I-Blog
 *
 * PHP Version 5.3
 *
 * I-Blog es un proyecto Open Source desarrollado para ser r�pido, y sencillo.
 *
 * El repositorio oficial del proyecto lo puedes encontrar un poco m�s abajo,
 * iblog fu� dise�ado para blogs alojados en servidores peque�os
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
 * �sta clase establece los m�todos necesarios para hacer funcionar
 * el sistema de blogs, es el n�cleo del mismo y clase principal.
 * �sta clase contiene la carga de distintas secciones, y otras clases.
 *
 * A tener en cuenta, todas las funciones con prefijo calleable son funciones
 * llamadas por la funci�n __construct seg�n la secci�n del blog en que el
 * usuario se encuentre.
 *
 * @author  Alexander1712 <alexander171294@live.com>
 * @license http://www.gnu.org/copyleft/gpl.html
 * @link    https://github.com/alexander171294/IBlog
 */

Class Core
 {

   // variables locales de la clase //

   // @Settings: variable que guarda la configuraci�n.
   Public $Settings = array();
   // @db: variable que guarda la instancia del controlador de bases de datos littledb.
   Public $db = null;
   // @rain: variable que guarda la instancia del gestor de plantillas RainTPL.
   Protected $rain = null;
   // @version: variable que guarda la versi�n del sistema.
   Protected $version = '';
   // @user: variable que guarda la instancia de la clase user.
   Protected $user = null;
   // @mesettings: configuraci�n extra sacada de la db
   Protected $mesettings = array();

   /**
     * construye la clase, generando instancias necesarias y luego carga la
     * funci�n correspondiente a la secci�n del blog abierta.
     *
     * @param array $Settings la configuraci�n del sitio (archivo ext.settings.php)
     * @param string $version la versi�n del sitio
     *
     * @link WIKI NO DISPONIBLE POR EL MOMENTO
     *
     * @return void
     */
   Public Function __construct($Settings,$version)
    {
     //pasamos la configuraci�n a la clase
     $this->Settings = $Settings;
     // iniciamos el controlador de bases de datos.
     $this->db = new LittleDB ( $this->Settings['db_host'] , $this->Settings['db_user'] , $this->Settings['db_pass'] , $this->Settings['db_name'] );
     // iniciamos el control de usuarios
     $this->user = new Cuenta ( $this->db );
     // iniciamos el RAIN TPL
     $this->rain = new RainTPL ();
     // guardamos la versi�n
     $this->version = $version;

     // configuramos rainTPL
     raintpl::configure('base_url', $this->Settings['site_path']);
     // hay que cambiar esto por la variable contenedora del theme
     raintpl::configure('tpl_dir', 'themes/'.$this->Settings['tema'].'/');
     raintpl::configure('cache_dir', $this->Settings['cache'].'/'.$this->Settings['tema'].'/');

     // conectamos a la db
     $this->db->connect();

     // guardamos la acci�n en una variable, y si no existe ponemos home.
     $action = isset( $_GET['action'] ) ? $_GET['action'] : 'home' ;

     // seteamos configuraci�n b�sica
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
                     'comment' => '',
                     'page' => 'page'
                    );

     // lista de p�ginas a ignorar draw
     $draw_ignore = array (
                           'comment' => 'not_draw'
                          );

     // llamamos a la funci�n correspondiente a la acci�n si es v�lida
     call_user_func(array('core',isset( $valid[$action] ) ? 'calleable_'.$action : 'calleable_error'));
     // dibujamos el archivo correspondiente a la secci�n siempre que no sea comentario
     if(!isset($draw_ignore[$action]))
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

     // asignamos la variable con la configuraci�n b�sica
     $this->rain->assign('presets',$settings);
     // guardamos la configuraci�n en la variable interna, por si luego lo necesitamos
     $this->mesettings = $settings;
     // asignamos la versi�n ya que estamos
     $this->rain->assign('version',$this->version);
    }

    /**
     * obtiene los 4 tipos de menu de la b�se de datos
     * los asigna para luego tenerlos en la plantilla.
     *
     * @see cls.menu.php
     *
     * @link WIKI NO DISPONIBLE POR EL MOMENTO
     *
     * @return void
     */
   Private Function Set_Menu()
    { // *** esto lo acomodar�a por una funci�n sola que retorne un array as� no hacer 4 llamadas
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
     * �sta funci�n se ejecuta cuando no hay acci�n o la variable @action
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
     $this->rain->assign('list',$pub->get_last_pubs($this->pag_limit($this->mesettings['pubsforpage'])));

     /* asignamos el paginado:
        demo del paginado: (est� comentado a prop�sito porque si se descomenta asume que hay 17 p�ginas, es para mostrar su funcionamiento)
        $this->rain->assign('paginate',$this->paginate(3,50,'http://localhost/index.php?action=home'));
        recuerda que para activar este demo tienes que deshabilitar el paginado de las siguientes lineas */

     // obtenemos la cantidad de p�ginas
     $cont = $pub->paginate_last_pubs();
     // asignamos la paginaci�n
     $this->rain->assign('paginate',$this->paginate($this->mesettings['pubsforpage'],$cont,'/index.php?action=home'));
    }

    /**
     * �sta funci�n se ejecuta cuando uno se encuentra en ver una categor�a
     * o ver las publicaciones de un usuario.
     * Se ejecuta cuando la acci�n es view_list
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
     // asignamos la lista de publicaciones de la categor�a o usuario que se pidi�
     $this->rain->assign('list',$pub->get_last_pubs_for($this->pag_limit($this->mesettings['pubsforpage'])));
     // obtenemos la cantidad de p�ginas:
     $cont = $pub->paginate_last_pubs_for();
     // guardamos la url segun el tipo de listado
     $forq = isset($_GET['foruser']) ? '&foruser='.$_GET['foruser'] : '&forcat='.$_GET['forcat'];
     // asignamos la paginaci�n
     $this->rain->assign('paginate',$this->paginate($this->mesettings['pubsforpage'],$cont,'/index.php?action=view_list'.$forq));
    }

    /**
     * �sta funci�n se ejecuta cuando se requiere ver una publicaci�n en espec�fico
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
     // asignamos los datos de la publicaci�n
     $this->rain->assign('pubdata',$pub->get_pub($_GET['id']));
     // asignamos la lista de comentarios
     $this->rain->assign('coments',$pub->get_comments($_GET['id']));
     // seteamos un nuevo captcha
     $captcha->set_value();
     // lo creamos
     $captcha->create();
    }

    /**
     * �sta funci�n se ejecuta cuando se decea ingresar a la cuenta
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
     * �sta funci�n se ejecuta cuando un usuario se decea registrar.
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
    }

   /**
     * �sta funci�n se ejecuta cuando se realiza el submit de un comentario.
     * no tiene dibujo de dise�o, hace una redirecci�n.
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
     // creamos una instancia de la clase pubs
     $pubs = new Pubs($this->db);
     // guardamos el comentario
     $pubs->set_comment();
    }

    /**
     * �sta funci�n se ejecuta cuando se realiza una b�squeda.
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
     // asignamos el paginado para que no de errores
     $this->rain->assign('paginate','');
    }

    /**
     * �sta funci�n se ejecuta cuando la secci�n del blog que se requiere
     * no existe o no es v�lida, es para guardar un log de errores.
     *
     * @see ...
     *
     * @link WIKI NO DISPONIBLE POR EL MOMENTO
     *
     * @return void
     */
   Private Function calleable_error()
    {
     // aqu� ir� log de error
    }

   /**
     * �sta funci�n se ejecuta en los listados y generalmente se asigna a la
     * variable Paginate.
     * tira un listado de p�ginas
     *
     * @param (int) $max m�ximo de publicaciones por p�gina
     * @param (int) $cantidad cantidad de publicaciones a mostrar
     * @param string $url url del sitio para generar links
     *        ejemplo:
     *        http://miweb.com/ o http://miweb.com/alex.php
     *        o http://miweb.com/alex.php?asd=kasd
     *
     * @link WIKI NO DISPONIBLE POR EL MOMENTO
     *
     * @return string/HTML
     */
   Private Function paginate ( $max, $cantidad, $url )
    {
     //@advance: la cantidad de p�ginas siguientes y anteriores a mostrar
     $advance = 3;
     // guardamos la p�gina por la que est�, y si no existe tal p�gina ponemos 1
     $actual = isset($_GET['p-id']) ? $_GET['p-id'] : 1;
     // obtenemos la cantidad de p�ginas
     $pags = ceil($cantidad/$max);
     // si no hay p�ginas mostramos que es la n�mero 1...
     if($pags == 0) {$pags = 1;}
     // seteamos @next vac�o
     $next = ''; $pn = $actual+1;
     // obtenemos las siguientes p�ginas
     while ($pn<=$actual+$advance && $pn<=$pags)
      {
       $next .= ' <a href="'.$url.'&p-id='.$pn.'">['.$pn.']</a>';
       $pn++;
      }
     /* si hay m�s p�ginas para mostrar osea que si la actual menos la cantidad
        total es mayor a la cantidad a mostrar agregamos puntos suspensivos    */
     if($pags-$actual>$advance) { $next .= '...'; }
     // seteamos @prev vac�o
     $prev = ''; $pv = $actual-1;
     // obtenemos las previas
     while ($pv>=$actual-$advance && $pv>0)
      {
       $prev = ' <a href="'.$url.'&p-id='.$pv.'">['.$pv.']</a>'.$prev;
       $pv--;
      }
     // si el numero actual de p�gina es mayor a las paginas que se muestran entonces poner puntos suspensivos
     if($actual>$advance+1) { $prev = '...'.$prev; }
     // retornamos el listado
     return '<a href="'.$url.'&p-id=1" title="Primera P&aacute;gina">[<]</a> '.$prev.' ['.$actual.'] '.$next.' <a href="'.$url.'&p-id='.$pags.'" title="&Uacute;ltima P&aacute;gina">[>]</a>';
    }

    /**
     * �sta funci�n se ejecuta en los listados y se utiliza para obtener el
     * limit correspondiente para solicitar la lista de publicaciones
     *
     * @param (int) $max m�ximo de publicaciones por p�gina
     *
     * @link WIKI NO DISPONIBLE POR EL MOMENTO
     *
     * @return string/HTML
     */
   Private function pag_limit ( $max )
    {
     // guardamos la p�gina por la que est�, y si no existe tal p�gina ponemos 0
     $actual = isset($_GET['p-id']) ? $_GET['p-id'] : 1;
     // sacamos la cuenta de cuanto es lo que llevamos mostrado
     $comienzo = ($actual-1) * $max;
     // devolvemos desde donde tiene que empezar y hasta donde tiene que terminar.
     return $comienzo.','.$max;
    }

   /**
     * �sta funci�n se ejecuta cuando se requiere ver una p�gina fija
     *
     * @see cls.pages.php
     *
     * @link WIKI NO DISPONIBLE POR EL MOMENTO
     *
     * @return void
     */
   Private Function calleable_page()
    {
     // creamos la instancia de la clase pasandole la db
     $page = new pages($this->db);
     // asignamos los datos de la publicaci�n
     $this->rain->assign('pubdata',$page->get_pag($_GET['id']));
    }

 }