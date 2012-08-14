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
   Public $rain = null;
   // @version: variable que guarda la versi�n del sistema.
   Private $version = '';
   // @user: variable que guarda la instancia de la clase user.
   Protected $user = null;
   // @mesettings: configuraci�n extra sacada de la db
   Public $mesettings = array();

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
   Public Function __construct($rain, $cuenta, $Settings, $db, $version)
    {
     // pasamos la configuraci�n a la clase
     $this->Settings = $Settings;
     // verificamos que el archivo de configuraci�n est� armado
     if(empty($Settings['db_host'])) { die ('Debe configurar el archivo ext.settings.php'); }
     // iniciamos el controlador de bases de datos.
     $this->db = $db;
     // iniciamos el control de usuarios
     $this->user = $cuenta;
     // iniciamos el RAIN TPL
     $this->rain = $rain;
     // guardamos la versi�n
     $this->version = $version;
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
   Public Function Set_Settings()
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
   Public Function paginate ( $max, $cantidad, $url )
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
   Public function pag_limit ( $max )
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

   /**
     * �sta funci�n se ejecuta cuando se verifica la instalaci�n
     *
     * @link WIKI NO DISPONIBLE POR EL MOMENTO
     *
     * @return boolean
     */
    Public Function install()
     {
      // listamos todas las tablas y si existe alguna tabla damos por hecho que se instal�
      if ($this->db->query('SHOW TABLES',false,true))
       {
        // retornamos true
        return true;
       }
      else
       {
        // retornamos false
        return false;
       }
     }
 }