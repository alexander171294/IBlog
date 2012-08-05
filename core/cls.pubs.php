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
 * cls.pubs.php
 *
 * �sta clase se encarga de gestionar las publicaciones y comentarios de las
 * mismas.
 *
 * @author  Alexander1712 <alexander171294@live.com>
 * @license http://www.gnu.org/copyleft/gpl.html
 * @link    https://github.com/alexander171294/IBlog
 */

Class Pubs
 {

  // variables locales de la clase //

  // @db: contiene la instancia de la clase controladora de db, littledb
  Private $db = null;

  /**
     * construye la clase, generando instancias necesarias y luego carga la
     * funci�n correspondiente a la secci�n del blog abierta.
     *
     * @param instance $db instancia de la clase gestionadora de b�se de datos.
     *
     * @link WIKI NO DISPONIBLE POR EL MOMENTO
     *
     * @return void
     */
  Public Function __construct($db)
   {
    // guardamos la instancia en la variable interna
    $this->db = $db;
   }

  /**
     * obtiene las �ltimas publicaciones para armar el home.
     *
     * @param (int) $max valor m�ximo de publicaciones a listar.
     *
     * @link WIKI NO DISPONIBLE POR EL MOMENTO
     *
     * @return array( (int) => array( 'pub_id'=>string, 'cat_id'=>string, 'cat_nombre'=>string, 'u_nombre'=>string, 'u_id'=>(int), 'pub_nombre'=>string, 'pub_comentario'=>string, 'pub_fecha'=>(int) ) )
     */
  Public Function get_last_pubs($max)
   {
    // obtenemos las ultimas publicaciones limitando segun el contenido de $max
    $result = $this->db->query('SELECT p.pub_id, p.seo_title, c.cat_seo, c.cat_id, c.cat_nombre, u.u_nombre, u.u_id, p.pub_nombre, p.pub_preview, p.pub_comentario, p.pub_fecha FROM publicaciones AS p LEFT JOIN users AS u ON u.u_id = p.pub_autor LEFT JOIN categorias AS c ON c.cat_id = p.pub_categoria LIMIT '.$max,false,false);
    // recorremos el arreglo para agregarle un �ndice y usarlo con RainTPL
    while ($values = $result->fetchrow())
      {
       $resort[] = $values;
      }
    // retornamos dicho array.
    return $resort;
   }

   /**
     * obtiene la cantidad de publicaciones para armar el paginado del home.
     *
     * @param (int) $max valor m�ximo de publicaciones a listar.
     *
     * @link WIKI NO DISPONIBLE POR EL MOMENTO
     *
     * @return (int)
     */
   Public Function paginate_last_pubs()
    {
     $result = $this->db->query('SELECT count(pub_id) FROM publicaciones',false,true);
     return $result['count(pub_id)'];
    }

   /**
     * obtiene las �ltimas publicaciones de un usuario o categor�a.
     *
     * @param (int) $max valor m�ximo de publicaciones a listar.
     *
     * @link WIKI NO DISPONIBLE POR EL MOMENTO
     *
     * @return array( (int) => array( 'pub_id'=>string, 'cat_id'=>string, 'cat_nombre'=>string, 'u_nombre'=>string, 'u_id'=>(int), 'pub_nombre'=>string, 'pub_comentario'=>string, 'pub_fecha'=>(int) ) )
     */
  Public Function get_last_pubs_for($max)
   {
    // si la variable foruser est� definida
    if(isset($_GET['foruser']))
     {
      // guardamos las �ltimas publicaciones del usuario
      $result = $this->db->query('SELECT p.pub_id, p.seo_title, c.cat_seo, c.cat_id, c.cat_nombre, u.u_nombre, u.u_id, p.pub_nombre, p.pub_preview, p.pub_comentario, p.pub_fecha FROM publicaciones AS p LEFT JOIN users AS u ON u.u_id = p.pub_autor LEFT JOIN categorias AS c ON c.cat_id = p.pub_categoria WHERE p.pub_autor = ? LIMIT '.$max,array($_GET['foruser']),false);
     }
    // sino, si la variable forcat est� definida
    elseif (isset($_GET['forcat']))
     {
      // guardamos las �ltimas publicaciones de la categor�a
      $result = $this->db->query('SELECT p.pub_id, p.seo_title, c.cat_seo, c.cat_id, c.cat_nombre, u.u_nombre, u.u_id, p.pub_nombre, p.pub_preview, p.pub_comentario, p.pub_fecha FROM publicaciones AS p LEFT JOIN users AS u ON u.u_id = p.pub_autor LEFT JOIN categorias AS c ON c.cat_id = p.pub_categoria WHERE p.pub_categoria = ? LIMIT '.$max,array($_GET['forcat']),false);
     }
    // aqu� ir�a otro tipo de filtro... con un elseif

    // recorremos la lista de publicaciones para agregarle un �ndice
    while ($values = $result->fetchrow())
      {
       $resort[] = $values;
      }
    // devolvemos el array resultante.
    return $resort;
   }

   /**
     * obtiene la cantidad de publicaciones para armar el paginado del home.
     *
     * @param (int) $max valor m�ximo de publicaciones a listar.
     *
     * @link WIKI NO DISPONIBLE POR EL MOMENTO
     *
     * @return (int)
     */
  Public Function paginate_last_pubs_for()
   {
    // si la variable foruser est� definida
    if(isset($_GET['foruser']))
     {
      // obtenemos la cantidad de publicaciones del usuario
      $result = $this->db->query('SELECT count(pub_id) FROM publicaciones WHERE pub_autor = ?',array($_GET['foruser']),true);
     }
    // sino, si la variable forcat est� definida
    elseif (isset($_GET['forcat']))
     {
      // obtenemos la cantidad de publicaciones de la categor�a
      $result = $this->db->query('SELECT count(pub_id) FROM publicaciones WHERE pub_categoria = ?',array($_GET['forcat']),true);
     }
    // aqu� ir�a otro tipo de filtro... con un elseif
    return $result['count(pub_id)'];
  }

   /**
     * obtiene una publicaci�n espec�fica.
     *
     * @param (int) $id id de la publicaci�n.
     *
     * @link WIKI NO DISPONIBLE POR EL MOMENTO
     *
     * @return array( valores de la db )
     */
  Public Function get_pub($id)
   {
    // retornamos los valores de la publicaci�n con id = $id
    return $this->db->query('SELECT p.pub_id, p.seo_title, p.pub_nombre, u.u_nombre, u.u_id, c.cat_nombre, c.cat_id, c.cat_seo, p.pub_contenido, p.pub_keys, p.pub_comentario, p.pub_fecha FROM publicaciones AS p LEFT JOIN users AS u ON u.u_id = p.pub_autor LEFT JOIN categorias AS c ON c.cat_id = p.pub_categoria WHERE p.pub_id = ?',array($id),true);
   }

   /**
     * obtiene comentarios de una publicaci�n.
     *
     * @param (int) $id id de la publicaci�n.
     *
     * @link WIKI NO DISPONIBLE POR EL MOMENTO
     *
     * @return array( (int) => array( valores de la db ) )
     */
  Public Function get_comments($id)
   {
    // obtenemos la lista de comentarios
    $objeto = $this->db->query('SELECT id, name, email, web, coment, fecha FROM comentarios where pub = ?',array($id),false);
    // establecemos resort a nada
    $resort = '';
    // recorremos el array resultante agregandole un �ndice
    while ($values = $objeto->fetchrow())
      {
       $resort[] = $values;
      }
    // devolvemos el array con la lista de comentarios
    return $resort;
   }

   /**
     * obtiene publicaciones que en su contenido tengan el texto a buscar.
     *
     * @param (int) $max cantidad m�xima de publicaciones a mostrar.
     * @param string $buscar texto a buscar en la publicaci�n
     *
     * @link WIKI NO DISPONIBLE POR EL MOMENTO
     *
     * @return array( (int) => array( valores de la db ) )
     */
  Public Function Search($buscar,$max)
    {
     // filtramos la variable y lo mandamos directo, porque little db al ? le agrega '' y no funciona en search
     $tword = mysql_real_escape_string($buscar);
     // obtener la lista de publicaciones que contienen el texto a buscar
     $result = $this->db->query('SELECT p.pub_id, p.seo_title, c.cat_seo, c.cat_id, c.cat_nombre, u.u_nombre, u.u_id, p.pub_nombre, p.pub_preview, p.pub_comentario, p.pub_fecha FROM publicaciones AS p LEFT JOIN users AS u ON u.u_id = p.pub_autor LEFT JOIN categorias AS c ON c.cat_id = p.pub_categoria WHERE p.pub_contenido LIKE \'%'.$tword.'%\' LIMIT '.$max,false,false);
     // recorremos el listado y le agregamos un �ndice para el RainTPL
     while ($values = $result->fetchrow())
      {
       $resort[] = $values;
      }
     // devolvemos el arreglo final.
     return $resort;
    }

   /**
     * agrega un nuevo comentario.
     *
     * @link WIKI NO DISPONIBLE POR EL MOMENTO
     *
     * @return void
     */
  Public Function set_comment()
   {
    // seteamos el bbcode
    $this->set_bbcode();
    // creamos una instancia de la clase captcha
    $captcha = new Captcha('files/');
    // filtramos el id que ingresa
    $id = (int) $_POST['id'];
    // si los datos son correctos
    if(!empty($_POST['name']) && $id !== 0 && !empty($_POST['email']) && !empty($_POST['message']) && strlen($_POST['name'])>3 && strlen($_POST['email'])>15 && $captcha->check($_POST['captcha'])===true)
     {
      // filtramos y parseamos bbcode
      $message = nl2br(Parser::Parsear_bbcc(Parser::Parsear_bbcn(htmlspecialchars($_POST['message']))));
      // pasamos la censura de palabras desde la db
      $message = Parser::DB_BBCN_Parser ($message, array(
                                   'table'=>'censura',
                                   'column_search'=>'bad',
                                   'column_replace'=>'good'
                                   ));
      // pasamos emoticonos desde la db
      $message = Parser::DB_BBCN_Parser ($message, array(
                                   'table'=>'emoticonos',
                                   'column_search'=>'bbc',
                                   'column_replace'=>'html'
                                   ));
      // ejecutamos la consulta para agregar un comentario
      $this->db->insert('comentarios',array('Name' => htmlspecialchars($_POST['name']), 'email' => htmlspecialchars($_POST['email']), 'web' => empty($_POST['web']) ? '/' : htmlspecialchars($_POST['web']), 'coment' => $message, 'pub' => $id, 'fecha' => time()));
      // actualizamos el contador de comentarios
      mysql_query('UPDATE publicaciones SET pub_comentario = pub_comentario + 1 WHERE pub_id = '.$id);
      /*
      Aclaraci�n:
       No uso littleDB porque no se como hacer
       pub_comentario = pub_comentario + 1 sin realizar dos consultas.
       lo hablar� con Cody Roodaka para que me aconceje.
      */
     }
    // redireccionamos:
    //header('Location: index.php?action=view_pub&id='.$id);
   }

   /**
     * Configura los BBcode para los comentarios y demaces.
     *
     * @link WIKI NO DISPONIBLE POR EL MOMENTO
     *
     * @return void
     */
  Private Function set_bbcode()
   {
    // establecemos los bbc a parsear
    Parser::$BBCN = array(
                          '[b]'=>'<b>',
                          '[/b]'=>'</b>'
                          );
    // establecemos los bbc complejos a parsear
    Parser::$BBCC = array(
                          '[url=?]?[/url]'=>'<a href="$1">$2</a>',
                         );
   }

 }