<?php

 /** @I-Blog 1.0
  *  archivo de home
  */

/////// variables necesarias /////////////

// assignamos la configuraci�n general
$Core->Set_Settings();
$Core->Set_Menu();
$captcha = new Captcha('files/');
/////////////////////////////////////////

/////// inicio del c�digo de �ste controlador ////////

if(isset($_POST['posteado']))
 {
  $Core->registro($captcha);
 }

$captcha->set_value();
$captcha->create();

unset($captcha);

/////// carga del dise�o de �ste controlador /////////
// dibujamos el dise�o
$Core->rain->draw('registro');