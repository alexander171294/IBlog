<?php

  /** I-Blog 1.0
   * archivo gestor de cuentas
   */

Class Cuenta
 {

  //variable para control de db
  Protected $db = array();

  Public Function __construct($db)
   {
    $this->db = $db;
    session_start();
   }

  Static Function IsLoggued()
   {
    return isset($_SESSION['nick']) ? true : false ;
   }

  Static Function Rango()
   {
    return isset($_SESSION['rango']) ? $_SESSION['rango'] : 0 ;
   }

  Public Function login($user, $pass)
   {
    $phpass = new PHPass(8, FALSE);
    $query = $this->db->query('SELECT u_pass, u_rango, u_id, u_nombre FROM users WHERE u_nombre = ? ',array($user),true);
    if($phpass->CheckPassword($pass,$query['u_pass']) == true)
     {
      $_SESSION['u_rango']=$query['u_rango'];
      $_SESSION['u_id']=$query['u_id'];
      $_SESSION['u_nick']=$query['u_nombre'];
      header('Location: index.php');
     }
   }

  Public Function registro($user, $pass, $pass2, $captcha, $clscaptcha)
   {
    if(!empty($user) && !empty($pass) && !empty($pass2) && !empty($captcha) && $pass == $pass2 && $clscaptcha->check($captcha)===true)
     {
       if ($this->db->query('select u_nombre FROM usuarios WHERE u_nombre = ?',array($user),true)===false)
       {
        $this->db->insert('users',array('u_nombre'=>$user,'u_pass'=>$pass,'u_rango'=>'0'))
       }
     }
   }

 }