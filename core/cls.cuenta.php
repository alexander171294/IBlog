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
 * cls.cuenta.php
 *
 * Ésta clase se encarga de gestionar las cuentas de usuario, en todo el blog.
 * es utilizada en todas las secciones, por lo que es llamada directamente en el
 * core del sistema de I-Blog.
 *
 * @author  Alexander1712 <alexander171294@live.com>
 * @license http://www.gnu.org/copyleft/gpl.html
 * @link    https://github.com/alexander171294/IBlog
 */

Class Cuenta
 {

  // variables locales de la clase //

  // @db: variable que contiene la instancia de la clase littledb
  Protected $db = null;

  /**
     * construye la clase, guardando la instancia del controlador de bases de
     * datos llamado littledb.
     *
     * @param instance $db instancia de la clase db
     *
     * @link WIKI NO DISPONIBLE POR EL MOMENTO
     *
     * @return void
     */
  Public Function __construct($db)
   {
    $this->db = $db;
    session_start();
   }

   /**
     * Verifica si el usuario inició sesión o no.
     *
     * @link WIKI NO DISPONIBLE POR EL MOMENTO
     *
     * @return Boolean (True/False)
     */
  Public Function IsLogged()
   {
    // si existe la variable de nick, retornamos true, sino false.
    return isset($_SESSION['nick']) ? true : false ;
   }

   /**
     * Ésta función devuelve el rango del usuario.
     *
     * @link WIKI NO DISPONIBLE POR EL MOMENTO
     *
     * @return (int)
     */
  Public Function Rango()
   {
    // si existe la variable de sessión, rango, devolvemos el valor, sino 0
    return isset($_SESSION['rango']) ? $_SESSION['rango'] : 0 ;
   }

   /**
     * Realiza la acción de iniciar sesión.
     *
     * @param string $user nick del usuario
     * @param string $pass contraseña del usuario
     *
     * @link WIKI NO DISPONIBLE POR EL MOMENTO
     *
     * @return void
     */
  Public Function login($user, $pass)
   {
    // creamos una instancia de phpass para controlar las password
    $phpass = new PHPass(8, FALSE);
    // hacemos una consulta para pedir la pass del usuario con ese nick
    $query = $this->db->query('SELECT u_pass, u_rango, u_id, u_nombre FROM users WHERE u_nombre = ? ',array($user),true);
    // chequeamos si la pass almacenada corresponde con la pass ingresada
    if($phpass->CheckPassword($pass,$query['u_pass']) == true)
     {
      // guardamos el rango
      $_SESSION['rango']=$query['u_rango'];
      // guardamos el id
      $_SESSION['id']=$query['u_id'];
      // guardamos el nick
      $_SESSION['nick']=$query['u_nombre'];
      // realizamos una redirección al inicio.
      header('Location: index.php');
     }
   }

   /**
     * Función que realiza la acción de registrar nuevos usuarios.
     *
     * @param string $user nick del usuario
     * @param string $pass contraseña del usuario
     * @param string $pass2 contraseña repetida
     * @param string $captcha código de captcha
     * @param instance $clscaptcha instancia de la clase que controla los captcha
     *
     * @link WIKI NO DISPONIBLE POR EL MOMENTO
     *
     * @return void
     */
  Public Function registro($user, $pass, $pass2, $captcha, $clscaptcha)
   {
    // creamos una instancia de la clase phpass
    $phpass = new PHPass(8, FALSE);
    // filtramos html
    $user = htmlspecialchars(strtolower(trim($user)));
    // guardamos el hash de la password
    $fpass = $phpass->HashPassword($pass);
    // validamos si los datos son correctos
    if(!empty($user) && !empty($pass) && !empty($pass2) && !empty($captcha) && $pass == $pass2 && $clscaptcha->check($captcha)===true)
     {
      // verificamos que no exista un user con el nick elegido
      if ($this->db->query('select u_nombre FROM users WHERE u_nombre = ?',array($user),true)===false)
       {
        // insertamos los valores correspondientes
        $this->db->insert('users',array('u_nombre'=>$user,'u_pass'=>$fpass,'u_rango'=>'0'));
        // realizamos la redirección
        header('Location: /index.php');
       }
     }
   }

 }