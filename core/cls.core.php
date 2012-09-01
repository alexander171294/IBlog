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
   Public $rain = null;
   // @version: variable que guarda la versión del sistema.
   Private $version = '';
   // @mesettings: configuración extra sacada de la db
   Public $mesettings = array();

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
   Public Function __construct($rain, $Settings, $db, $version)
    {
     // pasamos la configuración a la clase
     $this->Settings = $Settings;
     // verificamos que el archivo de configuración esté armado
     if(empty($Settings['db_host'])) { die ('Debe configurar el archivo ext.settings.php'); }
     // iniciamos el controlador de bases de datos.
     $this->db = $db;
     // iniciamos el RAIN TPL
     $this->rain = $rain;
     // guardamos la versión
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

     // asignamos la variable con la configuración básica
     $this->rain->assign('presets',$settings);
     // asignamos el tema
     $this->rain->assign('tema',$this->Settings['tema']);
     // guardamos la configuración en la variable interna, por si luego lo necesitamos
     $this->mesettings = $settings;
     // asignamos la versión ya que estamos
     $this->rain->assign('version',$this->version);
    }

   /**
     * Ésta función se ejecuta en los listados y generalmente se asigna a la
     * variable Paginate.
     * tira un listado de páginas
     *
     * @param (int) $max máximo de publicaciones por página
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
     //@advance: la cantidad de páginas siguientes y anteriores a mostrar
     $advance = 3;
     // guardamos la página por la que está, y si no existe tal página ponemos 1
     $actual = isset($_GET['p-id']) ? $_GET['p-id'] : 1;
     // obtenemos la cantidad de páginas
     $pags = ceil($cantidad/$max);
     // si no hay páginas mostramos que es la número 1...
     if($pags == 0) {$pags = 1;}
     // seteamos @next vacío
     $next = ''; $pn = $actual+1;
     // obtenemos las siguientes páginas
     while ($pn<=$actual+$advance && $pn<=$pags)
      {
       $next .= ' <a href="'.$url.'&p-id='.$pn.'">['.$pn.']</a>';
       $pn++;
      }
     /* si hay más páginas para mostrar osea que si la actual menos la cantidad
        total es mayor a la cantidad a mostrar agregamos puntos suspensivos    */
     if($pags-$actual>$advance) { $next .= '...'; }
     // seteamos @prev vacío
     $prev = ''; $pv = $actual-1;
     // obtenemos las previas
     while ($pv>=$actual-$advance && $pv>0)
      {
       $prev = ' <a href="'.$url.'&p-id='.$pv.'">['.$pv.']</a>'.$prev;
       $pv--;
      }
     // si el numero actual de página es mayor a las paginas que se muestran entonces poner puntos suspensivos
     if($actual>$advance+1) { $prev = '...'.$prev; }
     // retornamos el listado
     return '<a href="'.$url.'&p-id=1" title="Primera P&aacute;gina">[<]</a> '.$prev.' ['.$actual.'] '.$next.' <a href="'.$url.'&p-id='.$pags.'" title="&Uacute;ltima P&aacute;gina">[>]</a>';
    }

    /**
     * Ésta función se ejecuta en los listados y se utiliza para obtener el
     * limit correspondiente para solicitar la lista de publicaciones
     *
     * @param (int) $max máximo de publicaciones por página
     *
     * @link WIKI NO DISPONIBLE POR EL MOMENTO
     *
     * @return string/HTML
     */
   Public function pag_limit ( $max )
    {
     // guardamos la página por la que está, y si no existe tal página ponemos 0
     $actual = isset($_GET['p-id']) ? $_GET['p-id'] : 1;
     // sacamos la cuenta de cuanto es lo que llevamos mostrado
     $comienzo = ($actual-1) * $max;
     // devolvemos desde donde tiene que empezar y hasta donde tiene que terminar.
     return $comienzo.','.$max;
    }
    
   /**
     * Ésta función inicia el seo
     *
     * @link WIKI NO DISPONIBLE POR EL MOMENTO
     *
     * @return boolean
     */
   Public Function setbbc()
    {
     // incluimos el archivo de configuración
     include('extras/ext.bbcode.php');
    }

   /**
     * Ésta función se ejecuta cuando se verifica la instalación
     *
     * @link WIKI NO DISPONIBLE POR EL MOMENTO
     *
     * @return boolean
     */
    Public Function install()
     {
      // listamos todas las tablas y si existe alguna tabla damos por hecho que se instaló
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