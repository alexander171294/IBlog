<?php

 /** @I-Blog 1.0
  *  archivo de home
  */

/////// variables necesarias /////////////

// assignamos la configuraci�n general
$Core->Set_Settings();
$Core->Set_Menu();
/////////////////////////////////////////

/////// inicio del c�digo de �ste controlador ////////

if(isset($_POST['posteado']))
 {
  $Core->login();
 }

/////// carga del dise�o de �ste controlador /////////
// dibujamos el dise�o
$Core->rain->draw('login');